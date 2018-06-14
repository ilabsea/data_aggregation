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

  function show_list_mother(){
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');

    $data["deliver_within_two_week"] = $this->get_deliver_within_two_week();
    $data["missing_actual_dilivery"] = $this->get_missing_actual_dilivery();
    $data["missing_birth_outcome"] = $this->get_missing_birth_outcome();

    $this->load->view('Cma/list_mother',$data);
  }

  function show_list_babies(){
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');

    $data["record_all_babies"] = $this->get_child_last_6_months();
    foreach ($data["record_all_babies"] as &$value) {
      
    }

    $this->load->view('Cma/list_babies',$data);
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

    $data["record_child_need_pcr_test"] = $this->get_child_need_pcr_test();
    $data["record_child_need_confirmation_test"] = $this->get_child_need_confirmation_test();
    $data["record_child_not_enroll_in_pac"] = $this->get_child_not_enroll_in_pac();
    $data["record_child_need_enroll_pac_positive"] = $this->get_child_need_enroll_pac_positive();
    $data["record_child_need_post_exposure_treatment"] = $this->get_child_need_post_exposure_treatment();

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
    $result = $this->db->query("select tblpwpregant.CaseID as case_id, tblppregnancy.ARTnum as art, tblpwpregant.Place as place, tblpwpregant.DaExPreg as exp_date, tblpersonal.Name as name, tblcontact.Phone as phone_number from tblpwpregant INNER JOIN tblpersonal ON tblpersonal.CaseID=tblpwpregant.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblpwpregant.CaseID INNER JOIN tblppregnancy ON tblppregnancy.CaseID=tblpwpregant.CaseID WHERE tblpwpregant.DaExPreg BETWEEN NOW() AND (NOW() + INTERVAL 14 DAY);");
    return $result->result_array(); 
  }

  function get_missing_birth_outcome(){
    $this->load->database();
    $result = $this->db->query("select tblpwpregant.CaseID as case_id, tblppregnancy.ARTnum as art, tblpwpregant.Place as place, tblpwpregant.DaExPreg as exp_date, tblpersonal.Name as name, tblcontact.Phone as phone_number, tblpwdelivery.Dadelivery as delivery_date from tblpwpregant INNER JOIN tblpersonal ON tblpersonal.CaseID=tblpwpregant.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblpwpregant.CaseID INNER JOIN tblppregnancy ON tblppregnancy.CaseID=tblpwpregant.CaseID INNER JOIN tblpwdelivery ON tblpwdelivery.CaseID=tblpwpregant.CaseID WHERE (tblpwdelivery.ResultPreg = 0 OR tblpwdelivery.ResultPreg = -1) and tblpwpregant.DaExPreg < NOW() and tblpwpregant.DaExPreg BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY) ;");
    return $result->result_array(); 
  }

  function get_missing_actual_dilivery(){
    $this->load->database();
    $result = $this->db->query("select tblpwpregant.CaseID as case_id, tblppregnancy.ARTnum as art, tblpwpregant.Place as place, tblpwpregant.DaExPreg as exp_date, tblpersonal.Name as name, tblcontact.Phone as phone_number, tblpwdelivery.Dadelivery as delivery_date, tblpwdelivery.ResultPreg as result from tblpwpregant INNER JOIN tblpersonal ON tblpersonal.CaseID=tblpwpregant.CaseID INNER JOIN tblcontact ON tblcontact.CaseID=tblpwpregant.CaseID INNER JOIN tblppregnancy ON tblppregnancy.CaseID=tblpwpregant.CaseID INNER JOIN tblpwdelivery ON tblpwdelivery.CaseID=tblpwpregant.CaseID WHERE tblpwdelivery.Dadelivery = '1900-01-01' and  `tblpwpregant`.DaExPreg < NOW() and `tblpwpregant`.DaExPreg BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY);");
    return $result->result_array(); 
  }

  function get_child_need_pcr_test(){
    $this->load->database();
    $result_5_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN NOW() AND (NOW() - INTERVAL 35 DAY) and tblpwdelivery.ResultPreg = 3 AND tblpac.CodePac NOT in (select CodePac from tblpactest);");
    $result_5_weeks = $result_5_weeks->result_array();

    $result_6_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 35 DAY) AND (NOW() - INTERVAL 119 DAY) and tblpwdelivery.ResultPreg = 3 AND (tblpac.CodePac NOT in (select CodePac from tblpactest) OR tblpac.CodePac in (select CodePac from tblpactest where tblpactest.typetest='DNA PCR at birth'));");
    $result_6_weeks = $result_6_weeks->result_array();

    $result_18_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 119 DAY) AND (NOW() - INTERVAL 900 DAY) and tblpwdelivery.ResultPreg = 3 AND (tblpac.CodePac NOT in (select CodePac from tblpactest) OR tblpac.CodePac in (select CodePac from tblpactest where tblpactest.typetest='DNA PCR at birth'));");
    $result_18_weeks = $result_18_weeks->result_array();

    $result = array_merge($result_5_weeks,$result_6_weeks,$result_18_weeks);

    return $result; 
  }

  function get_child_need_confirmation_test(){
    $this->load->database();
    $result_5_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID INNER JOIN tblpactest ON tblpactest.CodePac=tblpac.CodePac WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN NOW() AND (NOW() - INTERVAL 35 DAY) and tblpwdelivery.ResultPreg = 3 AND tblpactest.result='Positive' AND tblpactest.typetest='DNA PCR at birth' AND tblpac.CodePac not in (select CodePac from tblpactest where typetest = 'DNA Confirm' and result='Positive')");
    $result_5_weeks = $result_5_weeks->result_array();

    $result_6_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID INNER JOIN tblpactest ON tblpactest.CodePac=tblpac.CodePac WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 35 DAY) AND (NOW() - INTERVAL 119 DAY) and tblpwdelivery.ResultPreg = 3 AND tblpactest.result='Positive' AND tblpactest.typetest='DNA PCR' AND tblpac.CodePac not in (select CodePac from tblpactest where tblpactest.typetest = 'DNA Confirm' and result='Positive');");
    $result_6_weeks = $result_6_weeks->result_array();

    $result_18_weeks = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpac on tblpchild.CaseID = tblpac.CaseID INNER JOIN tblpactest ON tblpactest.CodePac=tblpac.CodePac WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 119 DAY) AND (NOW() - INTERVAL 900 DAY) and tblpwdelivery.ResultPreg = 3 AND tblpactest.result='Positive' AND tblpactest.typetest='DNA PCR' AND tblpac.CodePac not in (select CodePac from tblpactest where tblpactest.typetest = 'DNA Confirm' and result='Positive');");
    $result_18_weeks = $result_18_weeks->result_array();

    $result = array_merge($result_5_weeks,$result_6_weeks,$result_18_weeks);
    return $result;
  }

  function get_child_not_enroll_in_pac(){
    $this->load->database();
    $result = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW()  and tblpwdelivery.ResultPreg = 3 AND tblpchild.CaseID NOT in (select CaseID from tblpac);");
    return $result->result_array(); 
  }

  function get_child_need_enroll_pac_positive(){
    $this->load->database();
    $result = $this->db->query("select * from tblpwpregant INNER JOIN tblpwdelivery ON tblpwpregant.CaseID=tblpwdelivery.CaseID WHERE `tblpwpregant`.DaExPreg < NOW() and `tblpwpregant`.DaExPreg BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW();");
    return $result->result_array(); 
  }

  function get_child_need_post_exposure_treatment(){
    $this->load->database();
    $result = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN NOW() AND (NOW() - INTERVAL 180 DAY) and tblpwdelivery.ResultPreg = 3 AND (tblpwdelivery.Pacsyrup = -1 OR tblpwdelivery.Pacsyrup = 3);");
    return $result->result_array(); 
  }

  function get_child_last_6_months(){
    $this->load->database();
    // $result = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpersonal ON tblpersonal.CaseID=tblpchild.CaseID LEFT JOIN tblcontact ON tblcontact.CaseID=tblpchild.McaseID LEFT JOIN tblpac ON tblpchild.CaseID=tblpac.CaseID LEFT JOIN tblpactest on tblpac.CodePac = tblpac.CodePac LEFT JOIN tblpwpacend on tblpchild.CaseID=tblpwpacend.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 3180 DAY) AND NOW() ;");
    $result = $this->db->query("select * from tblpchild INNER join tblpwdelivery ON tblpchild.McaseID = tblpwdelivery.CaseID INNER JOIN tblpersonal ON tblpersonal.CaseID=tblpchild.CaseID LEFT JOIN tblcontact ON tblcontact.CaseID=tblpchild.McaseID LEFT JOIN tblpac ON tblpchild.CaseID=tblpac.CaseID WHERE tblpwdelivery.Dadelivery != '1900-01-01' AND tblpwdelivery.Dadelivery BETWEEN (NOW() - INTERVAL 580 DAY) AND NOW() ;");
    return $result->result_array(); 
  }
}