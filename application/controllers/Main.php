<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    if( !$this->session->userdata('isLoggedIn') ) {
        redirect('/login/show_login');
    }
  }

  /**
   * This is the controller method that drives the application.
   * After a user logs in, show_main() is called and the main
   * application screen is set up.
   */
  function show_main() {
    $this->load->model('postrequest');

    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');

    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');


    $this->load->view('main',$data);
  }

  function show_validation($file_name){
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');

    $data["file_name"] = $file_name;
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');
    $validation_path = $this->config->item('import_url')."/".$file_name;
    $info_path = $this->config->item('info_url');
    $response = $this->httpPost($validation_path, array("file_name" => $file_name));
    $data["response"] = json_decode($response, true);
    $info_data = $this->httpPost($info_path, array());
    $data["record_info"] = json_decode($info_data, true);
    $this->load->view('validation',$data);

  }

  function show_import($file_name){
    $excluded_case_ids = $_POST["excluded_case_ids"];
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data["file_name"] = $file_name;
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');
    $info_path = $this->config->item('info_url');
    $info_data = $this->httpPost($info_path, array("excluded_case_ids" => $excluded_case_ids));
    $data["record_info"] = json_decode($info_data, true);
    $this->load->view('import',$data);

  }
  
  function create_new_user() {
    $userInfo = $this->input->post(null,true);

    if( count($userInfo) ) {
      $this->load->model('user');
      $saved = $this->user->create_new_user($userInfo);
    }

    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }

  function update_tagline() {
    $new_tagline = $this->input->post('message');
    $user_id = $this->session->userdata('id');

    if( isset($new_tagline) && $new_tagline != "" ) {
      $this->load->model('user');
      $saved = $this->user->update_tagline($user_id, $new_tagline);
    }

    if ( isset($saved) && $saved ) {
      $this->session->set_userdata(array('tagline'=>$new_tagline));
      echo "success";
    }
  }

  public function httpPost($url, $data){
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
  }

}
?>
