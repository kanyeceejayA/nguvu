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
      }
      $page = $name;
      if (session_status() == PHP_SESSION_NONE) {
    session_start();
} include 'assets/header.php'; ?>
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

    }
  ?>
<?php
          //get Recent Investments  
          $stmt = $pdo->prepare('select * from funding_view where inv_id=? order by d_date desc LIMIT 5');
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
        <span class="title">Social Links:</span>
          <span style='font-size:1em;'>
              <a href='<?php echo $facebook;?>' target='_blank' rel='noopener'><i class='fa fa-facebook'></i>&nbsp;Facebook</a><br>
              <a href='<?php echo $twitter;?>' target='_blank' rel='noopener'><i class='fa fa-twitter'></i>&nbsp;Twitter</a><br>
              <a href='<?php echo $linkedin;?>' target='_blank' rel='noopener'><i class='fa fa-linkedin'></i>&nbsp;LinkedIn</a><br>
              <a href='<?php echo $website;?>' target='_blank' rel='noopener'><i class='fa fa-globe'></i>&nbsp;Website</a><br>
              
            </span>

        </div>
      </div>

      </div>
      <br>

         <?php 
        $query = "SELECT d_id,s.logo,s.name as name, s.location location,i.inv_id inv_id, d.s_id, i.name i_name, i.location i_location,amount,round,d_date, source FROM deals d join startups s on d.s_id = s.s_id JOIN investors i on d.inv_id = i.inv_id where i.inv_id='$inv_id' order by d_date desc";
                $stmt = $pdo->prepare($query);

              $stmt->execute();

              if($stmt->rowCount()>=1){
        ?>
      <h4 class="title" style="text-align: center;">Recent Funding from <?php echo $name; ?></h4>
      <div class="container col-md-10">
          <br><!-- Heading -->
          <div class="row header  d-none d-lg-flex d-md-flex">
              <div class="col-md-1"><span>Logo</span></div>
              <div class="col-md-5"><span>Startup</span></div>
              <div class="col-md-3"><span>Amount / Round</span></div>
              <div class="col-md-3"><span>Date / Source</span></div>
          </div>

          <div id="cardholder">
         <?php //return results
              
              foreach ($stmt as $row) {
                $d_id =$row['d_id'];
                $logo = logo_check($row['logo']);
                $location = $row['location'];
                $s_name = $row['name'];
                $inv_id = $row['inv_id'];
                $s_id = $row['s_id'];
                
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
                        <div class='col-md-5'>
                          <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Startup/Location</div>
                          <a href='profile?p=$s_id'>
                            <strong style='font-size:1.5em;'>$s_name</strong>
                          </a>
                          <span>$location</span>
                        </div>
                        <div class='col-md-3'>
                          <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Amount/Round</div>
                          <span>$amount</span>
                          <a class='badge badge-pill badge-success' href=''>$round</a>
                        </div>
                        <div class='col-md-3'>
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
      </div> <!-- Funding details -->



         <?php
       }
        $query = "select post_date,post_title,guid FROM wp_posts where (upper(post_title) LIKE '%".$name."%' or upper(post_content) LIKE upper('%".$name."%')) and post_type like '%post' and post_status = 'publish' order by post_date desc";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()>=1){

      ?>

      <h4 class="title" style="text-align: center;"><?php echo $name; ?> in the News</h4>
      <div class="container ml-auto mr-auto col-md-10">
          <br><!-- Heading -->
          <div class="row header  d-none d-lg-flex d-md-flex">
              <div class="col-md-9"><span>News Story</span></div>
              <div class="col-md-3"><span>Date</span></div>
          </div>

          <div id="cardholder" class="news">
         <?php //return results
              
              foreach ($stmt as $row) {
                $post_date = $row['post_date'];
                $post_date = date_format(date_create($post_date), 'd M Y');
                $post_title = $row['post_title'];
                $link = $row['guid'];
                
                echo "
                    <!-- $name card -->
                    <a class='card' href='$link' target='_blank' rel='noopener'>
                      <div class='row' style='padding:1.5em 0 1.5em 1em'>
                        
                        <div class='col-md-9'>
                          <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>title</div>
                          <div>
                            <strong style=''>$post_title <i class='fa fa-external-link' ></i></strong>
                          </div>
                        </div>

                        <div class='col-md-3'>
                          <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Date</div>
                          <span>$post_date</span>
                        </div>

                        
                      </div>
                    </a> <!-- card -->
                  ";
              }
            ?>
          </div> <!-- cardholder -->
          <br>
      </div> <!-- NEws Stories -->

 <?php } ?>

    </div> <!-- container -->
  </main>

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
      

<?php include 'assets/footer.php'; ?>
