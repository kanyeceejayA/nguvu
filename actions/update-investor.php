 <?php
	session_start();
	require("db_connection.php");
	$message = null;
	$error = null;
//start with if to capture empty statements
if(!isset($_POST["name"]) && !isset($_POST["type"]) ){
	$message = 'Please enter all details';
}
else{

	$inv_id = $_POST['inv_id'];
	//first get old values incase we need to use them for unset values
      $stmt = $pdo->prepare("select logo, name, phone, email, location, sector, status, website, facebook, twitter, linkedin, description from investors where inv_id = '$inv_id';");
      $stmt->execute();
      foreach ($stmt as $row) {
        $logo_old = logo_check($row['logo']);
	    $name_old = $row['name'];
	    $phone_old = $row['phone'];
	    $email_old = $row['email'];
	    $location_old = $row['location'];
	    $sector_old = $row['sector'];
	    $status_old = $row['status'];
	    $website_old = $row['website'];
	    $facebook_old = $row['facebook'];
	    $twitter_old = $row['twitter'];
	    $linkedin_old = $row['linkedin'];
	    $description_old = $row['description'];
      }





	$name = (isset($_POST["name"])) ? test_input($_POST["name"]):$name_old;
	$phone = (isset($_POST["phone"])) ? test_input($_POST["phone"]):$phone_old;
	$email = (isset($_POST["email"])) ? test_input($_POST["email"]):$email_old;
	$location = (isset($_POST["location"])) ? test_input($_POST["location"]):$location_old;
	$sector = (isset($_POST["sector"])) ? test_input($_POST["sector"]):$sector_old;
	$status = (isset($_POST["status"])) ? test_input($_POST["status"]):$status_old;
	$website = (isset($_POST["website"])) ? test_input($_POST["website"]):$website_old;
	$facebook = (isset($_POST["facebook"])) ? test_input($_POST["facebook"]):$facebook_old;
	$twitter = (isset($_POST["twitter"])) ? test_input($_POST["twitter"]):$twitter_old;
	$linkedin = (isset($_POST["linkedin"])) ? test_input($_POST["linkedin"]):$linkedin_old;
	$description = (isset($_POST["description"])) ? test_input($_POST["description"]):$description_old;


	//Country details
	// $country_id = $_POST['country_id'];

	//check if logo was changed
	if (($_FILES['logo']['size']>0)){
		include 'upload-logo.php';
		$logo = 'assets/img/logos/'.$filename;
	}else{
		$logo = $logo_old;
	}

	$sql = "UPDATE investors SET
				logo = '$logo',
				name = '$name',
				phone = '$phone',
				email = '$email',
				location = '$location',
				sector = '$sector',
				status = '$status',
				website = '$website',
				facebook = '$facebook',
				twitter = '$twitter',
				linkedin = '$linkedin',
				description = '$description'
			WHERE inv_id = '$inv_id';";

	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success:</b> '.$name.' successfully Updated !';
	}else {
		$error = '<b>Error when adding a new member : </b>'.$pdo->error();
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

}elseif (isset($message)) {
	$_SESSION['message']= '<div class="alert alert-success fade show">
			        <div class="container">
			          <div class="alert-icon">
			            <i class="material-icons">check</i>
			          </div>
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			            <span aria-hidden="true"><i class="material-icons">clear</i></span>
			          </button>
			          '.$message.'
			        </div>
			      </div>';
}elseif (isset($error)) {
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
}
header('location:../admin/list_investors');
?>