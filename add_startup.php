<?php include 'actions/db_connection.php';
      $page='Register Startup';
      include 'assets/header.php'; session_start(); ?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Register Startup</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <main class="main main-raised">
    <br>
 <?php 
                if (isset($_SESSION['message'])){echo $_SESSION['message'];}  
                $_SESSION['message'] = null;
              ?>  
      <form class="container" method="POST" action="actions/create.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-4">
            <h4>About Company</h4>

            <div class="form-group bmd-form-group">
              <label for="name" class="bmd-label-floating">name</label>
              <input required type="text" class="form-control" name="name">
            </div> <!-- form-group -->

            <input type="file" name="logo" class="form-control" accept="image/x-png,image/jpeg">
            
            <div class="form-group bmd-form-group">
              <label for="f_year" class="bmd-label">Founding Year</label><br>
              <input required type="text" class="form-control datetimepicker" name="f_year" id="f_year">
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="description" class="bmd-label">Description</label><br>
              <textarea  type="textarea" class="form-control" name="description" maxlength="1000" rows="3"></textarea>
            </div> <!-- form-group -->
            <div class="form-group bmd-form-group">
              <label for="type_id" class="">Sector</label>
              <select required type="text" class="form-control" name="type_id">
             <?php
                  $stmt = $pdo->prepare('select * from type;');
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."'>".$row['type']."</option>\n";
                  }
                ?>
              </select>
            </div> <!-- form-group -->

            <div class="form-group bmd-form-group">
              <label for="type_id2" class="">2nd Sector(if it applies)</label>
              <select type="text" class="form-control" name="type_id2" value="0">
             <?php
                  $stmt = $pdo->prepare('select * from type order by type_id;');
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['type_id']."'>".$row['type']."</option>\n";
                  }
                ?>
              </select>
            </div> <!-- form-group -->
            <div class="row" >
            <div class="form-group bmd-form-group col-sm-6">
                <label for="phone" class="bmd-label-floating">Company phone</label>
                <input type="text" class="form-control" name="phone">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group col-sm-6">
                <label for="email" class="bmd-label-floating">Company email</label>
                <input type="text" class="form-control" name="email">
              </div> <!-- form-group -->
            </div>

                <h4>Location</h4>

            <div class="form-group bmd-form-group">
              <label for="location" class="bmd-label-floating">Location (Headquarters)</label>
              <input required type="text" class="form-control" name="location">
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
              <select type="text" class="" name="country_id[]" id="c_values" multiple hidden>
             <?php
                  $stmt = $pdo->prepare('select country_id,name from countries;');
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
              <input  required type="text" class="form-control" name="employees" value="">
            </div> <!-- form-group -->

            <h5>Co-Founders</h5>
              <div class="form-group bmd-form-group row">
                <label for="status_id" class="col-sm-4">No of Founders:</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="no_founders" id="no_founders" value="1" max="10" min="1">
                  <button type="button" id="btn_founders" class="btn btn-round" onclick="update_founders()">Update</button>
                </div>
              </div>
            
            <div id="founders_parent">
              <h5 style="margin-bottom: -1.5em">Founder 1</h5>
              <div class="row" id="founder1">
                <div class="form-group bmd-form-group col-sm-4">
                  <label for="f_name1" class="bmd-label-floating">Founder's name</label>
                  <input  type="text" class="form-control" name="f_name1">
                </div> <!-- form-group -->
                <div class="form-group bmd-form-group col-sm-4">
                  <label for="f_email1" class="bmd-label-floating">Founder's email</label>
                  <input  type="email" class="form-control" name="f_email1">
                </div> <!-- form-group -->
                <div class="form-group bmd-form-group col-sm-4">
                  <label for="f_phone1" class="bmd-label-floating">Founder's Phone</label>
                  <input  type="text" class="form-control" name="f_phone1">
                </div> <!-- form-group -->
              </div> <!-- founder row -->

            </div> <!-- founders group -->

              <div class="form-group bmd-form-group row">
                <label for="status_id" class="col-sm-4">Company Status:</label>
                <select required type="text" class="form-control col-sm-4" name="status_id">
             <?php
                  $stmt = $pdo->prepare('select * from status;');
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    echo "<option value='".$row['status_id']."'>".$row['status']."</option>\n";
                  }
                ?>
              </select>
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group row">
                <label for="funding_stage" class="col-sm-4">Funding Stage:</label>
                <select required type="text" class="form-control col-sm-4" name="funding_stage">
                  <option value="seed">seed</option>
                  <option value="Series A">Series A</option>
                  <option value="Series B">Series B</option>
                  <option value="Series C">Series C</option>
                  <option value="Series D">Series D</option>
                  <option value="Series E">Series E</option>
                  <option value="I.P.O">I.P.O</option>
                  <option value="M&A">M&A</option>
                </select>
              </div> <!-- form-group -->

              <h5>Website & Social Media</h5>
              <div class="form-group bmd-form-group">
                <label for="website" class="bmd-label-floating">website</label>
                <input type="text" class="form-control" name="website">
                <span class="bmd-help">enter the company website url here</span>
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="facebook" class="bmd-label-floating">facebook</label>
                <input type="text" class="form-control" name="facebook">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="twitter" class="bmd-label-floating">twitter</label>
                <input type="text" class="form-control" name="twitter">
              </div> <!-- form-group -->

              <div class="form-group bmd-form-group">
                <label for="linkedin" class="bmd-label-floating">linkedin</label>
                <input type="text" class="form-control" name="linkedin">
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

<?php include 'assets/footer.php'; ?>
<script src="assets/js/plugins/moment.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      $('#f_year').data("DateTimePicker").format('YYYY');

       $("#f_year").val( moment().format('YYYY') );
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