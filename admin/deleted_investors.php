<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} include '../assets/header_admin.php';?>

<script src="../assets/js/plugins/ua-parser.min.js"></script>
<!-- banner -->
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/bg.jpg');text-align: center;">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand">
            <br/><br/>
            <h2>Restore Deleted Investors</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- main Body content -->
  <main class="main">
    <div class="container">
        <br>
     <?php 
              if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
              $_SESSION['message'] = null;
          ?>  
        <h2>Deleted Investors</h2>
        <div class="form-inline ml-auto" onsubmit="js_search()">
          <div class="form-group bmd-form-group ">
            <label for="fast_search" class="bmd-label-floating">Field Search</label>
            <input type="text" id="fast_search" class="form-control" onkeyup="js_search()">
          </div>
          <div class="togglebutton">
            <label>
              <input type="checkbox" id="onlyCompany" onchange="js_search()">
              <span class="toggle"></span>
              Search only Company Name
            </label>
          </div>

        </div>

        <!-- Heading -->
        <div class="row header  d-none d-lg-flex d-md-flex">
                        <div class="col-md-2"><span>Logo</span></div>
                        <div class="col-md-4"><span>Company</span> <span>Location</span></div>
                        <div class="col-md-2"><span>Account</span><span>Status</span></div>
                        <div class="col-md-2"><span>Time Deleted<br>User Agent</span></div>
                        <div class="col-md-2"><span> </span><span>Restore</span></div>
        </div>

        <div id="cardholder">

       <?php //return results
            
            $stmt = $pdo->prepare('select * from deleted_investors order by deleted_on desc;');
            $stmt->execute();
            foreach ($stmt as $row) {
              $inv_id = $row['inv_id'];
              $logo = logo_check($row['logo']);
              $name = $row['name'];
              $sector = $row['sector'];
              $location = $row['location'];
              $status = $row['status'];
              $website = $row['website'];
              $facebook = $row['facebook'];
              $twitter = $row['twitter'];
              $linkedin = $row['linkedin'];
              $deleted_on = $row['deleted_on'];
              $user_agent= $row['user_agent'];
              $account= $row['account'];
                
              $stmt2 = $pdo->prepare('select * from funding_view where inv_id=?');
              $stmt2->execute(array($row['inv_id']));
              
              $s_name = array();
              foreach ($stmt2 as $row) {
                $new_name="<a href='../profile?p=".$row['s_id']."'>".$row['s_name']."</a>";

                if (!(in_array($new_name, $s_name))) {
                  array_push($s_name, $new_name);
                }
              }
              $s_name = implode(', ', $s_name);




              echo "
                  <!-- $name card -->
                  <div class='card'>
                    <div class='row' style='padding:1.5em 0 1.5em 1em'>
                      <div class='col-md-2'>
                        <img src='../$logo' class='row-logo'>
                      </div>
                      <div class='col-md-4'>
                        <a href='../investor?=$name'>
                          <strong style='font-size:1.8em;'>$name</strong>
                        </a>
                        <span>$location</span>
                      </div>
                  
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Main Sector/Status</div>
                        <span>$account</span>
                        <a class='badge badge-pill badge-success' href=''>$status</a>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Deleted on</div>
                        <span>$deleted_on</span>
                        <span id='agent-$inv_id'></span>
                      </div>
                      <div class='col-md-2'>
                         <span><a href='../actions/restore-investor?p=$inv_id' class='myDelete'><i class='fa fa-refresh'></i> Restore</a> </div>
                    </div>
                  </div><!-- card -->
                ";

                echo "
              <script>
              var parser = new UAParser();
              var result = UAParser('$user_agent');
              var agent = result.browser['name'] + ' on ' + result.os['name'] + ' ' + result.os['version'];
              console.log(agent);
              document.getElementById('agent-$inv_id').innerHTML = agent;
              </script>";
            }
          ?>
        </div> <!-- cardholder -->
        <br>
    </div><!-- cotainer -->      
  </main>





<script type="text/javascript">
  var myObj;
  function get() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        myObj = JSON.parse(this.responseText);
        for (var i = myObj.length - 1; i >= 0; i--) {
          // myObj[i]
        // document.getElementById("cardholder").innerHTML += ;
        }
      }
    };
    xmlhttp.open("GET", "../actions/api.php", true);
    // xmlhttp.open("GET", "https://jsonplaceholder.typicode.com/todos/1", true);
    xmlhttp.send();
  }


  function lister() {
    chosen = document.getElementById('chosen');
    c_list = document.getElementById('c_list');
    c_values = document.getElementById('c_values');
    chosen.innerHTML += ' <span id="'+c_list.selectedIndex+'" onclick="del('+c_list.selectedIndex+')" class="badge badge-pill badge-success country">X  '+c_list.options[c_list.selectedIndex].text+'</span>';

    c_values.options[c_list.selectedIndex].selected= true;
  }

  function del(index) {
    var elem = document.getElementById(index);
    c_values = document.getElementById('c_values');
    elem.parentNode.removeChild(elem);

    c_values.options[index].selected= false;
  }

</script>
<?php include "../assets/footer_admin.php";?>

