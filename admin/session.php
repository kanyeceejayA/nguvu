<?php
// $path = $_SERVER['DOCUMENT_ROOT'];
// require_once $path . '/wp-load.php';

// if ( ! is_user_logged_in() ) {
//     header("HTTP/1.1 403 Forbidden" );
//     die();
// }

   	// if (session_status() == PHP_SESSION_NONE) {
    session_start();
// }
	   include('../actions/db_connection.php');
		

	if(!isset($_SESSION['username']) || !isset($_SESSION['LAST_ACTIVITY'])){
      
    	header("location: ".env('root')."/admin/logout");
	}

	$time = $_SERVER['REQUEST_TIME'];

	/**
	* for a 30 minute timeout, specified in seconds
	*/
	$timeout_duration = 10;

	/**
	* Here we look for the user's LAST_ACTIVITY timestamp. If
	* it's set and indicates our $timeout_duration has passed,
	* blow away any previous $_SESSION data and start a new one.
	*/
	if ( ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		header("location: ".env('root')."/admin/logout");
	}

	/**
	* Finally, update LAST_ACTIVITY so that our timeout
	* is based on it and not the user's login time.
	*/
	$_SESSION['LAST_ACTIVITY'] = $time;
   	
?>