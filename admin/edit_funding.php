<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} include '../assets/header_admin.php';

    //select investors data
    $stmt = $pdo->prepare("select inv_id,name from investors where inv_id = '0';");
    $stmt->execute();
    $selectdata='';
    foreach ($stmt as $row) {
        $selectdata .= "<option value='".$row['inv_id']."'>".$row['name']."</option>\n";
    }
    //add other rows to investor data
    $stmt = $pdo->prepare('select inv_id,name from investors');
    $stmt->execute();
    foreach ($stmt as $row) {
        $selectdata.= "<option value='".$row['inv_id']."'>".$row['name']."</option>\n";
    }

    //fetch generic data about deal from first row of deals table
    $deal_id = $_GET['p'];
    $stmt = $pdo->prepare("select d_id,s_id,inv_id,amount,round,d_date,source from deals where d_id ='$deal_id';");
    $stmt->execute();
    foreach ($stmt as $row) {
      $s_id = $row['s_id']; 
      $inv_id = $row['inv_id']; 
      $amount = $row['amount']; 
      $round = $row['round']; 
      $d_date = $row['d_date']; 
      $source = $row['source']; 
    }

    //fetch No of investors
    $stmt = $pdo->prepare("select count(inv_id) no_investors from deals where deal_id ='$deal_id';");
    $stmt->execute(array());
    foreach ($stmt as $row) {
      $no_investors = $row['no_investors'];
    }

?> 
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Edit Funding</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <main class="main main-raised">
    <br>
      <form class="container" method="POST" action="../actions/update-funding.php" enctype="multipart/form-data">

        <input type="hidden" name="deal_id" value="<?php echo $deal_id;?>">
        <div class="col-md-8 ml-auto mr-auto">
          <?php 
              if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
              $_SESSION['message'] = null;
          ?>  
          <div class="form-group bmd-form-group">
            <label for="s_id" class="bmd-label">Startup</label><br>
            <select required type="text" class="form-control" name="s_id" value="<?php echo $s_id;?>">
           <?php
                $stmt = $pdo->prepare("select s_id,name from startups where s_id = '$s_id';");
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "<option value='".$row['s_id']."' selected>".$row['name']."</option>\n";
                }

                $stmt = $pdo->prepare("select s_id,name from startups where s_id != '$s_id';");
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "<option value='".$row['s_id']."'>".$row['name']."</option>\n";
                }
              ?>
            </select>
          </div>

          <div class="form-group bmd-form-group row">
            <label for="status_id" class="col-sm-4">No of Investors:</label>
            <div class="col-sm-4">
              <input type="number" class="form-control" name="no_investors" id="no_investors" min="1" value="<?=$no_investors?>">
              <button type="button" id="btn_investors" class="btn btn-round" onclick="update_investors()">Update</button>
            </div>
          </div>

          <div id="investors_parent">
            <?php 
              $i=1;
              $stmt = $pdo->prepare("select deal_id,inv_id from deals where deal_id ='$deal_id';");
              $stmt->execute();
              foreach ($stmt as $row) {
            ?>
              <div class="form-group bmd-form-group">
                <label for="inv_id<?=$i?>" class="bmd-label">Investor <?=$i?>:</label><br>
                <select required type="text" class="form-control" name="inv_id<?=$i?>">
                <?php //first add the current result
                  $inv_id = $row['inv_id'];
                  $stmt = $pdo->prepare("select name from investors where inv_id=$inv_id");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    $name = $row['name'];
                      echo "<option selected value='$inv_id'>$name</option>\n";
                  }
                  //add other rows
                  echo $selectdata;
                ?>
                </select>
              </div>


            <?php $i++;} ?>
                  
          </div>

          <div class="form-group bmd-form-group">
            <label for="amount" class="bmd-label">Amount:</label><br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  US $
                </span>
              </div>
              <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $amount;?>">
            </div>
              <span class="bmd-help">Enter the  amount given in US Dollars</span>
          </div>

          <div class="form-group bmd-form-group">
            <label for="round" class="bmd-label">Round/Type of Funding:</label><br>
            <select class="form-control" name="round">
              <option value="Equity"<?php if($round=='Equity'){echo "selected";} ?> >Equity</option>
              <option value="Grant"<?php if($round=='Grant'){echo "selected";} ?> >Grant/Prize</option>
              <option value="Debt"<?php if($round=='Debt'){echo "selected";} ?> >Debt</option>
              <option value="Other"<?php if($round=='Other'){echo "selected";} ?> >Other</option>
            </select>
            <span class="bmd-help">Enter the round during which this funding occured.</span>
          </div>

          <div class="form-group bmd-form-group is-filled">
            <label class="label-control bmd-label-static">Date</label>
            <input required="" type="text" class="form-control datetimepicker" value="<?php echo $d_date;?>" id="d_date" name="d_date" >
          </div>

          <div class="form-group bmd-form-group">
            <label for="source" class="bmd-label-floating">Source:</label>
            <input type="round" class="form-control" name="source" value="<?php echo $source;?>">
            <span class="bmd-help">Paste the link to the Source of this information.</span>
          </div>

          <button class="btn btn-primary btn-round" name="submit">
                <i class="material-icons">save</i> Submit
          </button>

        </div>
      </form><!-- container/form -->
      <br>
  </main>


      <script type="text/javascript">
             
              function lister(argument) {
                chosen = document.getElementById('chosen');
                c_list = document.getElementById('c_list');
                c_values = document.getElementById('c_values');
                chosen.innerHTML += ' <span id="'+c_list.selectedIndex+'" onclick="del('+c_list.selectedIndex+')" class="badge badge-pill badge-success">X  '+c_list.options[c_list.selectedIndex].text+'</span>';

                c_values.options[c_list.selectedIndex].selected= true;
              }
              function del(index) {
                var elem = document.getElementById(index);
                c_values = document.getElementById('c_values');
                elem.parentNode.removeChild(elem);

                c_values.options[index].selected= false;
              }

              function set_country_value(selectObj, txtObj) {
                var letter = txtObj.value;
               
                for(var i = 0; i < selectObj.length; i++) {
                  if(selectObj.options[i].value.charAt(0) == letter) {
                    selectObj.options[i].selected = true;
                  } else {
                    selectObj.options[i].selected = false;
                  }
                }

              }
            </script>

<?php include '../assets/footer_admin.php'; ?>
<script src="../assets/js/plugins/moment.min.js" type="text/javascript"></script>
<script src="../assets/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="../assets/js/plugins/jquery.MaskMoney.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      $('#d_date').data("DateTimePicker").format('YYYY-MM-DD');

       $("#d_date").val('<?php echo $d_date;?>' );
    });

    $("#amount").maskMoney({
        prefix:'',
        formatOnBlur:false,
        allowNegative:true,
        allowEmpty:true,
        doubleClickSelection:true,
        precision: 0
      });

      function update_investors() {
        i=1;
        no = document.getElementById('no_investors').value;
        parent = document.getElementById('investors_parent');
        parent.innerHTML='';
        if(no>=1){
          while(i<=no){
            parent.innerHTML += `<div class='form-group bmd-form-group'>
                                  <label for='inv_id${i}' class="bmd-label">Investor ${i}:</label><br>
                                    <select required type="text" class="form-control" name="inv_id${i}">
                                      <?php echo $selectdata;?>
                                    </select>
                                  </div>`;
            i += 1;
          }
        }
        else{
          alert('please enter a number between 1 and 10');
          document.getElementById('no_investors').value=1;
        }
      }
  
</script>