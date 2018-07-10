<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    if( !$this->session->userdata('isLoggedIn') ) {
        redirect('/login/show_login');
    }
  }

  function show_dashboard(){
    $level  = $this->config->item("level");
    if($level == 'CMA'){
      redirect('/CMA/show_dashboard');
    }
    if($level == 'Provincial'){
      redirect('/Provincial/show_dashboard');
    }
    if($level == 'National'){
      redirect('/National/show_dashboard');
    }
    
  }
}