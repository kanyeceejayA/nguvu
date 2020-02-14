<?php

 // 1. Find the session
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../actions/env.php');

 // 2. Unset all the session variables
 $_SESSION = array();
 session_unset();

 // 3. Destroy the session cookie
 if(isset($_COOKIE[session_name()])) {
     setcookie(session_name(), '', time()-42000, '/');
 }

 // 4. Destroy the session
 session_destroy();



//go to view startups

// $location = '../funding';

// if(isset($_GET['p'])){
//   $location =$_GET['p'];
// }else{
	$location = env('root').'/admin/login';
// }
header('location:'.$location);