<?php
include('../actions/env.php');
// if (session_status() == PHP_SESSION_NONE) {
    session_start();
// }

// remove all session variables
session_unset();

// destroy the session
session_destroy();


//go to view startups

// $location = '../funding';

// if(isset($_GET['p'])){
//   $location =$_GET['p'];
// }else{
	$location = env('root').'/admin/login';
// }
header('location:'.$location);