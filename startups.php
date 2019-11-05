<?php include 'actions/db_connection.php';
      $page='Startups';
      include 'assets/header.php';?>
<!-- banner -->
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/profile_city.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand">
            <br/><br/>
            <h3>Meet Africa's Startups</h3>
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
        <h2>Companies</h2>
       
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
                        <div class="col-md-1"><span>Logo</span></div>
                        <div class="col-md-3"><span>Company</span> <span>Type</span></div>
                        <div class="col-md-2"><span>Location</span><span> Founding Year</span></div>
                        <div class="col-md-2"><span>Total Funding</span><span>Status</span></div>
                        <div class="col-md-2"><span>Countries of <br>Operation</span></div>
                        <div class="col-md-2"><span>Links</span></div>
        </div>

        <div id="cardholder">

          <?php //return results
            
            $stmt = $pdo->prepare('select * from single_startups_view order by funding desc');
            $stmt->execute();
            foreach ($stmt as $row) {
              $s_id = $row['s_id'];
              $logo = logo_check($row['logo']);
              $name = $row['name'];
              $type = $row['type'];
              $location = $row['location'];
              $f_year = $row['f_year'];
              
              //handle money
              $funding =$row['funding'];
              if ($funding=='0'){
                $funding = 'Undisclosed Amount';
              }else{
                $fmt2 = new NumberFormatter( 'UG', NumberFormatter::DECIMAL );
                $fmt2->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
                $funding = $fmt2->formatCurrency(($funding),"USD");
                $funding = 'US $'.$funding;
              }

              $status = $row['status'];
              $website = $row['website'];
              $facebook = $row['facebook'];
              $twitter = $row['twitter'];
              $linkedin = $row['linkedin'];

              $type2= $row['type2'];
              $email= $row['email'];
              $funding_stage= $row['funding_stage'];
              $employees= $row['employees'];
              $countries = $row['countries'];
              $countries = str_replace(',', ', ', $countries);
            
              

              echo "
                  <!-- $name card -->
                  <div class='card'>
                    <div class='row' style='padding:1.5em 0 1.5em 1em'>
                      <div class='col-md-1'>
                        <img src='$logo' class='row-logo'>
                      </div>
                      <div class='col-md-3'>
                        <a href='profile?p=$s_id'>
                          <strong style='font-size:1.8em;'>$name</strong>
                        </a>
                        <span>$type</span>
                      </div>
                      <div class='col-md-2' style=''>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Location/Founding Year</div>
                        <span>$location</span>
                        <span>$f_year</span>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Total Funding/Status</div>
                        <span>$funding</span>
                        <a class='badge badge-pill badge-success' href=''>$status</a>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Countries of Operation</div>
                        <span>$countries</span>
                      </div>
                      <div class='col-md-2'>
                        <span style='font-size:2em;'>
                          <a href='$facebook' target='_blank' rel='noopener'><i class='fa fa-facebook'></i>&nbsp;</a>
                          <a href='$twitter' target='_blank' rel='noopener'><i class='fa fa-twitter'></i>&nbsp;</a>
                          <a href='$website' target='_blank' rel='noopener'><i class='fa fa-globe'></i>&nbsp;</a>
                        </span>
                        <span></span>
                      </div>
                    </div>
                  </div><!-- card -->
                ";
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
    xmlhttp.open("GET", "actions/api.php", true);
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
<?php include "assets/footer.php";?>
