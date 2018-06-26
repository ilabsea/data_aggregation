<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class National extends CI_Controller{

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
    $data["provinces"] = $this->get_provinces();
    $data["total"] = 0;
    $data["type"] = array();
    $data["country"] = "Cambodia";
    $data["provinces"] = $this->get_provinces();
    $data["unusual_trend"] = array();
    $data["total_in_country"] = $this->get_tester_confirm_by_country("NOW() - INTERVAL 180 DAY", "NOW()");
    $data = $this->get_confirm_test_as_country($data,12);
    foreach($data["provinces"] as $province){
      $province_name = $province["ProvinceEng"];
      $data = $this->get_confirm_test_as_province($province_name, $data,12);
      
    }
    // $data["total_confirm"] = $this->get_tester_confirm_by_province($data["province"], "NOW() - INTERVAL 180 DAY", "NOW()");
    
    $data = $this->get_infected_percentage_in_country_as_sex($data);
    $data = $this->get_infected_percentage_in_country_as_clientType($data);
    $data = $this->get_infected_percentage_in_provinces($data["provinces"], $data);
    $data = $this->get_infected_from_every_province($data);
    $data = $this->get_infected_percentage_in_country_as_clientType_by_quater($data, '2017');
    $data = $this->get_not_confirm_test_in_country($data["provinces"], $data,26);
    $data = $this->get_not_enrollment_test_in_country($data["provinces"], $data,26);
    $data = $this->get_not_avg_linkage_in_country($data["provinces"], $data,26);
    // $data = $this->get_not_enroll_test_as_province($data["province"], $data,3);
    // $data = $this->get_duration_link_confirmed($data["province"], $data,3);
    // $data = $this->get_duration_link_enroll($data["province"], $data,3);
    // $data = $this->get_not_confirm_test_in_province_as_sex($data["province"], $data,33);
    // $data = $this->get_not_confirm_test_in_province_as_client_type($data["province"], $data,33);
    // $data = $this->get_not_enroll_test_in_province_as_sex($data["province"], $data,33);
    // $data = $this->get_not_enroll_test_in_province_as_client_type($data["province"], $data,33);
    print_r($data);
    // exit;
    $this->load->view('National/dashboard',$data);
  }

  function get_not_avg_linkage_in_country($provinces, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    foreach ($provinces as $province) {
      $province_name = $province["ProvinceEng"];
      $result = $this->get_tester_enroll_by_province($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
      $total = 0;
      $num = 0;
      foreach($result as $rec){
        $total = $total + 1;
        $from = new DateTime($rec["Dat"]);
        $to = new DateTime($rec["DatReg"]);
        $num  = $num + date_diff($to,$from)->format("%d");
      }
      if($total == 0){
        $data["reg_oi"][$province_name] = 0;
      }
      else{
        $data["reg_oi"][$province_name] = $num/$total;
      }
    }
    return $data;
  }

  function get_infected_from_every_province($data){
    $result = $this->get_number_confirm_test_positive_as_province("NOW() - INTERVAL 365 DAY", "NOW()");
    $data["number_infected"] = array();
    foreach ($result as $key => $value) {
      $data["number_infected"][$value["Province"]] = $value["total"];
    }
    return $data ;
  }

  

  function get_not_confirm_test_in_province_as_sex($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $data["reason_not_confirm_as_sex"] = $this->get_tester_not_confirm_in_province_as_sex($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    return $data;
  }

  function get_not_confirm_test_in_province_as_client_type($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $list = $this->get_tester_not_confirm_in_province_as_client_type($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["reason_not_confirm_as_type"] = array();
    foreach ($list as $key => $value) {
      $data["reason_not_confirm_as_type"][$value["TypeClient"]] = $value["total"];
    }
    return $data;
  }

  function get_not_enroll_test_in_province_as_sex($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $data["reason_not_enroll_as_sex"] = $this->get_tester_not_enroll_in_province_as_sex($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    return $data;
  }

  function get_not_enroll_test_in_province_as_client_type($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $list = $this->get_tester_not_enroll_in_province_as_client_type($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["reason_not_enroll_as_type"] = array();
    foreach ($list as $key => $value) {
      $data["reason_not_enroll_as_type"][$value["TypeClient"]] = $value["total"];
    }
    return $data;
  }

  function get_duration_link_confirmed($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $data["duration_confirmed"]["one_to_two_days"] = $this->get_tester_confirmed_by_province_within_one_two_days($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["duration_confirmed"]["three_to_seven_days"] = $this->get_tester_confirmed_by_province_from_three_to_seven_days($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["duration_confirmed"]["more_than_seven_days"] = $this->get_tester_confirmed_by_province_more_than_seven_days($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    return $data;
  }

  function get_duration_link_enroll($province_name, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    $data["duration_enroll"]["one_to_two_days"] = $this->get_tester_enroll_by_province_within_one_two_days($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["duration_enroll"]["three_to_seven_days"] = $this->get_tester_enroll_by_province_within_three_to_seven_day($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    $data["duration_enroll"]["more_than_seven_days"] = $this->get_tester_enroll_by_province_more_than_seven_day($province_name,"NOW() - INTERVAL $day DAY", "NOW()");

    return $data;
  }

  function get_not_confirm_test_in_country($provinces, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    foreach ($provinces as $province) {
      $province_name = $province["ProvinceEng"];
      $data["reason_not_confirm"][$province_name] = $this->get_tester_not_confirm_by_province($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    }
    return $data;
  }

  function get_not_enrollment_test_in_country($provinces, $data, $from_number_of_month){
    $day = 30 * $from_number_of_month;
    foreach ($provinces as $province) {
      $province_name = $province["ProvinceEng"];
      $data["reason_not_enrollment"][$province_name] = $this->get_tester_not_enroll_by_province($province_name,"NOW() - INTERVAL $day DAY", "NOW()");
    }
    return $data;
  }

  function get_infected_percentage_in_od($province_name, $data){
    $ods = $this->get_od_by_provinces($province_name);
    foreach($ods as $od){
      $client_types = $this->get_client_type();
      $total_in_od = $this->get_tester_confirm_by_OD($province_name, $od["ODname"], "NOW() - INTERVAL 180 DAY", "NOW()");
      $data["percentage_type_od"][$od["ODname"]] = array();
      $tester_male = $this->get_tester_confirm_by_od_and_sex($province_name,$od["ODname"], "Male", "NOW() - INTERVAL 180 DAY", "NOW()");
      $tester_female = $this->get_tester_confirm_by_od_and_sex($province_name,$od["ODname"], "Female", "NOW() - INTERVAL 180 DAY", "NOW()");
      if($total_in_od[0]["total"] != 0 and count($tester_male)> 0 and count($tester_female) > 0){
        $data["percentage_type_od"][$od["ODname"]]["percentage_male"] = ($tester_male[0]["total"] / $total_in_od[0]["total"]) * 100;
        $data["percentage_type_od"][$od["ODname"]]["percentage_female"] = ($tester_female[0]["total"] / $total_in_od[0]["total"]) * 100;
      }
      else{
        $data["percentage_type_od"][$od["ODname"]]["percentage_male"] = 0;
        $data["percentage_type_od"][$od["ODname"]]["percentage_female"] = 0;
      } 
      foreach($client_types as $type){
        $tester = $this->get_tester_confirm_by_od_and_clientType($province_name,$od["ODname"], $type["TypeClient"], "NOW() - INTERVAL 180 DAY", "NOW()");  

        if($total_in_od[0]["total"] != 0 and count($tester) > 0){
          $data["percentage_type_od"][$od["ODname"]][$type["TypeClient"]] = ($tester[0]["total"] / $total_in_od[0]["total"]) * 100;
        }
        else{
          $data["percentage_type_od"][$od["ODname"]][$type["TypeClient"]] = 0;
        } 
      }
    }
    return $data;
  }

  function get_infected_percentage_in_provinces($provinces, $data){
    foreach($provinces as $province){
      $province_name = $province["ProvinceEng"];
      $client_types = $this->get_client_type();
      $total_in_province = $this->get_tester_confirm_by_province($province_name, "NOW() - INTERVAL 180 DAY", "NOW()");
      $data["percentage_type_province"][$province["ProvinceEng"]] = array();
      $tester_male = $this->get_tester_confirm_by_province_and_sex($province_name, "Male", "NOW() - INTERVAL 180 DAY", "NOW()");
      $tester_female = $this->get_tester_confirm_by_province_and_sex($province_name, "Female", "NOW() - INTERVAL 180 DAY", "NOW()");
      if($total_in_province[0]["total"] != 0 and count($tester_male)> 0 and count($tester_female) > 0){
        $data["percentage_type_province"][$province["ProvinceEng"]]["percentage_male"] = ($tester_male[0]["total"] / $total_in_province[0]["total"]) * 100;
        $data["percentage_type_province"][$province["ProvinceEng"]]["percentage_female"] = ($tester_female[0]["total"] / $total_in_province[0]["total"]) * 100;
      }
      else{
        $data["percentage_type_province"][$province["ProvinceEng"]]["percentage_male"] = 0;
        $data["percentage_type_province"][$province["ProvinceEng"]]["percentage_female"] = 0;
      } 
      foreach($client_types as $type){
        $tester = $this->get_tester_confirm_by_province_and_clientType($province_name, $type["TypeClient"], "NOW() - INTERVAL 180 DAY", "NOW()");  

        if($total_in_province[0]["total"] != 0 and count($tester) > 0){
          $data["percentage_type_province"][$province["ProvinceEng"]][$type["TypeClient"]] = ($tester[0]["total"] / $total_in_province[0]["total"]) * 100;
        }
        else{
          $data["percentage_type_province"][$province["ProvinceEng"]][$type["TypeClient"]] = 0;
        } 
      }
    }
    return $data;
  }

  function get_most_positives_from_hc($province_name, $data){
    $data["most_hc_found_positive"] = $this->get_tester_confirm_by_province_group_by_place($province_name,"NOW() - INTERVAL 180 DAY", "NOW()");
    return $data;
  }

  function get_infected_percentage_as_sex($province_name, $data){
    $tester_male = $this->get_tester_confirm_by_province_and_sex($province_name, "Male", "NOW() - INTERVAL 180 DAY", "NOW()");
    $tester_female = $this->get_tester_confirm_by_province_and_sex($province_name, "Female", "NOW() - INTERVAL 180 DAY", "NOW()");
    $total_in_province = $this->get_tester_confirm_by_province($province_name, "NOW() - INTERVAL 180 DAY", "NOW()");
    if($total_in_province[0]["total"] != 0){
      $data["percentage_male"] = ($tester_male[0]["total"] / $total_in_province[0]["total"]) * 100;
      $data["percentage_female"] = ($tester_female[0]["total"] / $total_in_province[0]["total"]) * 100;
    }
    else{
      $data["percentage_male"] = 0;
      $data["percentage_female"] = 0;
    } 
    return $data;
  }

  function get_infected_percentage_in_country_as_sex($data){
    $tester_male = $this->get_tester_confirm_by_country_and_sex("Male", "NOW() - INTERVAL 180 DAY", "NOW()");
    $tester_female = $this->get_tester_confirm_by_country_and_sex("Female", "NOW() - INTERVAL 180 DAY", "NOW()");
    $total_in_country = $this->get_tester_confirm_by_country("NOW() - INTERVAL 180 DAY", "NOW()");
    if($total_in_country[0]["total"] != 0){
      $data["percentage_male"] = ($tester_male[0]["total"] / $total_in_country[0]["total"]) * 100;
      $data["num_male"] = $tester_male[0]["total"];
      $data["num_female"] = $tester_female[0]["total"];
      $data["num_total"] = $total_in_country[0]["total"];
      $data["percentage_female"] = ($tester_female[0]["total"] / $total_in_country[0]["total"]) * 100;
    }
    else{
      $data["percentage_male"] = 0;
      $data["percentage_female"] = 0;
      $data["num_male"] = $tester_male[0]["total"];
      $data["num_female"] = $tester_fmale[0]["total"];
    } 
    return $data;
  }

  function get_infected_percentage_in_country_as_clientType($data){
    $client_types = $this->get_client_type();
    $total_in_country = $this->get_tester_confirm_by_country("NOW() - INTERVAL 180 DAY", "NOW()");
    foreach($client_types as $type){
      $tester = $this->get_tester_confirm_by_country_and_clientType($type["TypeClient"], "NOW() - INTERVAL 180 DAY", "NOW()");  

      if($total_in_country[0]["total"] != 0 and count($tester) > 0){
        $data["percentage_type"][$type["TypeClient"]] = ($tester[0]["total"] / $total_in_country[0]["total"]) * 100;
      }
      else{
        $data["percentage"][$type["TypeClient"]] = 0;
      } 
    }
    return $data;
  }

  function get_infected_percentage_in_country_as_clientType_by_quater($data, $year){
    $client_types = $this->get_client_type();
    $total_in_country = $this->get_tester_confirm_by_country("'$year-01-01'", "'$year-12-31'");
    $data["percentage_type_by_quater"] = array();
    foreach($client_types as $type){
      $data["percentage_type_by_quater"][$type["TypeClient"]] = array();
      $data["percentage_type_by_quater"][$type["TypeClient"]]["First Quater"] = $this->get_tester_confirm_by_country_and_clientType($type["TypeClient"], "'$year-01-01'", "'$year-03-31'");
      $data["percentage_type_by_quater"][$type["TypeClient"]]["Second Quater"] = $this->get_tester_confirm_by_country_and_clientType($type["TypeClient"], "'$year-04-01'", "'$year-06-30'");
      $data["percentage_type_by_quater"][$type["TypeClient"]]["Third Quater"] = $this->get_tester_confirm_by_country_and_clientType($type["TypeClient"], "'$year-07-01'", "'$year-09-30'");
      $data["percentage_type_by_quater"][$type["TypeClient"]]["Fourth Quater"] = $this->get_tester_confirm_by_country_and_clientType($type["TypeClient"], "'$year-10-01'", "'$year-12-31'");  
    }
    return $data;
  }

  function get_infected_percentage_as_clientType($province_name, $data){
    $client_types = $this->get_client_type();
    $total_in_province = $this->get_tester_confirm_by_province($province_name, "NOW() - INTERVAL 180 DAY", "NOW()");
    foreach($client_types as $type){
      $tester = $this->get_tester_confirm_by_province_and_clientType($province_name, $type["TypeClient"], "NOW() - INTERVAL 180 DAY", "NOW()");  

      if($total_in_province[0]["total"] != 0 and count($tester) > 0){
        $data["percentage_type"][$type["TypeClient"]] = ($tester[0]["total"] / $total_in_province[0]["total"]) * 100;
      }
      else{
        $data["percentage"][$type["TypeClient"]] = 0;
      } 
    }
    return $data;
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
        $data["graph"][$od["ODname"]][$list_months[$i]]= $this->get_tester_confirm_by_OD($province_name, $od["ODname"], "'$current_year-$list_months[$i]-01'", "'$current_year-$list_months[$i]-$end_month_day'");
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

      $data["graph_province"][$province_name][$list_months[$i]]= $this->get_tester_confirm_by_province($province_name, "'$current_year-$list_months[$i]-01'", "'$current_year-$list_months[$i]-$end_month_day'");
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

  function get_confirm_test_as_country($data, $from_number_of_month){
    $current_month = date('m');
    $current_year = $this->get_start_year($from_number_of_month);
    $list_months = array_reverse($this->get_list_month($current_month, $from_number_of_month));
    $data["list_months"] = $list_months;
    $tmp_total = 0;
    $total_mv_range = 0;
    $mv_range = 0;
    for($i=0; $i<$from_number_of_month; $i++){
      $end_month_day = $this->day_in_month($current_year, $list_months[$i]);

      $data["graph_country"][$list_months[$i]]= $this->get_tester_confirm_by_country("'$current_year-$list_months[$i]-01'", "'$current_year-$list_months[$i]-$end_month_day'");
      $tmp_total = $tmp_total + $data["graph_country"][$list_months[$i]][0]["total"];
      $total_mv_range = $total_mv_range + (abs($data["graph_country"][$list_months[$i]][0]["total"] - $mv_range));
      $mv_range = $data["graph_country"][$list_months[$i]][0]["total"];
      if($list_months[$i] ==  12)
        $current_year = $current_year + 1;
    }
    $central_line = $tmp_total / $from_number_of_month;
    $avg_moving_range = $total_mv_range /$from_number_of_month;
    $data["graph_country"]["central_line"] = $central_line;
    $data["graph_country"]["upper_line"] = $central_line + ($avg_moving_range * 2.66);
    $data["graph_country"]["lower_line"] = $central_line - ($avg_moving_range * 2.66);
    return $data;
  }

  function get_client_type(){
    $this->load->database();
    $result = $this->db->query("select TypeClient from tblfirsttest GROUP BY TypeClient");
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

  function get_tester_by_client_type($province_name, $type){
    $this->load->database();
    $result = $this->db->query("select count(*) as total from tblfirsttest INNER JOIN tblcenter ON tblfirsttest.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND TypeClient='" . $type . "' AND DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW()");
    return $result->result_array();
  }

  function get_tester_confirm(){
    $this->load->database();
    $result = $this->db->query("select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.DatTest BETWEEN (NOW() - INTERVAL 180 DAY) AND NOW()");
    return $result->result_array();
  }

  function get_tester_confirm_by_province($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_number_confirm_test_positive_as_province($from, $to){
    $this->load->database();
    $query = "select tblcenter.Province, count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblcenter.Province ORDER BY total DESC ";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_country($from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.DatTest BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirmed_by_province_within_one_two_days($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND (tblfirsttest.DatTest BETWEEN $from AND $to) AND tblconfirm.Dat BETWEEN tblfirsttest.DatTest AND tblfirsttest.DatTest + INTERVAL 2 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirmed_by_province_from_three_to_seven_days($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND (tblfirsttest.DatTest BETWEEN $from AND $to) AND tblconfirm.Dat BETWEEN tblfirsttest.DatTest + INTERVAL 3 DAY AND tblfirsttest.DatTest + INTERVAL 7 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirmed_by_province_more_than_seven_days($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND (tblfirsttest.DatTest BETWEEN $from AND $to) AND tblconfirm.Dat > tblfirsttest.DatTest + INTERVAL 7 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_enroll_by_province($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT tblconfirm.CaseID, tblconfirm.Dat, tblregoi.DatReg FROM tblconfirm INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblregoi on tblconfirm.CaseID=tblregoi.CaseID WHERE tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_enroll_by_province_within_one_two_days($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT count(*) AS total FROM tblconfirm INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblregoi on tblconfirm.CaseID=tblregoi.CaseID WHERE tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to AND tblregoi.DatReg BETWEEN tblconfirm.Dat AND tblconfirm.Dat + INTERVAL 2 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_enroll_by_province_within_three_to_seven_day($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT count(*) AS total FROM tblconfirm INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblregoi on tblconfirm.CaseID=tblregoi.CaseID WHERE tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to AND tblregoi.DatReg BETWEEN tblconfirm.Dat + INTERVAL 3 DAY AND tblconfirm.Dat + INTERVAL 7 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_enroll_by_province_more_than_seven_day($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT count(*) AS total FROM tblconfirm INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblregoi on tblconfirm.CaseID=tblregoi.CaseID WHERE tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to AND tblregoi.DatReg > tblconfirm.Dat + INTERVAL 7 DAY";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_not_confirm_by_province($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT count(*) AS total FROM tblfirsttest INNER JOIN tblcenter ON tblfirsttest.Code=tblcenter.Code INNER JOIN tblstatus ON tblstatus.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.CaseID not in (select CaseID from tblconfirm) AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_not_confirm_in_province_as_sex($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT tblpersonal.Sex, count(*) AS total FROM tblfirsttest INNER JOIN tblcenter ON tblfirsttest.Code=tblcenter.Code  INNER JOIN tblpersonal ON tblfirsttest.CaseID=tblpersonal.CaseID WHERE tblfirsttest.CaseID not in (select CaseID from tblconfirm) AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblpersonal.Sex";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_not_confirm_in_province_as_client_type($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT tblfirsttest.TypeClient, count(*) AS total FROM tblfirsttest INNER JOIN tblcenter ON tblfirsttest.Code=tblcenter.Code WHERE tblfirsttest.CaseID not in (select CaseID from tblconfirm) AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblfirsttest.TypeClient";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_not_enroll_in_province_as_sex($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT tblpersonal.Sex, count(*) AS total FROM tblconfirm INNER JOIN tblfirsttest ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code  INNER JOIN tblpersonal ON tblconfirm.CaseID=tblpersonal.CaseID WHERE tblconfirm.CaseID not in (select CaseID from tblregoi) AND tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to GROUP BY tblpersonal.Sex";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_not_enroll_in_province_as_client_type($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT tblfirsttest.TypeClient, count(*) AS total FROM tblconfirm INNER JOIN tblfirsttest ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblconfirm.CaseID not in (select CaseID from tblregoi) AND tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to GROUP BY tblfirsttest.TypeClient";
    $result = $this->db->query($query);
    return $result->result_array();
   }

  function get_tester_not_enroll_by_province($province_name, $from, $to){
    $this->load->database();
    $query = "SELECT count(*) AS total FROM tblconfirm INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblstatus  ON tblstatus.CaseID=tblconfirm.CaseID WHERE tblconfirm.CaseID not in (select CaseID from tblregoi) AND tblcenter.Province='$province_name' AND tblconfirm.Dat BETWEEN $from AND $to ";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_province_group_by_place($province_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total, tblfirsttest.PlaceTest from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblfirsttest.PlaceTest ORDER BY total DESC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_province_and_clientType($province_name, $type, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblfirsttest.TypeClient='$type' AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblfirsttest.TypeClient";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_country_and_clientType($type, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID WHERE tblfirsttest.TypeClient='$type' AND  tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblfirsttest.TypeClient";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_OD_and_clientType($province_name, $od_name, $type, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblfirsttest.TypeClient='$type' AND tblcenter.ODname='$od_name' AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to GROUP BY tblfirsttest.TypeClient";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_OD_and_sex($province_name, $od_name, $sex, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblpersonal ON tblfirsttest.CaseID=tblpersonal.CaseID WHERE tblpersonal.Sex='$sex' AND tblcenter.ODname='$od_name' AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to ";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_OD($province_name, $od_name, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code WHERE tblcenter.ODname='$od_name' AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to;";
    $result = $this->db->query($query);
    // print_r($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_province_and_sex($province_name, $sex, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblcenter ON tblconfirm.Code=tblcenter.Code INNER JOIN tblpersonal ON tblfirsttest.CaseID=tblpersonal.CaseID WHERE tblpersonal.Sex='$sex' AND tblcenter.Province='$province_name' AND tblfirsttest.DatTest BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_tester_confirm_by_country_and_sex($sex, $from, $to){
    $this->load->database();
    $query = "select count(*) as total from tblfirsttest INNER JOIN tblconfirm ON tblconfirm.CaseID=tblfirsttest.CaseID INNER JOIN tblpersonal ON tblfirsttest.CaseID=tblpersonal.CaseID WHERE tblpersonal.Sex='$sex' AND tblfirsttest.DatTest BETWEEN $from AND $to";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_list_ods($province_name){
    $this->load->database();
    $query = "select ODname from tblcenter where Province='$province_name'";
    $result = $this->db->query($query);
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