<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require("../admin/session.php");

//start with if to capture empty statements
if(!isset($_POST["s_id"]) || !isset($_POST["deal_id"]) ){
	$error = '<b>Error:</b>Please enter all details!';
}
else{
	$deal_id = $_POST['deal_id'];

	//first get old values incase we need to use them for unset values
	$stmt = $pdo->prepare("select d_id,s_id,inv_id,amount,round,d_date,source from deals where d_id ='$deal_id';");
    $stmt->execute(array());
    foreach ($stmt as $row) {
      $s_id_old = $row['s_id']; 
      $amount_old = $row['amount']; 
      $round_old = $row['round']; 
      $d_date_old = $row['d_date']; 
      $source_old = $row['source']; 
    }



    //now check for uploaded values. if they are missing, use old values
	$s_id = (isset($_POST['s_id'])) ? test_input($_POST['s_id']) : $s_id_old;
	// $inv_id = (isset($_POST['inv_id'])) ? test_input($_POST['inv_id']) : $inv_id_old;
	$amount = (isset($_POST['amount'])) ? test_input($_POST['amount']) : $amount_old;
	$round = (isset($_POST['round'])) ? test_input($_POST['round']) : $round_old;
	$d_date = (isset($_POST['d_date'])) ? test_input($_POST['d_date']) : $d_date_old;
	$source = (isset($_POST['source'])) ? test_input($_POST['source']) : $source_old;

	//new investors details
	$no_investors = test_input($_POST['no_investors']);
	echo "no of investors=".$no_investors;
	for ($i=1; $i <= $no_investors; $i++) { 
		$inv_id[$i] = $_POST['inv_id'.$i];
		// echo "<br>\n inv id $i = $inv_id[$i]";
	}
	// echo "<br><br><br>";
	//fetch old investors details
	$stmt = $pdo->prepare("select d_id,inv_id from deals where deal_id = $deal_id order by d_id;");
	$stmt->execute();
	$no_old=0;
    foreach ($stmt as $row) {
		$no_old++;
		$inv_id_old[$no_old]= $row['inv_id'];
		$d_id_old[$no_old]=$row['d_id'];		
		// echo "<br>\n old inv id $no_old = $inv_id_old[$no_old] and old d id $no_old = $d_id_old[$no_old]";
		}
	// echo "<br><br>after loop, final no_old:$no_old</br>";

	//amount
	$amount = str_replace('US$', '', $amount);
	$amount = str_replace(',', '', $amount);

	//clean date
	$d_date = date("Y-m-d", strtotime($d_date));

	//update first records
	$sql = "UPDATE  deals set
				s_id = '$s_id',
				amount = '$amount',
				round = '$round',
				d_date = '$d_date',
				source = '$source'
			WHERE deal_id = $deal_id";

	$stmt1 = $pdo->prepare($sql);

	//check if new investors less or more than old ones
	if($no_old == $no_investors){
		for ($i=1; $i <= $no_investors; $i++) {		//enter new investors to replace old ones
	
			$sql = "UPDATE  deals set
					inv_id = '$inv_id[$i]'
				WHERE deal_id = $deal_id and d_id=$d_id_old[$i]";
			
			$stmt2 = $pdo->prepare($sql);
			$stmt2->execute();	
		}
	}elseif($no_old < $no_investors){

		for ($i=1; $i <= $no_old; $i++) {		//enter new investors to replace old ones
			$sql = "UPDATE  deals set
					inv_id = '$inv_id[$i]'
				WHERE deal_id = $deal_id and d_id=$d_id_old[$i]";
			$stmt2 = $pdo->prepare($sql);
			$stmt2->execute();
		}

		for ($i=$no_old+1; $i <= $no_investors; $i++) {		//enter excess new investors	
			$sql = "INSERT INTO deals (deal_id, s_id,inv_id,amount,round,d_date,source)
					VALUES ('$deal_id','$s_id','$inv_id[$i]','$amount','$round','$d_date','$source')";
			$stmt3 = $pdo->prepare($sql);
			$stmt3->execute();
		}

	}elseif($no_old > $no_investors){

		for ($i=1; $i <= $no_investors; $i++) {		//enter new investors to replace old ones
			$sql = "UPDATE  deals set
					inv_id = '$inv_id[$i]'
				WHERE deal_id = $deal_id and d_id=$d_id_old[$i]";
			$stmt2 = $pdo->prepare($sql);
			if($stmt2->execute() === TRUE){
				// echo "<br><P style='color:green'>Successfully added new records</p> ";
			}
		}

		for ($i=$no_investors+1; $i <= $no_old; $i++) {		//delete excess old ones	
			$sql = "DELETE from deals
					WHERE deal_id = $deal_id and d_id=$d_id_old[$i]";
			$stmt3 = $pdo->prepare($sql);
			if($stmt3->execute() === TRUE){
				// echo "<br><P style='color:green'>Successfully deleted old records</p> ";
			}
		}

	}

	//delete old investors incase new investors are less than old investors
	for ($i=$no_investors+1; $i <= $no_old; $i++) {

		$sql = "DELETE from deals
			WHERE deal_id = $deal_id and d_id=$d_id_old[$i]";
	}
	$stmt3 = $pdo->prepare($sql);




	if ($stmt1->execute() === TRUE) {
		$message = "<b>Success: </b> deal successfully updated!";
	}else{
		$error = '<b>but an error occured: </b> '.$pdo->error();
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
header('location:../admin/list_funding');
// header("location:../admin/edit_funding?p=$deal_id");
?>