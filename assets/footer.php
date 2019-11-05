
  <footer class="footer footer-default">
    <div class="container">
      <div class=" copyright float-left">
      <?php if(isset($_SESSION['username'])){ ?>
              Logged In as <?php echo $_SESSION['username'];?>. <a href="admin/logout">Logout</a>
      <?php } ?>
      <?php if(!isset($_SESSION['username'])){ ?>
          <a href="admin/index">Admin</a>
      <?php } ?>
      </div>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script> Nguvu Africa</a>
      </div>
    </div>
  </footer>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <!-- <script src="assets/js/plugins/moment.min.js"></script> -->
  
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-kit.js?v=2.0.5" type="text/javascript"></script>
  <script src="assets/js/scripts.js" type="text/javascript"></script>
  
</body>

</html>
