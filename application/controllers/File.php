<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class File extends CI_Controller {

	    function upload() {
	        $info = pathinfo($_FILES['file']['tmp_name']);
			$name = $info['filename']; // get the extension of the file
			$newname = $name.".sql"; 
			$target = '../uploads/'.$newname;
			$path = move_uploaded_file( $_FILES['file']['tmp_name'], $target);
			echo($newname);
	    }

	    function validation($url){
	    	$this->load->view("validation");
	    }

	
	}
?>