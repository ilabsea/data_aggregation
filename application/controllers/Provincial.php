<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Provincial extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    if( !$this->session->userdata('isLoggedIn') ) {
        redirect('/login/show_login');
    }
  }

  function show_risk(){
  	$user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');
    $data["type_client"] = $this->get_client_type();
    $data["total"] = 0;
    $data["type"] = array();
    foreach($data['type_client'] as $type){
      $data["type"][$type["TypeClient"]] = $this->get_tester_by_client_type($type["TypeClient"]);
      $data["total"] = $data["total"] + $data["type"][$type["TypeClient"]][0]["total"];
    }
    $data["total_confirm"] = $this->get_tester_confirm();
    $data = $this->get_confirm_test_as_od("Battambang", $data,12);
    $data = $this->get_confirm_test_as_province("Battambang", $data,12);
    $this->load->view('Provincial/risk',$data);
  }

  function get_confirm_test_as_od($province_name, $data, $from_number_of_month){
    $ods = $this->get_od_by_provinces($province_name);
    $current_month = date('m');
    $list_months = array_reverse($this->get_list_month($current_month, $from_number_of_month));
    $data["list_months"] = $list_months;
    foreach($ods as $od){
      $current_year = $this->get_start_year($from_number_of_month);
      $data["graph"][$od["ODname"]] = array();
      $tmp_total = 0;
      $total_mv_range = 0;
      $mv_range = 0;
      for($i=0; $i<$from_number_of_month; $i++){
        $end_month_day = $this->day_in_month($current_year, $list_months[$i]);
        $data["graph"][$od["ODname"]][$list_months[$i]]= $this->get_tester_confirm_by_OD($od["ODname"], "$current_year-$list_months[$i]-01", "$current_year-$list_months[$i]-$end_month_day");
        $tmp_total = $tmp_total + $data["graph"][$od["ODname"]][$list_months[$i]][0]["total"];
        $total_mv_range = $total_mv_range + (abs($data["graph"][$od["ODname"]][$list_months[$i]][0]["total"] - $mv_range));
        $mv_range = $data["graph"][$od["ODname"]][$list_months[$i]][0]["total"];
        if($list_months[$i] ==  12)
          $current_year = $current_year + 1;
      }
      $central_line = $tmp_total / $from_number_of_month;
      $avg_moving_range = $total_mv_range /$from_number_of_month;
      $data["graph"][$od["ODname"]]["central_line"] = $central_line;
      $data["graph"][$od["ODname"]]["upper_line"] = $central_line + ($avg_moving_range * 2.66);
      $data["graph"][$od["ODname"]]["lower_line"] = $central_line - ($avg_moving_range * 2.66);;
    }
    return $data;
  }

  function get_confirm_test_as_province($province_name, $data, $from_number_of_month){
    $ods = $this->get_od_by_provinces($province_name);
    $current_month = date('m');
    $current_year = $this->get_start_year($from_number_of_month);
    $list_months = array_reverse($this->get_list_month($current_month, $from_number_of_month));
    $data["list_months"] = $list_months;
    $tmp_total = 0;
    $total_mv_range = 0;
    $mv_range = 0;
    for($i=0; $i<$from_number_of_month; $i++){
      $end_month_day = $this->day_in_month($current_year, $list_months[$i]);

      $data["graph_province"][$province_name][$list_months[$i]]= $this->get_tester_confirm_by_province($province_name, "$current_year-$list_months[$i]-01", "$current_year-$list_months[$i]-$end_month_day");
      $tmp_total = $tmp_total + $data["graph_province"][$province_name][$list_months[$i]][0]["total"];
      $total_mv_range = $total_mv_range + (abs($data["graph_province"][$province_name][$list_months[$i]][0]["total"] - $mv_range));
      $mv_range = $data["graph_province"][$province_name][$list_months[$i]][0]["total"];
      if($list_months[$i] ==  12)
        $current_year = $current_year + 1;
    }
    $central_line = $tmp_total / $from_number_of_month;
    $avg_moving_range = $total_mv_range /$from_number_of_month;
    $data["graph_province"][$province_name]["central_line"] = $central_line;
    $data["graph_province"][$province_name]["upper_line"] = $central_line + ($avg_moving_range * 2.66);
    $data["graph_province"][$province_name]["lower_line"] = $central_line - ($avg_moving_range * 2.66);
    return $data;
  }

  function get_client_type(){
    $this->load->database();
    $result = $this->db->query("select TypeClient from tblfirsttest WHERE DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW() GROUP BY TypeClient");
    return $result->result_array();
  }

  function get_provinces(){
    $this->load->database();
    $result = $this->db->query("select * from tblprovince");
    return $result->result_array();
  }

  function get_od_by_provinces($province_name){
    $this->load->database();
    $result = $this->db->query("select ODname from tblcenter where Province='$province_name'");
    return $result->result_array();
  }

  function get_current_province($name = "Battambang"){
    $this->load->database();
    $result = $this->db->query("select * from tblprovince WHERE ProvinceEng='$name'");
    return $result->result_array();
  }

  function get_tester_by_client_type($type){
    $this->load->database();
    $result = $this->db->query("select count(*) as total from tblfirsttest WHERE TypeClient='" . $type . "' AND DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW()");
    return $result->result_array();
  }

  function get_tester_confirm(){
    $this->load->database();
    $result = $this->db->query("select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW()");
    return $result->result_array();
  }

  function get_tester_confirm_by_province($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN '$from' AND '$to'";
    $result = $this->db->query($query);
    // print_r($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_OD($od_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.ODname='$od_name' AND tblfirsttest.DatTest BETWEEN '$from' AND '$to';";
    $result = $this->db->query($query);
    // print_r($query);
    return $result->result_array();
  }

  function get_list_month_name(){
    return ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  }

  function day_in_month($year, $month){
    if ($year % 4 == 0)
      $day_list = [31,29,31,30,31,30,31,31,30,31,30,31];
    else
      $day_list = [31,28,31,30,31,30,31,31,30,31,30,31];  
    return $day_list[$month-1];
  }

  function get_list_month($from_month, $range){
    $list = array();
    for($i=0; $i<$range ; $i++){
      $m = (string)$from_month;
      array_push($list, sprintf("%02d", $from_month));
      $from_month = $from_month - 1 ;
      if($from_month == 0)
        $from_month = 12;
    }
    return $list;
  }

  function get_start_year($from_number_of_month){
    $current_month = date('m');
    $current_year = date('Y');
    $decrease = 0;
    $list_months = $this->get_list_month($current_month, $from_number_of_month);
    $start_month = $list_months[0];
    for($i=1; $i< count($list_months); $i++){
      $start_month = $start_month - 1;
      if($start_month == 0){
        $decrease = $decrease + 1;
        $start_month = 12;
      }
    }
    return $current_year - $decrease;
  }

}