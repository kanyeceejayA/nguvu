<?php include 'actions/db_connection.php';
      $page='Add Funding';
      include 'assets/header.php';?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Add Deal</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <main class="main main-raised">
    <br>
      <form class="container" method="POST" action="actions/create-funding.php" enctype="multipart/form-data">

        <div class="col-md-8 ml-auto mr-auto">
          <?php 
              if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
              $_SESSION['message'] = null;
          ?>  
          <div class="form-group bmd-form-group">
            <label for="s_id" class="bmd-label">Startup</label><br>
            <select required type="text" class="form-control" name="s_id">
              <?php
                $stmt = $pdo->prepare('select s_id,name from startups;');
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "<option value='".$row['s_id']."'>".$row['name']."</option>\n";
                }
              ?>
            </select>
          </div>

          <div class="form-group bmd-form-group">
            <label for="inv_id" class="bmd-label">Investor:</label><br>
            <select required type="text" class="form-control" name="inv_id">
              <?php
                $stmt = $pdo->prepare("select inv_id,name from investors where inv_id = '0';");
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "<option value='".$row['inv_id']."' selected>".$row['name']."</option>\n";
                }
                $stmt = $pdo->prepare('select inv_id,name from investors where inv_id != 0;');
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "<option value='".$row['inv_id']."'>".$row['name']."</option>\n";
                }
              ?>
            </select>
          </div>
<!-- 
          <div class="form-group bmd-form-group">
            <label for="amount" class="bmd-label-floating">Amount:</label>
            <input type="text" class="form-control" name="amount" id="amount">
            <span class="bmd-help">Enter the Amount given in Dollars.</span>
          </div>
 -->
          <div class="form-group bmd-form-group">
            <label for="amount" class="bmd-label">Amount:</label><br>
            <div class="input-group" id="amount_holder">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  US $
                </span>
              </div>
              <input type="text" class="form-control" name="amount" id="amount" required>
            </div>
              <span class="bmd-help">Enter the  amount given in US Dollars</span>
          </div>

          <div class="togglebutton">
            <label>
              <input type="checkbox" id="noAmount" onclick="no_amount()">
              <span class="toggle"></span>
              Undisclosed Amount
            </label>
          </div>

          <div class="form-group bmd-form-group">
            <label for="round" class="bmd-label">Round/Type of Funding:</label><br>
            <select class="form-control" name="round">
              <option value="Equity">Equity</option>
              <option value="Grant">Grant/Prize</option>
              <option value="Debt">Debt</option>
              <option value="Other">Other</option>
            </select>
            <span class="bmd-help">Enter the round during which this funding occured.</span>
          </div>

          <div class="form-group bmd-form-group is-filled">
            <label class="label-control bmd-label-static">Date</label>
            <input required type="text" class="form-control datetimepicker" id="d_date" value="<?php echo date('d/m/Y')?>" name="d_date">
          </div>

          <div class="form-group bmd-form-group">
            <label for="source" class="bmd-label-floating">Source:</label>
            <input type="round" class="form-control" name="source">
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

<?php include 'assets/footer.php'; ?>
<script src="assets/js/plugins/moment.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="assets/js/plugins/jquery.MaskMoney.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      $('#d_date').data("DateTimePicker").format('YYYY-MM-DD');

       $("#d_date").val( moment().format('YYYY-MM-DD') );
    });

    $("#amount").maskMoney({
        prefix:'',
        formatOnBlur:false,
        allowNegative:true,
        allowEmpty:true,
        doubleClickSelection:true,
        precision: 0
      });

  
</script>
