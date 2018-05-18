<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class File extends CI_Controller {

	    function upload() {
	    	print_r($_FILES);
	  //       $info = pathinfo($_FILES['userFile']['name']);
			// $ext = $info['extension']; // get the extension of the file
			// $newname = "newname.".$ext; 
			// $target = '../uploads/'.$newname;
			// $path = move_uploaded_file( $_FILES['userFile']['tmp_name'], $target);
			// post_request_to_import(import_url(), array("filename" => $newname));
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