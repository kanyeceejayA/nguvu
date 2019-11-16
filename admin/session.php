<?php
   	include('../actions/db_connection.php');
   	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

   	if(!isset($_SESSION['username'])){
      
    	header("location:login");
   	}
   	
?>