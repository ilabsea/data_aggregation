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
        $data['users'] = $this->user->get_users();
 
        $this->load->view('users',$data);
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
    
    public function delete()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id))
        {
            show_404();
        }
                
        $user = $this->user->get_user_by_id($id);
        
        $this->user->delete_user($id);        
        redirect( base_url() . 'index.php/users');        
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

}

?>