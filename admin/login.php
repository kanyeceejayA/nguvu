<?php
  include ('../actions/db_connection.php');
  session_start();
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // email and password sent from form 
      
      $username = mysqli_real_escape_string($connect,$_POST['username']);
      $mypassword = mysqli_real_escape_string($connect,$_POST['password']); 
      
      $sql = "SELECT user_id, email FROM users WHERE username = '$username' and password = password('$mypassword')";
      $result = mysqli_query($connect,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);


      // If result matched $myemail and $mypassword, table row must be 1 row
      if($count == 1) {
         
        $_SESSION['username'] = $username;
        $error = NULL;
        header("location: list_startups");


      }else {
         $error = "Your Login Name or Password is invalid";
      }

   }

?>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Login | Nguvu Africa Database 
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-kit.css?v=2.0.5" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="../assets/demo/demo.css" rel="stylesheet" /> -->
</head>

<body class="login-page sidebar-collapse">
  <nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="view.php">
        <img src="../assets/img/nguvu.png" height='45em' alt="Nguvu Africa"></a>
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
              <i class="material-icons">apartment</i> View Companies
            </a>
            <div class="dropdown-menu dropdown-with-icons">
              <a href="../startups" class="dropdown-item">
                <i class="material-icons">file_copy</i>View Startups
              </a>
              <a href="../investors" class="dropdown-item">
                <i class="material-icons">apartment</i> View Investors
              </a>
              <a href="../funding" class="dropdown-item">
                <i class="material-icons">done_all</i> View Funding
              </a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <div class="page-header header-filter" style="background-image: url('../assets/img/bg.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
          <div class="card card-login">
            <form class="form" method="POST" action="">
              <div class="card-header card-header-primary text-center">
                <h4 class="card-title">Nguvu Africa</h4>
                  <h4>Login</h4>
              </div>
              
                <?php 
                  if(isset($error)){
                    echo "<span style='text-align: center;color: red;'>".$error."</span>";
                  }else{
                    echo "<p class='description text-center'>access admin console</p>";
                  }
                  ?>
              <div class="card-body">
                
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">face</i>
                    </span>
                  </div>
                  <input type="text" class="form-control" placeholder="UserName..." name="username">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" class="form-control" placeholder="Password..." name="password">
                </div>
              </div>
              <div class="footer text-center">
                <input type="submit" name="submit" class="btn btn-primary btn-round">
                <br>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <footer class="footer footer-default">
    <div class="container">
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script> Nguvu Africa</a>
      </div>
    </div>
  </footer>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <!-- <script src="../../assets/js/plugins/moment.min.js"></script> -->
  
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-kit.js?v=2.0.5" type="text/javascript"></script>
  <script src="../assets/js/scripts.js" type="text/javascript"></script>
  
</body>

</html>
