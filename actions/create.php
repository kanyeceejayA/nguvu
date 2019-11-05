 <?php
	session_start();
	require("db_connection.php");

//start with if to capture empty statements
if(!isset($_POST["name"]) && !isset($_POST["type"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$name = (isset($_POST["name"])) ?  test_input($_POST["name"]) :NULL;
	$type_id = (isset($_POST["type_id"])) ? test_input($_POST["type_id"]) :NULL;
	$type_id2 = (isset($_POST["type_id2"])) ? test_input($_POST["type_id2"]) :NULL;
	$f_year = (isset($_POST["f_year"])) ? test_input($_POST["f_year"]) :NULL;
	$phone = (isset($_POST["phone"])) ? test_input($_POST["phone"]) :NULL;
	$email = (isset($_POST["email"])) ? test_input($_POST["email"]) :NULL;
	$location = (isset($_POST["location"])) ? test_input($_POST["location"]) :NULL;
	$status_id = (isset($_POST["status_id"])) ? test_input($_POST["status_id"]) :NULL;
	$funding_stage = (isset($_POST["funding_stage"])) ? test_input($_POST["funding_stage"]) :NULL;
	$employees = (isset($_POST["employees"])) ? test_input($_POST["employees"]) :NULL;
	$website = (isset($_POST["website"])) ? test_input($_POST["website"]) :NULL;
	$facebook = (isset($_POST["facebook"])) ? test_input($_POST["facebook"]) :NULL;
	$twitter = (isset($_POST["twitter"])) ? test_input($_POST["twitter"]) :NULL;
	$linkedin = (isset($_POST["linkedin"])) ? test_input($_POST["linkedin"]) :NULL;
	$description =(isset($_POST["description"])) ? test_input($_POST['description']) : NULL ;

	
	if (($_FILES['logo']['size']>0)){
		include 'upload-logo.php';
		$logo = 'assets/img/logos/'.$filename;
	}else{
		$logo = '';
	}

	//Country details
	$country_id = $_POST['country_id'];

	//founders details
	$no_founders = $_POST['no_founders'];
	for ($i=1; $i <= $no_founders; $i++) { 
		$f_name[$i] = $_POST['f_name'.$i];
		$f_email[$i] = $_POST['f_email'.$i];
		$f_phone[$i] = $_POST['f_phone'.$i];
	}


	$sql = "INSERT INTO startups (logo, name, type_id, type_id2,f_year, phone, email, location, status_id, employees, website, facebook, twitter, linkedin, description) VALUES ('$logo', '$name', '$type_id', '$type_id2', '$f_year', '$phone', '$email', '$location', '$status_id', '$employees', '$website', '$facebook', '$twitter', '$linkedin', '$description')";


	


	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success: </b> '.$name.' successfully saved with id No.: '.$pdo->lastInsertId().'!';
		$s_id = $pdo->lastInsertId();

		$sql_c = "INSERT INTO `c_of_operation` (`c_id`, `s_id`) VALUES (?, '".$s_id."')";//c=countries
		$stmt_c = $pdo->prepare($sql_c);

		try {
			foreach ($country_id as $c_id) {
				echo $c_id;
				$stmt_c->execute(array($c_id));
			}


			for ($i=1; $i <= $no_founders; $i++) { 
			$sql_f = "INSERT INTO `founders` (`s_id`, `f_name`, `f_email`, `f_phone`) VALUES ('".$s_id."', '$f_name[$i]', '$f_email[$i]', '$f_phone[$i]')"; //f=founders
				$stmt_f = $pdo->prepare($sql_f);

				$stmt_f->execute();
			}
		} catch (Exception $e) {
			$error='Error saving extra details:.'.$e;
		}
	}else {
		$error = '<b>Error when adding a new Company : </b> '.$pdo->error();
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
			          '.$message.'
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
header('location:../add_startup');
?>