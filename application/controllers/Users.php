<?php

    defined('BASEPATH') OR exit('No direct script access allowed');
    class Users extends CI_Controller {

        public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
    }
 
    public function index()
    {
        $data = $this->load_user_session();
        $data['users'] = $this->user->get_users();
        $data['user_id'] = $this->session->userdata('id');
        $this->load->view('users',$data);
    }

    public function new(){
        $data = $this->load_user_session();
        $data["errors"] = array();
        $this->load->view('new_user',$data);
    }
 
    public function view($slug = NULL)
    {
        $data['user'] = $this->user->get_news($slug);
        
        if (empty($data['user']))
        {
            show_404();
        }
 
        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete_user($id)
    {   
        if (empty($id))
        {
            show_404();
        }
                
        $user = $this->user->get_user($id);
        
        $this->user->delete_user($id);        
        redirect( base_url() . 'index.php/users');        
    }

    function create_new_user() {

        $userInfo = $this->input->post(null,true);
        if(isset($userInfo["isAdmin"])){
            $userInfo["isAdmin"] = 1;
        }
        else{
            $userInfo["sAdmin"] = 0;
        }
        if( count($userInfo) ) {
          $this->load->model('user');
          $error = $this->validate_user($userInfo);
          if(count($error) == 0)
            $saved = $this->user->create_new_user($userInfo);
        }

        if ( isset($saved) && $saved ) {
           redirect( base_url() . 'index.php/users'); 
        }
        else{
            $data = $this->load_user_session();
            $data["errors"] = $error;
            $this->load->view('new_user',$data);
        }
    }

    function edit_user($id){
        $data = $this->load_user_session();
        $data['user'] = $this->user->get_user($id)[0];
        $data['errors'] = array();
        $data['id'] = $id;
        $this->load->view('edit_user',$data);
    }

    function update_user($id){
        $userInfo = $this->input->post(null,true);

        if(isset($userInfo["isAdmin"])){
            $userInfo["isAdmin"] = 1;
        }
        else{
            $userInfo["sAdmin"] = 0;
        }
        if( count($userInfo) ) {
          $this->load->model('user');
          $error = $this->validate_user($userInfo);
          if(count($error) == 0)
            $saved = $this->user->update_user($userInfo, $id);
        }

        if ( isset($saved) && $saved ) {
           redirect( base_url() . 'index.php/users'); 
        }
        else{
            $data = $this->load_user_session();
            $data["errors"] = $error;
            $data['user'] = $this->user->get_user($id)[0];
            $data['id'] = $id;
            $this->load->view('edit_user',$data);
        }
    }


    function validate_user($user){
        $error = array();
        if($user["email"] ==""){
            array_push($error, "Field email can not be empty.");
        }
        if($user["password"] ==""){
            array_push($error, "Field password can not be empty.");
        }
        if($user["passwordConfirmation"] ==""){
            array_push($error, "Field password confirmation can not be empty.");
        }
        if($user["password"] != $user["passwordConfirmation"]){
            array_push($error, "Password not match.");
        }
        return $error;
    }

    function load_user_session(){
        $user_id = $this->session->userdata('id');
        $is_admin = $this->session->userdata('isAdmin');
        $data['is_admin'] = $is_admin;
        $data['email'] = $this->session->userdata('email');
        $data['name'] = $this->session->userdata('name');
        return $data;
    }
}

?>