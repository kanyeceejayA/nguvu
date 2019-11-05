 <?php
	session_start();
	require("db_connection.php");
//start with if to capture empty statements
if(!isset($_POST["s_id"]) && !isset($_POST["inv_id"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$s_id = $_POST["s_id"];
	$inv_id = $_POST["inv_id"];
	$amount = $_POST["amount"];
	$amount = str_replace('US$', '', $amount);
	$amount = str_replace(',', '', $amount);
	$round = $_POST["round"];
	$d_date = date("Y-m-d", strtotime($_POST["d_date"]));
	$source = $_POST["source"];
	

	$sql = "INSERT INTO deals (s_id,inv_id,amount,round,d_date,source) VALUES ('$s_id','$inv_id','$amount','$round','$d_date','$source')";



	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success: </b> Investment deal successfully saved with id No.: '.$pdo->lastInsertId().'!';
		$s_id = $pdo->lastInsertId();

	}else {
		$error = '<b>Error when adding new deal : </b> '.$pdo->error();
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
header('location:../add_funding');
?>