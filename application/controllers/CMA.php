<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class CMA extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    if( !$this->session->userdata('isLoggedIn') ) {
        redirect('/login/show_login');
    }
  }

  function show_list_adult_need_confirm(){
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');

    $data["record_need_confirmation"] = $this->get_record_need_confirmation(0,180);
    $data["record_need_confirmation_within_7"] = $this->get_record_need_confirmation(0,7);
    $data["record_need_confirmation_8_to_30"] = $this->get_record_need_confirmation(8,30);
    $data["record_need_confirmation_31_to_90"] = $this->get_record_need_confirmation(31,90);
    $data["record_need_confirmation_is_pregnant"] = $this->get_record_need_confirmation_and_pregnant();

    $this->load->view('Cma/list_adult_need_confirm',$data);
  }

  function show_list_adult_need_enroll(){
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');

    $data["record_need_enrollment"] = $this->get_record_need_enrollment(0,180);
    $data["record_need_enrollment_within_7"] = $this->get_record_need_enrollment(0,7);
    $data["record_need_enrollment_8_to_30"] = $this->get_record_need_enrollment(8,30);
    $data["record_need_enrollment_31_to_90"] = $this->get_record_need_enrollment(31,90);
    $data["record_need_enrollment_is_pregnant"] = $this->get_record_need_enrollment_and_pregnant();

    $this->load->view('Cma/list_adult_need_enroll',$data);
  }

  function show_dashboard(){
  	$user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');

    $data["record_need_confirmation"] = $this->get_record_need_confirmation(0,180);
    $data["record_need_confirmation_within_7"] = $this->get_record_need_confirmation(0,7);
    $data["record_need_confirmation_8_to_30"] = $this->get_record_need_confirmation(8,30);
    $data["record_need_confirmation_31_to_90"] = $this->get_record_need_confirmation(31,90);
    $data["record_need_confirmation_is_pregnant"] = $this->get_record_need_confirmation_and_pregnant();


    $data["deliver_within_two_week"] = $this->get_deliver_within_two_week();
    $data["missing_actual_dilivery"] = $this->get_missing_actual_dilivery();
    $data["missing_birth_outcome"] = $this->get_missing_birth_outcome();

    $data["record_need_enrollment"] = $this->get_record_need_enrollment(0,180);
    $data["record_need_enrollment_within_7"] = $this->get_record_need_enrollment(0,7);
    $data["record_need_enrollment_8_to_30"] = $this->get_record_need_enrollment(8,30);
    $data["record_need_enrollment_31_to_90"] = $this->get_record_need_enrollment(31,90);
    $data["record_need_enrollment_is_pregnant"] = $this->get_record_need_enrollment_and_pregnant();

    $this->load->view('Cma/dashboard',$data);
  }

  function get_record_need_confirmation_and_pregnant(){
    $this->load->database();
    $result = $this->db->query("select tblfirsttest.CaseID as case_id, tblfirsttest.PlaceTest as place_test, tblfirsttest.NamePlace as name_place, tblpersonal.Name as name, tblcontact.Phone as phone_number from tblfirsttest INNER JOIN tblpersonal ON tblpersonal.CaseID=tblfirsttest.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.TypeClient = 'Pregnant Women' and DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW() and tblfirsttest.CaseID NOT in (select CaseID from tblregoi);");
    return $result->result_array();
  }

  function get_record_need_enrollment_and_pregnant(){
    $this->load->database();
    $result = $this->db->query("select tblconfirm.CaseID as case_id, tblconfirm.Vcctname as vcct_name, tblconfirm.VcctCode as vcct_code, tblpersonal.Name as name, tblcontact.phone as phone_number from tblconfirm INNER JOIN tblfirsttest ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblpersonal ON tblpersonal.CaseID=tblconfirm.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblconfirm.CaseID WHERE `tblfirsttest`.TypeClient = 'Pregnant Women' and `tblconfirm`.Dat < NOW() and `tblconfirm`.Dat BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY) and tblconfirm.CaseID NOT in (select CaseID from tblregoi);");
    return $result->result_array();
  }

  function get_record_need_enrollment($from, $to){
    $this->load->database();
    $result = $this->db->query("select tblconfirm.CaseID as case_id, tblconfirm.Vcctname as vcct_name, tblconfirm.VcctCode as vcct_code, tblpersonal.Name as name, tblcontact.phone as phone_number from tblconfirm INNER JOIN tblpersonal ON tblpersonal.CaseID=tblconfirm.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblconfirm.CaseID WHERE result='Positive' and dat BETWEEN (NOW() - INTERVAL $to DAY) AND (NOW() + INTERVAL $from DAY) and tblconfirm.CaseID NOT in (select CaseID from tblregoi);");
    return $result->result_array();
  }

  function get_record_need_confirmation($from, $to){
    $this->load->database();
    $result = $this->db->query("select tblfirsttest.CaseID as case_id, tblfirsttest.PlaceTest as place_test, tblfirsttest.NamePlace as name_place, tblpersonal.Name as name, tblcontact.Phone as phone_number from tblfirsttest INNER JOIN tblpersonal ON tblpersonal.CaseID=tblfirsttest.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblfirsttest.CaseID WHERE DatTest BETWEEN (NOW() - INTERVAL $to DAY) AND (NOW() + INTERVAL $from DAY) and tblfirsttest.CaseID NOT in (select CaseID from tblconfirm);");
    return $result->result_array();
  }

  function get_deliver_within_two_week(){
    $this->load->database();
    $result = $this->db->query("select * from tblpwpregant WHERE DaExPreg  BETWEEN NOW() AND (NOW() + INTERVAL 14 DAY);");
    return $result->result_array(); 
  }

  function get_missing_birth_outcome(){
    $this->load->database();
    $result = $this->db->query("select * from tblpwpregant WHERE DaExPreg < NOW() and DaExPreg BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY) and CaseID NOT in (select CaseID from tblpwdelivery);");
    return $result->result_array(); 
  }

  function get_missing_actual_dilivery(){
    $this->load->database();
    $result = $this->db->query("select * from tblpwpregant INNER JOIN tblpwdelivery ON tblpwpregant.CaseID=tblpwdelivery.CaseID WHERE `tblpwpregant`.DaExPreg < NOW() and `tblpwpregant`.DaExPreg BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY);");
    return $result->result_array(); 
  }
}