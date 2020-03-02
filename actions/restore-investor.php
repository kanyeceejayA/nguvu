<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}   
	require("../admin/session.php");

//start with if to capture empty statements
if(!isset($_GET["p"])){
	$error = '<b>Error:</b> No Investor Selected for Restoring!';
}
else{
	$inv_id = (isset($_GET["p"])) ? test_input($_GET["p"]) :NULL;

    $sql= "INSERT into investors(inv_id,logo,name,phone,email,location,type_id,sector,status,website,facebook,twitter,linkedin,description) SELECT inv_id,logo,name,phone,email,location,type_id,sector,status,website,facebook,twitter,linkedin,description FROM `deleted_investors` where inv_id = $inv_id";

	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {

		$sql2 = "DELETE from  deleted_investors where inv_id = $inv_id";
		$stmt2 = $pdo->prepare($sql2);

		if ($stmt2->execute() === TRUE) {
			$message = '<b>Success: </b> successfully restored Investor with id No.: '.$inv_id.'!';
		}else {
			$error = '<b>Error when restoring company : </b> '.$pdo->error();
		}


	}else {
		$error = '<b>Error when restoring company : </b> '.$pdo->error();
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
header('location:../admin/deleted_investors');
?>