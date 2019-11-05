<?php include '../assets/header_admin.php';?>
<!-- banner -->
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/profile_city.jpg');text-align:center;">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand">
            <br/><br/>
            <h2>Recent Funding</h2>
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
        <h2>Recent Funding</h2>
       
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
          <br>

        <!-- Heading -->
        <div class="row header  d-none d-lg-flex d-md-flex">
                        <div class="col-md-1"><span>Logo</span></div>
                        <div class="col-md-3"><span>Startup</span></div>
                        <div class="col-md-3"><span>Investor</span></div>
                        <div class="col-md-2"><span>Amount / Round</span></div>
                        <div class="col-md-2"><span>Edit / Date</span></div>
        </div>

        <div id="cardholder">
          <?php //return results
            
            $stmt = $pdo->prepare('SELECT d_id,s.logo,s.name as name, s.location location,i.inv_id inv_id,d.s_id, i.name i_name, i.location i_location,amount,round,d_date, source FROM deals d join startups s on d.s_id = s.s_id JOIN investors i on d.inv_id = i.inv_id order by d_date desc');
            $stmt->execute();
            foreach ($stmt as $row) {
              $d_id =$row['d_id'];
              $logo = logo_check($row['logo']);
              $name = $row['name'];
              $location = $row['location'];
              $s_id = $row['s_id'];
              $inv_id = $row['inv_id'];
              $i_name = $row['i_name'];
              $i_location = $row['i_location'];
              
              //handle money
              $amount =$row['amount'];
              if ($amount=='0'){
                $amount = 'Undisclosed Amount';
              }else{
                $fmt2 = new NumberFormatter( 'UG', NumberFormatter::DECIMAL );
                $fmt2->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
                $amount = $fmt2->formatCurrency(($amount),"USD");
                $amount = 'US $'.$amount;
              }
              
              $round = $row['round'];
              $date = $row['d_date'];
              $source = $row['source'];

              echo "
                  <!-- $name card -->
                  <div class='card'>
                    <div class='row' style='padding:1.5em 0 1.5em 1em'>
                      <div class='col-md-1'>
                        <img src='../$logo' class='row-logo'>
                      </div>
                      <div class='col-md-3'>
                        <a href='../profile?p=$s_id'>
                          <strong style='font-size:1.5em;'>$name</strong>
                        </a>
                        <span>$location</span>
                      </div>
                      <div class='col-md-3'>
                        <div class='text-uppercase d-lg-none d-sm-none'>Investor/Location</div>
                        <a href='../investor?p=$inv_id'>
                          <strong style='font-size:1.5em;'>$i_name</strong>
                        </a>
                        <span>$i_location</span>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Amount/Round</div>
                        <span>$amount</span>
                        <a class='badge badge-pill badge-success' href=''>$round</a>
                      </div>
                      <div class='col-md-2'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Edit/Date</div>
                         <span><a href='edit_funding?p=$d_id'><i class='fa fa-edit'></i> Edit</a> <vr></vr> <a href='../actions/delete-funding.php?p=$d_id' class='myDelete'><i class='fa fa-trash'></i> Delete</a></span>
                        <span>$date</span>
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
