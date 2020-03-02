<?php
  include ('../actions/db_connection.php');
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        // email and password sent from form 
        $username = mysqli_real_escape_string($connect,$_POST['username']);
        $email = mysqli_real_escape_string($connect,$_POST['email']);
        $password = mysqli_real_escape_string($connect,$_POST['password']); 

        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($username)) { array_push($errors, "Username is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password)) { array_push($errors, "Password is required"); }


        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users_staging WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($connect, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
            if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {
            array_push($errors, "email already exists");
            }
        }

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) {
            $password = password($password);//encrypt the password before saving in the database

            $query = "INSERT INTO users_staging (username, email, password) 
                    VALUES('$username', '$email', '$password')";
            mysqli_query($db, $query);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
        
      
      $sql = "SELECT user_id, email FROM users WHERE username = '$username' and password = password('$mypassword')";
      $result = mysqli_query($connect,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);


      // If result matched $myemail and $mypassword, table row must be 1 row
      if($count == 1) {
        $location = 'list_startups';
        $_SESSION['username'] = $username;
        $_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];

        if(isset($_GET['p'])){
          $location =$_GET['p'];
        }
        $error = NULL;
        header("location: ".$location);
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
  <style>
      .card-login .input-group {
        margin-top: 0px!important;
      }
  </style>
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
            <form class="form" method="" action="">
                <div class="card-header card-header-info text-center">
                  <h4 class="card-title">Employee Signup</h4>
                  <div class="social-line">
                    
                  </div>
                </div>
                <?php 
                  if(isset($error)){
                    echo "<span style='text-align: center;color: red;'>".$error."</span>";
                  }elseif(isset($message)){
                    echo "<span style='text-align: center;color: green;'>".$message."</span>";
                  }else{
                    echo "<p class='description text-center'>Choose your username
                            <br>don't use spaces in it</p>";
                  }
                  ?>
                <!-- <p class="description text-center">don't use spaces in it</p> -->
                <div class="card-body">
                  <span class="bmd-form-group"><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">face</i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="UserName..." name="username">
                  </div></span>
                  <span class="bmd-form-group is-filled"><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">mail</i>
                      </span>
                    </div>
                    <input type="email" class="form-control" placeholder="Email..." name="email">
                  </div></span>
                  <span class="bmd-form-group is-filled"><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">lock_outline</i>
                      </span>
                    </div>
                    <input type="password" class="form-control" placeholder="Password..." name="password" id="pwd">
                    <div class="togglebutton">
                        <label>
                          <input type="checkbox" onclick="viewPwd()">
                          <span class="toggle"></span>
                          <span class="fa fa-eye"></span>
                        </label>
                      </div>
                  </div></span>
                </div>
                <div class="footer text-center">
                  <a href="#pablo" class="btn btn-primary btn-link btn-wd btn-lg">Sign Up</a>
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
        <script>
            function viewPwd() {
            var x = document.getElementById("pwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }
        </script>
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
