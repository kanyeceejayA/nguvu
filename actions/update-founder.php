<?php
	session_start();
	require("db_connection.php");

//start with if to capture empty statements
if(!isset($_POST["f_name"]) || !isset($_POST["s_id"]) ){
	$error = '<b>Error:</b> Please enter all details!';
}
else{
	$f_id = $_POST['f_id'];

	//first get old values incase we need to use them for unset values
	$stmt = $pdo->prepare("select * from founders where f_id =?;");
    $stmt->execute(array($s_id));
    foreach ($stmt as $row) {
      $f_name_old = $row['f_name'];
      $f_email_old = $row['f_email'];
      $f_phone_old = $row['f_phone'];
    }



    //now check for uploaded values. if they are missing, use old values
	$f_name =(isset($_POST['f_name']))? test_input($_POST['f_name']) : $f_name_old;
	$f_email =(isset($_POST['f_email']))? test_input($_POST['f_email']) : $f_email_old;
	$f_phone =(isset($_POST['f_phone']))? test_input($_POST['f_phone']) : $f_phone_old;

	$sql = "UPDATE  founders set  where f_id = '$f_id';";


	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success: </b> '.$f_name.' successfully updated!';
		$s_id = $pdo->lastInsertId();
	}else {
		$error = '<b>Error when Editing Startup : </b> '.$pdo->error();
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
header('location:../admin/list_startups');
?>