<?php
	session_start();
	require("db_connection.php");

//start with if to capture empty statements
if(!isset($_POST["name"]) || !isset($_POST["s_id"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$s_id = $_POST['s_id'];

	//first get old values incase we need to use them for unset values
	$stmt = $pdo->prepare("select * from startups where s_id =?;");
    $stmt->execute(array($s_id));
    foreach ($stmt as $row) {
      $name_old = $row['name'];
      $type_id_old = $row['type_id'];
      $type_id2_old = $row['type_id2'];
      $f_year_old = $row['f_year'];
      $phone_old = $row['phone'];
      $email_old = $row['email'];
      $location_old = $row['location'];
      $status_id_old = $row['status_id'];
      $funding_stage_old = $row['funding_stage'];
      $employees_old = $row['employees'];
      $website_old = $row['website'];
      $facebook_old = $row['facebook'];
      $twitter_old = $row['twitter'];
      $linkedin_old = $row['linkedin'];
      $description_old = $row['description'];

      $logo_old = logo_check($row['logo']);
    }



    //now check for uploaded values. if they are missing, use old values
	$name = (isset($_POST["name"])) ?  test_input($_POST["name"]) :$name_old;
	$type_id = (isset($_POST["type_id"])) ? test_input($_POST["type_id"]) :$type_id_old;
	$type_id2 = (isset($_POST["type_id2"])) ? test_input($_POST["type_id2"]) :$type_id2_old;
	$f_year = (isset($_POST["f_year"])) ? test_input($_POST["f_year"]) :$f_year_old;
	$phone = (isset($_POST["phone"])) ? test_input($_POST["phone"]) :$phone_old;
	$email = (isset($_POST["email"])) ? test_input($_POST["email"]) :$email_old;
	$location = (isset($_POST["location"])) ? test_input($_POST["location"]) :$location_old;
	$status_id = (isset($_POST["status_id"])) ? test_input($_POST["status_id"]) :$status_id_old;
	$funding_stage = (isset($_POST["funding_stage"])) ? test_input($_POST["funding_stage"]) :$funding_stage_old;
	$employees = (isset($_POST["employees"])) ? test_input($_POST["employees"]) :$employees_old;
	$website = (isset($_POST["website"])) ? test_input($_POST["website"]) :$website_old;
	$facebook = (isset($_POST["facebook"])) ? test_input($_POST["facebook"]) :$facebook_old;
	$twitter = (isset($_POST["twitter"])) ? test_input($_POST["twitter"]) :$twitter_old;
	$linkedin = (isset($_POST["linkedin"])) ? test_input($_POST["linkedin"]) :$linkedin_old;
	$description =(isset($_POST["description"])) ? test_input($_POST['description']) : $description_old;

	//check if logo was changed
	if (($_FILES['logo']['size']>0)){
		include 'upload-logo.php';
		$logo = 'assets/img/logos/'.$filename;
	}else{
		$logo = $logo_old;
	}

	//Country details
	// $country_id = (isset($_POST["country_id"])) ? test_input($_POST['country_id']) : NULL;

	//founders details
	$no_founders = $_POST['no_founders'];
	for ($i=1; $i <= $no_founders; $i++) { 
		$f_name[$i] = test_input($_POST['f_name'.$i]);
		$f_email[$i] = test_input($_POST['f_email'.$i]);
		$f_phone[$i] = test_input($_POST['f_phone'.$i]);
	}


	$sql = "UPDATE  startups set logo = '$logo', name = '$name' , type_id = '$type_id' , type_id2 = '$type_id2' , f_year = '$f_year' , phone = '$phone' , email = '$email' , location = '$location' , status_id = '$status_id' , funding_stage = '$funding_stage' , employees = '$employees' , website = '$website' , facebook = '$facebook' , twitter = '$twitter' , linkedin = '$linkedin' , description = '$description' where s_id = '$s_id';";


	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success: </b> '.$name.' successfully updated!';

		try {
			//remove curernt founders
			$stmt_del = $pdo->prepare("delete from founders where s_id ='".$s_id."'");
			$stmt_del->execute();

			//insert new founders
			for ($i=1; $i <= $no_founders; $i++) { 
			$sql_f = "INSERT INTO `founders` (`s_id`, `f_name`, `f_email`, `f_phone`) VALUES ('".$s_id."', '$f_name[$i]', '$f_email[$i]', '$f_phone[$i]')"; //f=founders
				$stmt_f = $pdo->prepare($sql_f);

				$stmt_f->execute();
			}
		} catch (Exception $e) {
			$error='Error saving extra details:.'.$e;
		}
	}else {
		$error = '<b>Error when Editing Company : </b> '.$pdo->error();
	}

}

if (isset($message)&&isset($error)) {
	$_SESSION['message']= '<div class="alert alert-warning fade show">
			        <div class="container">
			          <div class="alert-icon">
			            <i class="material-icons">warning</i><br>
			          </div>
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			            <span aria-hidden="true"><i class="material-icons">clear</i></span>
			          </button>
			          <i class="material-icons">check</i>:'.$message.'<br>
					  <i class="material-icons">error_outline</i>:'.$error.'<br>
			        </div>
			      </div>';

}elseif(isset($message)) {
	$_SESSION['message']= '<div class="alert alert-success fade show">
			        <div class="container">
			          <div class="alert-icon">
			            <i class="material-icons">check</i>
			          </div>
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			            <span aria-hidden="true"><i class="material-icons">clear</i></span>
			          </button>
			          '.$message.' and NO-FOUNDERS: '.$no_founders.' and f_name: '.$f_name[1].'
			        </div>
			      </div>';
}
elseif(isset($error)) {
	$_SESSION['message']= '<div class="alert alert-danger fade show">
			        <div class="container">
			          <div class="alert-icon">
			            <i class="material-icons">error_outline</i>
			          </div>
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			            <span aria-hidden="true"><i class="material-icons">clear</i></span>
			          </button>
			          '.$error.'
			        </div>
			      </div>';
}else{
	$_SESSION['message']=null;
}
header('location:../admin/list_startups');
?>