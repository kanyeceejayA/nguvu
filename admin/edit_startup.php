<?php include '../assets/header_admin.php'; ?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Edit Startup</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


<?php
$s_id = $_GET['p'];
$stmt = $pdo->prepare("select * from startups where s_id ='$s_id';");
    $stmt->execute(array($s_id));
    foreach ($stmt as $row) {
      $name = $row['name'];
      $type_id = $row['type_id'];
      $type_id2 = $row['type_id2'];
      $f_year = $row['f_year'];
      $phone = $row['phone'];
      $email = $row['email'];
      $location = $row['location'];
      $status_id = $row['status_id'];
      $funding_stage = $row['funding_stage'];
      $employees = $row['employees'];
      $website = $row['website'];
      $facebook = $row['facebook'];
      $twitter = $row['twitter'];
      $linkedin = $row['linkedin'];
      $description = $row['description'];

      $logo = logo_check($row['logo']);
    }

$stmt = $pdo->prepare("select count(f_name) no_founders from founders where s_id ='$s_id';");
    $stmt->execute(array());
    foreach ($stmt as $row) {
      $no_founders = $row['no_founders'];
    }

?>




  <main class="main main-raised">
    <br>
    <?php 
                if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
                $_SESSION['message'] = null;
              ?>  
      <form class="container" method="POST" action="../actions/update-startup.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-4">

            <h4>Editing details for <?php echo $name.' with startup id '.$s_id; ?></h4>

            <div class="form-group bmd-form-group">
              <label for="name" class="bmd-label">name</label><br>
              <input required type="text" class="form-control" name="name" value="<?php echo $name;?>">
              <input required type="hidden" class="form-control" name="s_id" value="<?php echo $s_id;?>">
            </div> <!-- form-group -->

            <input type="file" name="logo" class="form-control" accept="image/x-png,image/jpeg">
            
            <div class="form-group bmd-form-group">
              <label for="f_year" class="bmd-label">Founding Year</label><br>
              <input required type="text" class="form-control datetimepicker" name="f_year" value="<?php echo $f_year;?>" id="f_year">
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="description" class="bmd-label">Description</label><br>
              <textarea  type="textarea" class="form-control" name="description" value="<?php echo $description;?>" maxlength="1000" rows="3"><?php echo $description;?></textarea>
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="type_id" class="">Sector</label>
              <select required type="text" class="form-control" name="type_id" value="<?php echo $type_id;?>">
                <?php
                  $stmt = $pdo->prepare("select * from type where type_id= '$type_id';");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."' selected>".$row['type']."</option>\n";
                  }
                  $stmt = $pdo->prepare("select * from type where type_id != '$type_id';");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."'>".$row['type']."</option>\n";
                  }
                ?>
              </select>
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="type_id2" class="">2nd Sector(if it applies)</label>
              <select type="text" class="form-control" name="type_id2" value="<?php echo $type_id2;?>" value="0">
                <?php
                  $stmt = $pdo->prepare("select * from type where type_id = $type_id2;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."' selected>".$row['type']."</option>\n";
                  }
                  $stmt = $pdo->prepare("select * from type where type_id != $type_id2 order by type_id;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."'>".$row['type']."</option>\n";
                  }
                ?>
              </select>
            </div> <!-- form-group -->
            <div class="row" >
            <div class="form-group bmd-form-group col-sm-6">
                <label for="phone" class="bmd-label">Company phone</label><br>
                <input type="text" class="form-control" name="phone" value="<?php echo $phone;?>">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group col-sm-6">
                <label for="email" class="bmd-label">Company email</label><br>
                <input type="text" class="form-control" name="email" value="<?php echo $email;?>">
              </div> <!-- form-group -->
            </div>

                <h4>Location</h4>

            <div class="form-group bmd-form-group">
              <label for="location" class="bmd-label">Location (Headquarters)</label><br>
              <input required type="text" class="form-control" name="location" value="<?php echo $location;?>">
            </div> <!-- form-group -->
        

            <div class="form-group bmd-form-group row">
              <label for="type_id" class="col-sm-4">Countries of Operation:</label>
              <select type="text" class="form-control col-sm-8" id="c_list" onchange="lister()">
                <?php
                  $stmt = $pdo->prepare('select country_id,name from countries;');
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['country_id']."'>".$row['name']."</option>\n";
                  }
                ?>
              </select>
              <select type="text" class="" name= "country_id[]" id="c_values" multiple hidden>
                <?php
                  $stmt = $pdo->prepare("select country_id,name FROM countries c join c_of_operation co on c.country_id = co.c_id where s_id = $s_id;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['country_id']."' selected>".$row['name']."</option>\n";
                  }
                  $stmt = $pdo->prepare("select country_id,name, s_id FROM c_of_operation co right join countries c on c_id = country_id where s_id !=2 or s_id is NULL;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['country_id']."'>".$row['name']."</option>\n";
                  }
                ?>
              </select>
              <br><br>
              <span id="chosen" style="display:block;cursor: pointer;">Countries:&nbsp;</span>
            </div> <!-- form-group -->

          </div> <!-- About Company Col -->

          <div class="col-sm-6 ml-auto">
          

            <h4>Team</h4>
            <div class="form-group bmd-form-group">

              <label for="employees" class="bmd-label">employees: </label><br>
              <input  required type="text" class="form-control" name="employees" value="<?php echo $employees;?>">
            </div> <!-- form-group -->

              <h5>Co-Founders</h5>
              <div class="form-group bmd-form-group row">
                <label for="status_id" class="col-sm-4">No of Founders:</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="no_founders" id="no_founders" value="<?php echo $no_founders;?>" max="10" min="1">
                  <button type="button" id="btn_founders" class="btn btn-round" onclick="update_founders()">Update</button>
                </div>
              </div>

              <div id="founders_parent">
                <?php 
                  $i=1;
                  $stmt = $pdo->prepare("select * from founders where s_id = '$s_id' order by f_id asc;");
                  $stmt->execute();
                  foreach ($stmt as $row) {

                          echo '
                    <h5 style="margin-bottom: -1.5em">Founder '.$i.'</h5>
                    <div class="row" id="founder'.$i.'">
                      <div class="form-group bmd-form-group col-sm-4">
                        <label for="f_name'.$i.'" class="bmd-label-floating">Founder\'s name</label>
                        <input  type="text" class="form-control" name="f_name'.$i.'" value="'.$row["f_name"].'">
                      </div> <!-- form-group -->
                      <div class="form-group bmd-form-group col-sm-4">
                        <label for="f_email'.$i.'" class="bmd-label-floating">Founder\'s email</label>
                        <input  type="email" class="form-control" name="f_email'.$i.'" value="'.$row["f_email"].'">
                      </div> <!-- form-group -->
                      <div class="form-group bmd-form-group col-sm-4">
                        <label for="f_phone'.$i.'" class="bmd-label-floating">Founder\'s Phone</label>
                        <input  type="text" class="form-control" name="f_phone'.$i.'" value="'.$row["f_phone"].'">
                      </div> <!-- form-group -->
                    </div> <!-- founder row -->';
                    $i+=1;
                   } ?>
              

            </div> <!-- founders group -->
              <div class="form-group bmd-form-group row">
                <label for="status_id" class="col-sm-4">Company Status:</label>
                <select required type="text" class="form-control col-sm-4" name="status_id" value="<?php echo $status_id;?>">
                <?php
                  $stmt = $pdo->prepare("select * from status where status_id=$status_id;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['status_id']."'>".$row['status']."</option>\n";
                  }
                  $stmt = $pdo->prepare("select * from status where status_id != $status_id;");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['status_id']."'>".$row['status']."</option>\n";
                  }
                ?>
              </select>
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group row">
                <label for="funding_stage" class="col-sm-4">Funding Stage:</label>
                <select required type="text" class="form-control col-sm-4" name="funding_stage" value="<?php echo $funding_stage;?>">
                  <option value="seed" <?php if($funding_stage=='seed'){echo 'selected';}?> >seed</option>
                  <option value="Series A" <?php if($funding_stage=='Series A'){echo 'selected';}?> >Series A</option>
                  <option value="Series B" <?php if($funding_stage=='Series B'){echo 'selected';}?> >Series B</option>
                  <option value="Series C" <?php if($funding_stage=='Series C'){echo 'selected';}?> >Series C</option>
                  <option value="Series D" <?php if($funding_stage=='Series D'){echo 'selected';}?> >Series D</option>
                  <option value="Series E" <?php if($funding_stage=='Series E'){echo 'selected';}?> >Series E</option>
                  <option value="I.P.O" <?php if($funding_stage=='I.P.O'){echo 'selected';}?> >I.P.O</option>
                  <option value="M&A" <?php if($funding_stage=='M&A'){echo 'selected';}?> >M&A</option>
                </select>
              </div> <!-- form-group -->

              <h5>Website & Social Media</h5>
              <div class="form-group bmd-form-group">
                <label for="website" class="bmd-label-floating">website</label>
                <input type="text" class="form-control" name="website" value="<?php echo $website;?>">
                <span class="bmd-help">enter the company website url here</span>
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="facebook" class="bmd-label-floating">facebook</label>
                <input type="text" class="form-control" name="facebook" value="<?php echo $facebook;?>">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="twitter" class="bmd-label-floating">twitter</label>
                <input type="text" class="form-control" name="twitter" value="<?php echo $twitter;?>">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="linkedin" class="bmd-label-floating">linkedin</label>
                <input type="text" class="form-control" name="linkedin" value="<?php echo $linkedin;?>">
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
    node=document.getElementById('no_founders');
    node.addEventListener("keyup", function(event) {
    if (event.key === "Enter") {
        // this.preventDefault();
        document.getElementById('btn_founders').click();
    }
});
  
</script>