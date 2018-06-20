<?php

class User extends CI_Model {

    var $details;

    function get_users(){
      $users = $this->db->get('user');
      return $users->result();
    }

    function get_user($id){
      $this->db->select("*");
      $this->db->from("user");
      $this->db->where("id", $id);
      $users = $this->db->get();
      return $users->result();
    }

    function delete_user($id){
      $this->db->delete('user', array('id' => $id));
    }

    function validate_user( $email, $password ) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->from('user');
        $this->db->where('email',$email );
        $this->db->where( 'password', sha1($password) );
        $login = $this->db->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if ( is_array($login) && count($login) == 1 ) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
        }

        return false;
    }

    function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        $this->session->set_userdata( array(
                'id'=>$this->details->id,
                'name'=> $this->details->firstName . ' ' . $this->details->lastName,
                'email'=>$this->details->email,
                'avatar'=>$this->details->avatar,
                'tagline'=>$this->details->tagline,
                'isAdmin'=>$this->details->isAdmin,
                'teamId'=>$this->details->teamId,
                'isLoggedIn'=>true
            )
        );
    }

    function  create_new_user( $userData ) {
      $data['firstName'] = $userData['firstName'];
      $data['lastName'] = $userData['lastName'];
      $data['isAdmin'] = (int) $userData['isAdmin'];
      $data['email'] = $userData['email'];
      $data['password'] = sha1($userData['password']);
      return $this->db->insert('user',$data);
    }

    function  update_user( $userData, $id) {
      $data['firstName'] = $userData['firstName'];
      $data['lastName'] = $userData['lastName'];
      $data['isAdmin'] = (int) $userData['isAdmin'];
      $data['email'] = $userData['email'];
      $data['password'] = sha1($userData['password']);
      $this->db->where("id", $id);
      return $this->db->update('user',$data);
    }

    public function update_tagline( $user_id, $tagline ) {
      $data = array('tagline'=>$tagline);
      $result = $this->db->update('user', $data, array('id'=>$user_id));
      return $result;
    }

    private function getAvatar() {
      $avatar_names = array();

      foreach(glob('assets/img/avatars/*.png') as $avatar_filename){
        $avatar_filename =   str_replace("assets/img/avatars/","",$avatar_filename);
        array_push($avatar_names, str_replace(".png","",$avatar_filename));
      }

      return $avatar_names[array_rand($avatar_names)];
    }
}
