<?php
	class File {
		static function upload($file_info) {
      $name = $file_info['filename']; // get the extension of the file
      $newname = $name.".sql"; 
      $target = '../uploads/'.$newname;
      $path = move_uploaded_file( $_FILES['file']['tmp_name'], $target);
      return $newname;
    }

    static function remove($file_name){
      $target = '../uploads/'.$file_name;
      unlink($target);
      return $target;
    }

    static function validation($url){
      $this->load->view("validation");
    }
  }
?>