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
	$name = (isset($_POST["name"])) ? test_input($_POST["name"]):NULL;
	$phone = (isset($_POST["phone"])) ? test_input($_POST["phone"]):NULL;
	$email = (isset($_POST["email"])) ? test_input($_POST["email"]):NULL;
	$location = (isset($_POST["location"])) ? test_input($_POST["location"]):NULL;
	$sector = (isset($_POST["sector"])) ? test_input($_POST["sector"]):NULL;
	$status = (isset($_POST["status"])) ? test_input($_POST["status"]):NULL;
	$website = (isset($_POST["website"])) ? test_input($_POST["website"]):NULL;
	$facebook = (isset($_POST["facebook"])) ? test_input($_POST["facebook"]):NULL;
	$twitter = (isset($_POST["twitter"])) ? test_input($_POST["twitter"]):NULL;
	$linkedin = (isset($_POST["linkedin"])) ? test_input($_POST["linkedin"]):NULL;
	$description = (isset($_POST["description"])) ? test_input($_POST["description"]):NULL;


	//Country details
	$country_id = $_POST['country_id'];

	if (($_FILES['logo']['size']>0)){
		include 'upload-logo.php';
		$logo = 'assets/img/logos/'.$filename;
	}else{
		$logo = '';
	}

	$sql = "INSERT INTO investors (logo, name, phone, email, location, sector, status, website, facebook, twitter, linkedin, description) VALUES ('$logo', '$name', '$phone', '$email', '$location', '$sector', '$status', '$website', '$facebook', '$twitter', '$linkedin', '$description')";

	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message .= '<b>Success:</b> '.$name.' successfully saved with id No.: '.$pdo->lastInsertId().'!';
		$inv_id = $pdo->lastInsertId();

		$sql_c = "INSERT INTO `c_of_focus` (`c_id`, `inv_id`) VALUES (?, '".$inv_id."')";//c=countries
		$stmt_c = $pdo->prepare($sql_c);

		try {
			foreach ($country_id as $c_id) {
				echo $c_id;
				$stmt_c->execute(array($c_id));
			}
		} catch (Exception $e) {
			$error='Error saving extra details:.'.$e;
		}
	}else {
		$error .= '<b>Error when adding a new member : </b>'.$pdo->error();
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
header('location:../add_investor');
?>