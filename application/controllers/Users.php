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
        $user_id = $this->session->userdata('id');
        $is_admin = $this->session->userdata('isAdmin');
        $data['is_admin'] = $is_admin;
        $data['email'] = $this->session->userdata('email');
        $data['name'] = $this->session->userdata('name');
        $data['users'] = $this->user->get_users();
        $data['user_id'] = $user_id;
        $this->load->view('users',$data);
    }

    public function new(){
        $user_id = $this->session->userdata('id');
        $is_admin = $this->session->userdata('isAdmin');
        $data['is_admin'] = $is_admin;
        $data['email'] = $this->session->userdata('email');
        $data['name'] = $this->session->userdata('name');
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
        print_r($userInfo);
        if( count($userInfo) ) {
          $this->load->model('user');
          $saved = $this->user->create_new_user($userInfo);
        }

        if ( isset($saved) && $saved ) {
           redirect( base_url() . 'index.php/users'); 
        }
    }

    function edit_user($id){
        $user_id = $this->session->userdata('id');
        $is_admin = $this->session->userdata('isAdmin');
        $data['is_admin'] = $is_admin;
        $data['email'] = $this->session->userdata('email');
        $data['name'] = $this->session->userdata('name');
        $data['user'] = $this->user->get_user($id);
        $this->load->view('edit_user',$data);
    }

    function update_user(){

    }

}

?>