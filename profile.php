<?php 
  include 'actions/db_connection.php';
  if (!isset($_GET['p'])) {
    header('location:startups');
  }
  $s_id=$_GET['p'];
  $stmt = $pdo->prepare('select * from single_startups_view where s_id=?');
  $stmt->execute(array($_GET['p']));
  if($stmt->rowCount()!=1){
    header('location:startups');
  }
  foreach ($stmt as $row) {
    $logo = logo_check($row['logo']);
    $name = $row['name'];
    $type = $row['type'];
    $location = $row['location'];
    $f_year = $row['f_year'];
    
    //handle money
    $funding =format_money($row['funding']);

    $status = $row['status'];
    $website = $row['website'];
    $facebook = $row['facebook'];
    $twitter = $row['twitter'];
    $linkedin = $row['linkedin'];

    $type2 = $row['type2'];
    $email = $row['email'];
    $funding_stage = $row['funding_stage'];
    $employees = $row['employees'];
    $founders = $row['founders'];
    $founders = str_replace(',', ', ', $founders);
    $countries = $row['countries'];
    $countries = str_replace(',', ', ', $countries);     
    $description = $row['description'];
  }
  $page=$name;
  include 'assets/header.php';


        //get startups invested in, and total money
          $stmt = $pdo->prepare('select * from funding_view where s_id=?');
          $stmt->execute(array($_GET['p']));

          $inv_name = array();
          $amount = 0;
          foreach ($stmt as $row) {
            $d_id = $row['d_id'];
            $new_name="<a href='investor?p=".$row['inv_id']."'>".$row['inv_name']."</a>";
            if (!(in_array($new_name, $inv_name))) {
              array_push($inv_name, $new_name);
            }
            $amount = $amount + $row['amount'];
          }
          $inv_name = implode('<br>', $inv_name);
?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Company Profile</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <main class="main main-raised">
    <br>
    <div class="container">
      <div class="row">
        <div id="logo" class="col-sm-2" style="align-self: center;">
          <img src="<?php echo $logo;?>" alt="Raised Image" class="img-raised rounded img-fluid">
        </div>
        <div class="col-sm-7">
          <h2 class="title"><?php echo $name;?><br>
          <small><?php echo $location;?></small></h2>
        </div>
        <div class="col-sm-3 card">
          <p class="title">Total Funding Amount<br> <span><?php echo $funding;?></span></p>
          <?php if(isset($_SESSION['username'])){ ?>
              <a href='admin/edit_startup?p=<?php echo $s_id;?>'><i class='fa fa-edit'></i>&nbsp;Edit Startup</a><br>
            <?php } ?>
        </div>
      </div> <!-- row -->

      <div class="row">
        <div class="col-sm-9">
      <div class="row value">
        <div class="col-sm-2">Categories:</div>
        <div class="col-sm-8"><?php echo $type.', '.$type2;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Founded:</div>
        <div class="col-sm-8"><?php echo $f_year;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Founders:</div>
        <div class="col-sm-8"><?php echo $founders;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Countries:</div>
        <div class="col-sm-8"><?php echo $countries;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Funding Status:</div>
        <div class="col-sm-8"><span class="badge badge-pill badge-success"><?php echo $status;?></span></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Employees:</div>
        <div class="col-sm-8"><?php echo $employees;?></div>
      </div> <!-- row of values -->
        <h4><strong>Description</strong></h4>
      <div class="row">
        <h4 class="col"><?php echo $description; ?></h4>
      </div>
    </div>
    <div class="card col-sm-3">
      <div class="card-body">
        <p><span class="title">Recent Investors:<span class="small" style="color:#9c27b0;"><?php echo $inv_name;?></span></span></p>
        <span class="title">Links:</span>
          <span style='font-size:1em;'>
              <a href='<?php echo $facebook;?>' target='_blank' rel='noopener'><i class='fa fa-facebook'></i>&nbsp;Facebook</a><br>
              <a href='<?php echo $twitter;?>' target='_blank' rel='noopener'><i class='fa fa-twitter'></i>&nbsp;Twitter</a><br>
              <a href='<?php echo $linkedin;?>' target='_blank' rel='noopener'><i class='fa fa-linkedin'></i>&nbsp;LinkedIn</a><br>
              <a href='<?php echo $website;?>' target='_blank' rel='noopener'><i class='fa fa-globe'></i>&nbsp;Website</a><br>
              
            </span>
        </div>
      </div>

      </div>

      <style type="text/css">
        .value{
          padding-bottom: 1em;
        }
        .value .col-sm-8{
          float: left;
          /*padding-right: 2em; */
        }
        .value .col-sm-2{
          font-weight: bold;
          /*max-width: 100px;*/
        }
        .title .small a {
            font-size: 1.2em;
            color: #9c27b0;
        }
      </style>
      
    </div> <!-- container -->
    <br>
  </main>

<?php include 'assets/footer.php'; ?>