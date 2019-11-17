<?php
   	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
   	include('../actions/db_connection.php');

   	if(!isset($_SESSION['username'])){
      
    	header("location:login");
   	}
   	
?>