<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class File extends CI_Controller {

	    function upload() {
	        $info = pathinfo($_FILES['file']['tmp_name']);
	        print_r($info);
			$name = $info['filename']; // get the extension of the file
			$newname = $name.".sql"; 
			$target = '../uploads/'.$newname;
			$path = move_uploaded_file( $_FILES['file']['tmp_name'], $target);
			$validate_sever_url = $this->config->item('import_url')."/".$newname;
			$response = $this->post_request_to_import($validate_sever_url, array("filename" => $newname));
			echo($response);
	    }

	    function post_request_to_import($url, $data){
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