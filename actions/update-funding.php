<?php
	session_start();
	require("db_connection.php");

//start with if to capture empty statements
if(!isset($_POST["s_id"]) || !isset($_POST["d_id"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$d_id = $_POST['d_id'];

	//first get old values incase we need to use them for unset values
	$stmt = $pdo->prepare("select d_id,s_id,inv_id,amount,round,d_date,source from deals where d_id ='$d_id';");
    $stmt->execute(array());
    foreach ($stmt as $row) {
      $s_id_old = $row['s_id']; 
      $inv_id_old = $row['inv_id']; 
      $amount_old = $row['amount']; 
      $round_old = $row['round']; 
      $d_date_old = $row['d_date']; 
      $source_old = $row['source']; 
    }



    //now check for uploaded values. if they are missing, use old values
	$s_id = (isset($_POST['s_id'])) ? test_input($_POST['s_id']) : $s_id_old;
	$inv_id = (isset($_POST['inv_id'])) ? test_input($_POST['inv_id']) : $inv_id_old;
	$amount = (isset($_POST['amount'])) ? test_input($_POST['amount']) : $amount_old;
	$round = (isset($_POST['round'])) ? test_input($_POST['round']) : $round_old;
	$d_date = (isset($_POST['d_date'])) ? test_input($_POST['d_date']) : $d_date_old;
	$source = (isset($_POST['source'])) ? test_input($_POST['source']) : $source_old;


	$amount = str_replace('US$', '', $amount);
	$amount = str_replace(',', '', $amount);
	//clean date
	$d_date = date("Y-m-d", strtotime($d_date));

	
	$sql = "UPDATE  deals set
				s_id = '$s_id',
				inv_id = '$inv_id',
				amount = '$amount',
				round = '$round',
				d_date = '$d_date',
				source = '$source'
			WHERE d_id = $d_id";


	$stmt = $pdo->prepare($sql);

	if ($stmt->execute() === TRUE) {
		$message = '<b>Success: </b> '.$name.' successfully updated!';
		$s_id = $pdo->lastInsertId();

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
			          '.$d_date.'
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
header('location:../admin/list_funding');
?>