<?php
   	include('../actions/db_connection.php');
   	session_start();

   	if(!isset($_SESSION['username'])){
      
    	header("location:login");
   	}
   	
?>