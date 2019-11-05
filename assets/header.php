<!DOCTYPE html>
<?php session_start();
  $page = (isset($page)) ? $page : '' ;
  ?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    <?php echo $page;?> | Nguvu Africa Database
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-kit.css?v=2.0.5" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="assets/demo/demo.css" rel="stylesheet" /> -->
</head>

<body class="profile-page sidebar-collapse">
  <nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="index">
        <img src="assets/img/nguvu.png" height='45em' alt="Nguvu Africa"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="material-icons">post_add</i> Add Company
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="add_startup" class="dropdown-item">
                <i class="material-icons">post_add</i>Add Startup
              </a>
              <a href="add_investor" class="dropdown-item">
                <i class="material-icons">post_add</i> Add Investor
              </a>
            </div>
          </li>
          <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="material-icons">apartment</i> View Companies
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="startups" class="dropdown-item">
                <i class="material-icons">file_copy</i>View Startups
              </a>
              <a href="investors" class="dropdown-item">
                <i class="material-icons">apartment</i> View Investors
              </a>
            </div>
          </li>

          <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="material-icons">done_all</i> Funding
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="funding" class="dropdown-item">
                <i class="material-icons">done_all</i>View Funding
              </a>
              <a href="add_funding" class="dropdown-item">
                <i class="material-icons">post_add</i>Add Deal
              </a>
            </div>
          </li> 
          <?php if(isset($_SESSION['username'])){ ?>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="material-icons">person</i> <?php echo $_SESSION['username'];?>
                </a>
                <div class="dropdown-menu dropdown-with-icons">
                  <a href="startups" class="dropdown-item">
                  <i class="material-icons">apartment</i> View Companies
                </a>
                  <a href="admin/logout" class="dropdown-item">
                    <i class='fa fa-external-link' ></i> Logout
                  </a>
                </div>
              </li>
            <?php } ?>
          
        </ul>
      </div>
    </div>
  </nav>