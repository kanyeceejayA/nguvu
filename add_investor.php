<?php include 'actions/db_connection.php';
      $page='Add Investor';
      include 'assets/header.php'; ?>
  <div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand" style="text-align: center;">
            <br/>
            <h1 class="title" style="color: white">Register Investor</h1>
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
      <form class="container" method="POST" action="actions/create-investor.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-4">
            <h4>About Company</h4>

            <div class="form-group bmd-form-group">
              <label for="name" class="bmd-label-floating">name</label>
              <input required type="text" class="form-control" name="name">
            </div> <!-- form-group -->

            <input type="file" name="logo" class="form-control" accept="image/x-png,image/jpeg">
        

            <div class="form-group bmd-form-group">
              <label for="description" class="bmd-label">Description</label><br>
              <textarea type="textarea" class="form-control" name="description" maxlength="1000" rows="3"></textarea>
            </div> <!-- form-group -->
            <div class="form-group bmd-form-group">
              <label for="sector" class="">Main Sector Focus</label>
              <input required type="text" class="form-control" name="sector">
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

             <h4>Location</h4>

            <div class="form-group bmd-form-group">
              <label for="location" class="bmd-label-floating">Address (Headquarters)</label>
              <input required type="text" class="form-control" name="location">
            </div> <!-- form-group -->
        
          

              <div class="form-group bmd-form-group row">
                <label for="status" class="col-sm-4">Company Status:</label>
                <select required type="text" class="form-control col-sm-4" name="status">
                  <option>Active</option>
                  <option>Inactive</option>
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

              <button class="btn btn-primary btn-round" value="Submit">
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