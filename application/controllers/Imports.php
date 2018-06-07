<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Imports extends CI_Controller{

  public function __construct()
  {
    parent::__construct();

    if( !$this->session->userdata('isLoggedIn') ) {
      redirect('/login/show_login');
    }
  }


  function process($file_name)
  {
    $this->restoreDatabaseTables($file_name);
    return $this->preparing_data();
  }

  function show_upload() {
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');
    $this->load->view('upload',$data);
  }

  function show_validation($file_name){
    if(!file_exists("../uploads/".$file_name))
      header("HTTP/1.1 404 File Not Found");
    $user_id = $this->session->userdata('id');
    $is_admin = $this->session->userdata('isAdmin');
    $data["file_name"] = $file_name;
    $data['is_admin'] = $is_admin;
    $data['email'] = $this->session->userdata('email');
    $data['name'] = $this->session->userdata('name');
    $data["response"] = $this->process($file_name);
    $data["record_info"] = $this->upload_info();
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
    $data["response_data"] = $this->process($file_name);
    $data["record_info"] = $this->upload_info();
    $this->load->view('import',$data);
  }


  private function restoreDatabaseTables($file_name){
    $this->load->database();
    $restore_file  = $this->config->item("file_upload_url") . $file_name;
    $schema_file = $this->config->item("file_upload_url") . "schema.sql";
    $server_name   = $this->db->hostname;
    $username      = $this->db->username;
    $password      = $this->db->password;
    $database_name = $this->config->item("database_tmp_name");
    $this->reset_database();
    // $this->db->query("drop database $database_name");
    // $this->db->query("create database $database_name");
    // $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $schema_file";
    $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
    return exec($cmd);
  }

  private function preparing_data(){
    $this->config->load("table");
    $tables = $this->config->item("tables");
    $error = array();
    $dbtmp = $this->load_acm_tmp_db();
    foreach ($tables as $table_name => $table_properties)
    {
        $error = $this->validate_table($dbtmp, $table_name, $table_properties, $error);
    }
    return $error;
  }

  private function remove_import_data_file($file_name){
    $stored_file  = $this->config->item("file_upload_url") . $file_name;
    unlink($stored_file);
  }

  function import_data($table_name){
    $dbtmp = $this->load_acm_tmp_db();
    $params = json_decode($this->input->raw_input_stream, true);
    if(!isset($params["excluded_case_ids"]))
      $params["excluded_case_ids"] = [];
    $excluded_case_ids = $params["excluded_case_ids"];
    $tables = $this->config->item("tables");
    $table_properties = $tables[$table_name];
    $this->move_data($dbtmp, $table_name, $excluded_case_ids);

  }

  private function validate_table($db, $table_name, $table_properties, $error){
    $dbtmp = $this->load_acm_tmp_db();
    $sql="Select * from $table_name";
    // echo($sql);
    $result=$dbtmp->query($sql);
    // print_r($result);
    $rows=$result->result_array();
    foreach ($rows as $row) {
        $error = $this->validate_record($table_name, $table_properties,$row,$error);
    } 
    return $error;
  }

  private function move_data($db, $table_name, $excluded_case_ids){
    $this->load->database();
    $sql="Select * from $table_name";
    $result=$db->query($sql);
    $rows=$result->result_array();
    foreach ($rows as $row) {
        if(isset($row["CaseID"]) and count($excluded_case_ids) != 0 and in_array($row["CaseID"], $excluded_case_ids)){
            print_r("Continue");
            continue;
        }
        $sql = $this->build_sql_insert($this->db, $table_name, $row);
        $this->db->query($sql);
    }
  }

  private function validate_record($table_name, $table_properties, $row, $error){
    if(isset($row["CaseID"])){
      if(!isset($error[$row["CaseID"]])){
        $error[$row["CaseID"]] = array();
      }
    }
    foreach ($table_properties as $field){
      foreach ($row as $key => $value){
        $key_name = $table_name."-".$key;
        
        if($this->validate_mandatory($field["mandatory"], $value) == false){
          // echo("Validating mandatory failed field $key with value $value in table $table_name ". "<br />");
          $error[$row["CaseID"]][$key_name] = "Field $key in table $table_name is missing value.";
        }

        if(isset($field["min_digit"]) && isset($field["max_degit"]) && $this->validate_digit($field["min_digit"],$field["max_degit"],$value) == false){
          $error[$row["CaseID"]][$key_name] = "The number of digit field ".$key." in table $table_name is not in the range from". $field['min_digit'] ." to ".$field['max_degit']." degit.";
        }
        if($field["condition"] != "" && isset($row["CaseID"]) && !$this->validate_time($row["CaseID"], $field["condition"], $value) == false){
          $ref_table_name = $field["condition"]["table"];
          $ref_field_name = $field["condition"]["field"];
          $operator = $field["condition"]["operator"];
          $error[$row["CaseID"]][$key_name] = $table_name ." with field ".$key." with value ".$value." should be ".$operator." to the field ".$ref_field_name." of table ".$ref_table_name." .";
        }
      }
    }

    if(isset($row["CaseID"]) && count($error[$row["CaseID"]]) == 0){
      unset($error[$row["CaseID"]]);
    }
    return $error;
  }

  private function validate_time($CaseID, $condition, $value){
    $this->load->db();
    if (trim($condition) != ""){
      $table_name = $condition["table"];
      $field_name = $condition["field"];
      $operator = $condition["operator"];
      $result = $this->db->query("select * from $table_name where CaseID = $CaseID");
      $rows=$result->result_array();
      foreach($rows as $row)
      {
        switch ($operator) {
          case '<':
            return $value < $row[$field_name];
            break;
          case '<=':
            return $value <= $row[$field_name];
            break;
          case '>':
            return $value > $row[$field_name];
            break;
          case '>=':
            return $value >= $row[$field_name];
            break;
          case '=':
            return $value == $row[$field_name];
            break;
          default:
            return true;
            break;
        }
      }
    }
    else{
      return true;
    }
  }

  private function validate_digit($min_digit, $max_degit, $value){
    if(strlen($value) < $min_digit && strlen($value) > $max_degit )
        return true;
    else
        return false;
  }

  private function validate_mandatory($mandatory, $value){
    if($mandatory == true && ($value == NULL || trim($value) == ""))
        return false;
    else
        return true;
  }

  private function build_sql_insert($db, $archived_tablename,$row){
    $this->config->load("table");
    $this->config->load("key");
    $tables = $this->config->item("tables");
    $sql = "insert into $archived_tablename values(";
    $array_value = array();
    $this->load->model("Crypto");
    $key = $this->config->item("secure_key");
    foreach ($row as $key => $value){
        if(isset($tables[$archived_tablename][$key]["encrypt"]))
          // $encrypted_string=$this->Crypto->encrypt($value, $key);
          $value = $this->encrypt($value);
        array_push($array_value, $db->escape($value));
    }
    $sql.= join(",", $array_value);
    $sql.=")";
    return $sql;
  }

  private function reset_database(){
    $dbtmp = $this->load_acm_tmp_db();
    $this->config->load("table");
    $tables = $this->config->item("tables");
    foreach ($tables as $key => $table)
    {
        $dbtmp->query("delete from $key");
    }

  }

  function upload_info(){
    $dbtmp = $this->load_acm_tmp_db();
    $this->config->load("table");
    $tables = $this->config->item("tables");
    $number_table = count($tables);
    $table_record = array();
    if(isset($_POST["excluded_case_ids"])){
      $excluded_case_ids = $_POST["excluded_case_ids"];
    }
    else{
      $excluded_case_ids = "";
    }
    $total = 0;
    foreach ($tables as $key => $table)
    {
        if(isset($table["CaseID"]) and $excluded_case_ids != ""){
            $count = $dbtmp->query("select count(*) as total from $key where CaseID not in ($excluded_case_ids)");
        }
        else{
            $count = $dbtmp->query("select count(*) as total from $key");
        }
        $table_record[$key] = $count->result_array();
        $total = $total +  $table_record[$key][0]["total"];
    }
    $table_record["total"] = $total;
    return $table_record;
  }
  
  /**
   * Returns an encrypted & utf8-encoded
   */
  // private function encrypt($pure_string) {
  //   $this->config->load("key");
  //   $key = $this->config->item("secure_key");
  //   $cipher = $this->config->item("secure_method");
  //   $iv = $this->config->item("secure_iv");
  //   $tag = $this->config->item("secure_tag");
  //   if (in_array($cipher, openssl_get_cipher_methods()))
  //   {
  //     return openssl_encrypt($pure_string, $cipher, $key, OPENSSL_ZERO_PADDING, $iv, $tag);
  //   }
  // }

  /**
   * Returns decrypted original string
   */
  // private function decrypt($encrypted_string) {
  //   $this->config->load("key");
  //   $key = $this->config->item("secure_key");
  //   $cipher = $this->config->item("secure_method");
  //   $iv = $this->config->item("secure_iv");
  //   $tag = $this->config->item("secure_tag");
  //   if (in_array($cipher, openssl_get_cipher_methods()))
  //   {
  //     return openssl_decrypt($encrypted_string, $cipher, $key, OPENSSL_ZERO_PADDING, $iv, $tag);
  //   }
  // }

  private function load_acm_tmp_db(){
    $server_name   = $this->db->hostname;
    $username      = $this->db->username;
    $password      = $this->db->password;
    $database_name = $this->config->item("database_tmp_name");
    $dsn1 = "mysqli://$username:$password@$server_name/$database_name";
    // echo($dsn1);
    return $this->load->database($dsn1, true);

  }
}
?>
