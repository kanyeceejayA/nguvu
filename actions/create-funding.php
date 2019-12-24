<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	require("db_connection.php");
//start with if to capture empty statements
if(!isset($_POST["s_id"]) && !isset($_POST["source"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$s_id = $_POST["s_id"];
	// $inv_id = $_POST["inv_id"];
	$amount = $_POST["amount"];
	$amount = str_replace('US$', '', $amount);
	$amount = str_replace(',', '', $amount);
	$round = $_POST["round"];
	$d_date = date("Y-m-d", strtotime($_POST["d_date"]));
	$source = $_POST["source"];
	

	//investors details
	$no_investors = $_POST['no_investors'];
	for ($i=1; $i <= $no_investors; $i++) { 
		$inv_id[$i] = $_POST['inv_id'.$i];
	}
		

	$sql = "INSERT INTO deals (s_id,inv_id,amount,round,d_date,source) VALUES ('$s_id','$inv_id[1]','$amount','$round','$d_date','$source')";
	$stmt = $pdo->prepare($sql);
	
	if ($stmt->execute() === TRUE) {
		//save auto insert value as deal ID
		$deal_id = $pdo->lastInsertId();
		//loop through other investors and insert them
		for ($i=2; $i <= $no_investors; $i++) {
			//new insert statement for co investors with deal ID already present
			$sql2 = "INSERT INTO deals (deal_id, s_id,inv_id,amount,round,d_date,source) VALUES ('$deal_id','$s_id','$inv_id[$i]','$amount','$round','$d_date','$source')";
			$stmt2 = $pdo->prepare($sql2);
			if($stmt2->execute()==FALSE){
				$error = '<b>Error when adding new deal : </b> '.$pdo->error();
			}
		}
		//update original record to add deal ID to it
		$sql3="update deals set deal_id='$deal_id' where d_id=$deal_id";
		$stmt = $pdo->prepare($sql3);
		$stmt->execute();

		$message = '<b>Success: </b> Investment deal ='.$deal_id.' successfully saved!';
		
	}else {
		$error = '<b>Error when adding new Funding : </b> '.$pdo->error();
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