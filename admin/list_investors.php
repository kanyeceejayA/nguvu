<?php include '../assets/header_admin.php';?>
<!-- banner -->
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/kampala-skyline.jpg');text-align: center;">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand">
            <br/><br/>
            <h2>Africa's Investors</h2>
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
        <h2>Investors</h2>
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
                        <div class="col-md-2"><span>Main Sector</span><span>Status</span></div>
                        <div class="col-md-2"><span>Countries of <br>Operation</span></div>
                        <div class="col-md-2"><span>Edit</span><span>delete</span></div>
        </div>

        <div id="cardholder">

          <?php //return results
            
            $stmt = $pdo->prepare('select * from investors;');
            $stmt->execute();
            foreach ($stmt as $row) {
              $inv_id = $row['inv_id'];
              $logo = logo_check($row['logo']);
              $name = $row['name'];
              $sector = $row['sector'];
              $location = $row['location'];
              $f_year = '2015';
              $status = $row['status'];
              $website = $row['website'];
              $facebook = $row['facebook'];
              $twitter = $row['twitter'];
              $linkedin = $row['linkedin'];
              $stmt2 = $pdo->prepare('select GROUP_CONCAT(c.name) as countries from investors i join c_of_focus f on f.inv_id = i.inv_id JOIN countries c on c.country_id=f.c_id where f.inv_id=?');
              $stmt2->execute(array($row['inv_id']));
              foreach ($stmt2 as $row) {
                $countries = $row['countries'];
                $countries = str_replace(',', ', ', $countries);
              }
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
                        <span>$sector</span>
                        <a class='badge badge-pill badge-success' href=''>$status</a>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Countries of Operation</div>
                        <span>$countries</span>
                      </div>
                      <div class='col-md-2'>
                         <span><a href='edit_investors?p=$inv_id'><i class='fa fa-edit'></i> Edit</a> <vr></vr> <a href='../actions/delete-investors.php?p=$inv_id' class='myDelete'><i class='fa fa-trash'></i> Delete</a></span>                      </div>
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
