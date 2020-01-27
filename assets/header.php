<!DOCTYPE html>
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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

  <script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-143871703-1', 'auto');
  ga('send', 'pageview');
</script>

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

          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="material-icons">file_copy</i> Blog
            </a>
          </li> 

          <li class="nav-item">
            <a href="funding" class="nav-link">
              <i class="material-icons">done_all</i> Funding
            </a>
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
              <i class="material-icons">post_add</i> Insert
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="add_startup" class="dropdown-item">
                <i class="material-icons">post_add</i>Add Startup
              </a>
              <a href="add_investor" class="dropdown-item">
                <i class="material-icons">post_add</i> Add Investor
              </a>
              <a href="add_funding" class="dropdown-item">
                <i class="material-icons">post_add</i>Add Funding
              </a>
            </div>
          </li>


       <?php if(isset($_SESSION['username'])){ ?>

            <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="material-icons">edit</i> Edit
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="admin/list_startups" class="dropdown-item">
                <i class="material-icons">edit</i>Edit Startup
              </a>
              <a href="admin/list_investors" class="dropdown-item">
                <i class="material-icons">edit</i> Edit Investor
              </a>
              <a href="admin/list_funding" class="dropdown-item">
                <i class="material-icons">edit</i> Edit Funding
              </a>
            </div>
          </li>

              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="material-icons">person</i><?php echo $_SESSION['username'];?>
                </a>
                <div class="dropdown-menu dropdown-with-icons">
                  <a href="admin/index" class="dropdown-item">
                  <i class="material-icons">build</i> Admin View
                </a>
                  <a href="admin/logout?p=<?php echo $_SERVER["REQUEST_URI"];?>" class="dropdown-item">
                    <i class="material-icons">launch</i> Logout
                  </a>
                </div>
              </li>
         <?php } ?>
          
        </ul>
      </div>
    </div>
  </nav>