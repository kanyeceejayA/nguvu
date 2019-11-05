<?php
session_start();
// remove all session variables
session_unset();

// destroy the session
session_destroy();

$_SESSION['message']= '<div class="alert alert-success fade show">
			        <div class="container">
			          <div class="alert-icon">
			            <i class="material-icons">check</i>
			          </div>
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			            <span aria-hidden="true"><i class="material-icons">clear</i></span>
			          </button>
			          Sussessfully logged out
			        </div>
			      </div>';
//go to view startups page
header('location:login');