<?php include 'actions/db_connection.php';
      $page='Funding';
      include 'assets/header.php'; session_start();

      error_reporting(0);
      function date_check($date){
        $date = (isset($date))? test_input($date) : '';
        $date = ($date!='') ?  date("Y-m-d", strtotime($date)): '' ;
        return $date;
      }

      $from = date_check($_GET['from']);
      $to = date_check($_GET['to']);

      $query = 'SELECT d_id,s.logo,s.name as name, s.location location,i.inv_id inv_id, d.s_id, i.name i_name, i.location i_location,amount,round,d_date, source FROM deals d join startups s on d.s_id = s.s_id JOIN investors i on d.inv_id = i.inv_id ';

      if ($to!='' && $from !='') {
        $query .='where d_date >= "'.$from.'" and d_date <= "'.$to.'" order by d_date desc';
      }
      elseif ($to !='' && $from =='') {
        $query .='where d_date <= "'.$to.'" order by d_date desc';
      }
      elseif ($to=='' && $from !='') {
        $query .='where d_date >= "'.$from.'" order by d_date desc';
      }
      else{
        $query .="order by d_date desc";
      }

      $stmt = $pdo->prepare($query);

      //prepare the values for printing on page
      $to = (isset($_GET['to']))? test_input($_GET['to']) : NULL;
      
      $from = (isset($_GET['from']))? test_input($_GET['from']) : NULL; 


              ?>
<!-- banner -->
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/profile_city.jpg');text-align:center;">
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
      <div class="row">
        <br>
        <h2>Recent Funding</h2>
      </div>
      <div class="row">
        <div class="form-inline mr-auto col-md-6" onsubmit="js_search()">
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
        <form class="form-inline col-md-6" action="" method="GET">
          <div class="form-group bmd-form-group">
            <label for="f_year" class="">From</label>
            <input type="text" class="form-control datetimepicker" name="from" id="from" onclick="reset_view()"<?php if($from !=''){ echo 'value=$from';} ?>>
          </div> <!-- form-group -->
          &nbsp;&nbsp;&nbsp;
          <div class="form-group bmd-form-group">
            <label for="f_year" class="">To</label>
            <input type="text" class="form-control datetimepicker" name="to" id="to" onclick="reset_view()"<?php if($to !=''){ echo 'value=$to';} ?>>
          </div> <!-- form-group -->
          <button class="btn btn-primary btn-round btn-sm">
            <i class="material-icons">search</i> Filter
          <div class="ripple-container"></div></button>
          <a href="funding">
            <button class="btn btn-danger btn-round btn-fab btn-sm" value="clear" type="button">
              <i class="material-icons">delete_outline</i>
            <div class="ripple-container"></div></button>
          </a>
        </form>
      </div>
        <br>

        <!-- Heading -->
        <div class="row header  d-none d-lg-flex d-md-flex">
                        <div class="col-md-1"><span>Logo</span></div>
                        <div class="col-md-3"><span>Startup</span></div>
                        <div class="col-md-3"><span>Investor</span></div>
                        <div class="col-md-2"><span>Amount / Round</span></div>
                        <div class="col-md-2"><span>Date / Source</span></div>
        </div>

        <div id="cardholder">
       <?php //return results

            $stmt->execute();
            foreach ($stmt as $row) {
              $d_id =$row['d_id'];
              $logo = logo_check($row['logo']);
              $name = $row['name'];
              $location = $row['location'];
              $i_name = $row['i_name'];
              $inv_id = $row['inv_id'];
              $s_id = $row['s_id'];
              $i_location = $row['i_location'];
              
              //handle money
              $amount =format_money($row['amount']);
              

              $round = $row['round'];
              $date = date_format(date_create($row['d_date']), 'd M Y');
              $source = $row['source'];

              echo "
                  <!-- $name card -->
                  <div class='card'>
                    <div class='row' style='padding:1.5em 0 1.5em 1em'>
                      <div class='col-md-1'>
                        <img src='$logo' class='row-logo'>
                      </div>
                      <div class='col-md-3'>
                        <a href='profile?p=$s_id'>
                          <strong style='font-size:1.5em;'>$name</strong>
                        </a>
                        <span>$location</span>
                      </div>
                      <div class='col-md-3'>
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Investor/Location</div>
                        <a href='investor?p=$inv_id'>
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
                        <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Date/Source</div>
                        <span>$date</span>
                          <span><a href='$source' target='_blank' rel='noopener'><i class='fa fa-external-link' ></i> Source&nbsp;</a></span>
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
<script src="assets/js/plugins/moment.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      $('#from').data("DateTimePicker").format('D-MMM-Y');

   <?php if($from != ''){ ?>

       $("#from").val( moment('<?php echo $from ;?>').format('D-MMM-Y') );

    <?php } ?>

       $('#to').data("DateTimePicker").format('D-MMM-Y');

    <?php if($to !=''){ ?>

       $("#to").val( moment('<?php echo $to ;?>').format('D-MMM-Y') );

  <?php } ?>

    });

  function reset_view(){

  // $('#from').data("DateTimePicker").viewMode('days');
  
  // $('#to').data("DateTimePicker").viewMode('years'); 
  }
</script>
