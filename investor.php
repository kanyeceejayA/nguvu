<?php include 'actions/db_connection.php';
      $page='Investor';
      if (!isset($_GET['p'])) {
        header('location:investors');
      }
      $stmt = $pdo->prepare('select * from investors_view where inv_id=?');
      $stmt->execute(array($_GET['p']));

      if($stmt->rowCount()!=1){
        header('location:investors');
      }
      foreach ($stmt as $row) {
    
        $inv_id = $row['inv_id']; 
        $logo = logo_check($row['logo']); 
        $name = $row['name']; 
        $phone = $row['phone']; 
        $email = $row['email']; 
        $location = $row['location']; 
        $sector = $row['sector']; 
        $status = $row['status']; 
        $website = $row['website']; 
        $facebook = $row['facebook']; 
        $twitter = $row['twitter']; 
        $linkedin = $row['linkedin']; 
        $description = $row['description'];
        $countries = $row['countries'];

        //post processing
        $countries = str_replace(',', ', ', $countries);
      }
      $page = $name;
      include 'assets/header.php'; ?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Investor Profile</h1>
          </div>
        </div>
      </div>
    </div>
  </div>8
  <?php
    $stmt = $pdo->prepare('select * from investors_view where inv_id=?');
    $stmt->execute(array($_GET['p']));
    foreach ($stmt as $row) {
  
      $inv_id = $row['inv_id']; 
      $logo = logo_check($row['logo']); 
      $name = $row['name']; 
      $phone = $row['phone']; 
      $email = $row['email']; 
      $location = $row['location']; 
      $sector = $row['sector']; 
      $status = $row['status']; 
      $website = $row['website']; 
      $facebook = $row['facebook']; 
      $twitter = $row['twitter']; 
      $linkedin = $row['linkedin']; 
      $description = $row['description'];
      $countries = $row['countries'];

      //post processing
      $countries = str_replace(',', ', ', $countries);
    }
  ?>
  <?php
          //get Recent Investments  
          $stmt = $pdo->prepare('select * from funding_view where inv_id=?');
          $stmt->execute(array($_GET['p']));

          $s_name = array();
          $amount = 0;
          $amount_array = array();
          foreach ($stmt as $row) {
            $new_name="<a href='profile?p=".$row['s_id']."'>".$row['s_name']." - ".format_money($row['amount'])."</a>";

            if (!(in_array($new_name, $s_name))) {
              array_push($s_name, $new_name);
            }
            $amount += $row['amount'];
          }
          $s_name = implode('<br>', $s_name);

          //Format the money
          $amount =format_money($amount);
          

        ?>
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
          <p class="title">Total Recorded funding<br> <span><?php echo $amount;?></span></p>
          <?php if(isset($_SESSION['username'])){ ?>
              <a href='admin/edit_investors?p=<?php echo $inv_id;?>'><i class='fa fa-edit'></i>&nbsp;Edit Investor</a><br>
            <?php } ?>
        </div>
      </div> <!-- row -->

      <div class="row">
        <div class="col-sm-9">
      <div class="row value">
        <div class="col-sm-2">Sectors:</div>
        <div class="col-sm-8"><?php echo $sector;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Countries:</div>
        <div class="col-sm-8"><?php echo $countries;?></div>
      </div> <!-- row of values -->
      <div class="row value">
        <div class="col-sm-2">Funding Status:</div>
        <div class="col-sm-8"><span class="badge badge-pill badge-success"><?php echo $status;?></span></div>
      </div> <!-- row of values -->
        <h4><strong>About</strong></h4>
      <div class="row">
        <h4 class="col"><?php echo $description; ?></h4>
      </div>
    </div>
    <div class="card col-sm-3">
      <div class="card-body">

        <p><span class="title">Recent Investments:</span><?php echo $s_name;?></p>

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
      </style>
      
    </div> <!-- container -->
    <br>
  </main>

<?php include 'assets/footer.php'; ?>