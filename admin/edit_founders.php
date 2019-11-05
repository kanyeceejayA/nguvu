<?php include '../assets/header_admin.php'; ?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Edit Founder's Details</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


<?php
$f_id = $_GET['p'];
$stmt = $pdo->prepare("select f_id,s.s_id,f_name,f_email,f_phone, name s_name from founders f join startups s on s.s_id = f.s_id where f_id ='$f_id';");
    $stmt->execute(array($f_id));
    foreach ($stmt as $row) {
      $f_name = $row['f_name'];
      $f_email = $row['f_email'];
      $f_phone = $row['f_phone'];
      $s_name = $row['s_name'];
      $s_id = $row['s_id'];
    }

?>




  <main class="main main-raised">
    <br>
    <?php 
                if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
                $_SESSION['message'] = null;
              ?>  
      <form class="container" method="POST" action="../actions/update-founder.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-4">

            <h4>Editing details for <?php echo $f_name.' from '.$s_name; ?></h4>

            <div class="form-group bmd-form-group">
              <label for="f_name" class="bmd-label">Founder's name</label><br>
              <input required type="text" class="form-control" name="f_name" value="<?php echo $f_name;?>">
              <input required type="hidden" class="form-control" name="f_id" value="<?php echo $f_id;?>">
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="f_email" class="bmd-label">Founder's Email</label><br>
              <input required type="email" class="form-control" name="f_email" value="<?php echo $f_email;?>">
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="f_phone" class="bmd-label">Founder's Phone Number</label><br>
              <input required type="text" class="form-control" name="f_phone" value="<?php echo $f_phone;?>">
            </div> <!-- form-group -->

         
            <div class="form-group bmd-form-group">
              <label for="type_id" class="">Startup</label>
              <select required type="text" class="form-control" name="type_id" value="<?php echo $type_id;?>">
                <?php
                  $stmt = $pdo->prepare("select s_id,name from startups where s_id = '$s_id';");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['s_id']."' selected>".$row['name']." (current)</option>\n";
                  }
                  $stmt = $pdo->prepare("select s_id,name from startups where s_id != '$s_id';");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['s_id']."'>".$row['name']."</option>\n";
                  }
                ?>
              </select>
            </div> <!-- form-group -->

              <button class="btn btn-primary btn-round">
                <i class="material-icons">save</i> Submit
              <div class="ripple-container"></div></button>


    
            </div><!-- col -->
        </div><!-- row -->
      </form><!-- container/form -->
      <br>
  </main>


      <script type="text/javascript">
             
              function lister(argument) {
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

<script type="text/javascript">
    $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      $('#f_year').data("DateTimePicker").format('YYYY');

       $("#f_year").val(<?php echo $f_year;?>);
    });

  function update_founders() {
                i=1;
                no = document.getElementById('no_founders').value;
                parent = document.getElementById('founders_parent');
                parent.innerHTML='';
                // alert(no);
                if(no<=10 && no>=1){
                  while(i<=no){
                    parent.innerHTML += '<h5 style="margin-bottom: -1.5em">Founder '+i+'</h5>'+
                                          '<div class="row" id="founder'+i+'">'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_name'+i+'" class="bmd-label">Founder\'s name</label><br>'+
                                              '<input  type="text" class="form-control" name="f_name'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_email'+i+'" class="bmd-label">Founder\'s email</label><br>'+
                                              '<input  type="email" class="form-control" name="f_email'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_phone'+i+'" class="bmd-label">Founder\'s Phone</label><br>'+
                                              '<input  type="text" class="form-control" name="f_phone'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                          '</div> <!-- founder'+i+' row -->';
                    i += 1;
                  }
                }
                else{
                  alert('please enter a number between 1 and 10');
                  document.getElementById('no_founders').value=1;
                }
              }
</script>