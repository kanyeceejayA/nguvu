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
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
} include 'assets/header.php';


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
      </div> <!-- logo and name -->

      <div class="row">
        <div class="col-sm-9">

            <div class="row value">
              <div class="col-sm-2">Categories:</div>
              <div class="col-sm-8"><?php echo $type.', '.$type2;?></div>
            </div> <!-- row of categories -->            <div class="row value">
              <div class="col-sm-2">Founded:</div>
              <div class="col-sm-8"><?php echo $f_year;?></div>
            </div> <!-- row of founded -->
            <div class="row value">
              <div class="col-sm-2">Founders:</div>
              <div class="col-sm-8"><?php echo $founders;?></div>
            </div> <!-- row of founders -->
            <div class="row value">
              <div class="col-sm-2">Countries:</div>
              <div class="col-sm-8"><?php echo $countries;?></div>
            </div> <!-- row of countries -->
            <div class="row value">
              <div class="col-sm-2">Funding Status:</div>
              <div class="col-sm-8"><span class="badge badge-pill badge-success"><?php echo $status;?></span></div>
            </div> <!-- row of funding status -->
            <div class="row value">
              <div class="col-sm-2">Employees:</div>
              <div class="col-sm-8"><?php echo $employees;?></div>
            </div> <!-- row of employees -->
              <h4><strong>Description</strong></h4>
            <div class="row">
              <h4 class="col"><?php echo $description; ?></h4>
            </div> <!-- description -->
        </div> <!-- left column - sm-9 -->

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
        </div>  <!-- side card -->

      </div> <!-- Main Content details and side card -->

      <br>
   <?php 
        $query = "SELECT d_id,i.logo,s.name as name, s.location location,i.inv_id inv_id, d.s_id, i.name i_name, i.location i_location,amount,round,d_date, source FROM deals d join startups s on d.s_id = s.s_id JOIN investors i on d.inv_id = i.inv_id where s.s_id='$s_id' order by d_date desc";
                $stmt = $pdo->prepare($query);

              $stmt->execute();

              if($stmt->rowCount()>1){
        ?>
      <h4 class="title" style="text-align: center;">Recent Funding for<?php echo $name; ?></h4>
      <div class="container ml-auto mr-auto">
          <br><!-- Heading -->
          <div class="row header  d-none d-lg-flex d-md-flex">
              <div class="col-md-2"><span>Logo</span></div>
              <div class="col-md-4"><span>Investor</span></div>
              <div class="col-md-4"><span>Amount / Round</span></div>
              <div class="col-md-2"><span>Date / Source</span></div>
          </div>

          <div id="cardholder">
         <?php //return results
              
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
                        <div class='col-md-2'>
                          <img src='$logo' class='row-logo'>
                        </div>
                        <div class='col-md-4'>
                          <div class='text-uppercase font-weight-bold d-lg-none d-sm-none'>Investor/Location</div>
                          <a href='investor?p=$inv_id'>
                            <strong style='font-size:1.5em;'>$i_name</strong>
                          </a>
                          <span>$i_location</span>
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
      <div class="container ml-auto mr-auto">
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

  </div>
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
        .title .small a {
            font-size: 1.2em;
            color: #9c27b0;
        }
</style>
<script>
</script>
<?php include 'assets/footer.php'; ?>