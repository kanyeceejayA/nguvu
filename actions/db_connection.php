<?php

include 'env.php';

// error_reporting(-1);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

$dbuser =  env('dbuser');
$dbpass = env('dbpass');
$dbname =  env('dbname');
$dbserver = 'localhost';

 $params = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

$pdo = new PDO('mysql:host=localhost;dbname='.$dbname.';charset=utf8', $dbuser, $dbpass, $params);
$sqlFunctionCallMethod = 'CALL ';

   
// Create connection for mySQli
$connect = new mysqli($dbserver,$dbuser,$dbpass,$dbname);
// Check connection
if (!$connect) {
    die("Connection failed: " . $connect->connect_error);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data,ENT_QUOTES);
  return $data;
}

function logo_check($logo='')
{
  if(strpos($logo, 'assets') === false || substr($logo, -1) =='.'){
        return 'assets/img/nguvu_default.png';
      }
  elseif (!file_exists($logo) && !file_exists('../'.$logo) ) {
         return 'assets/img/nguvu_default.png';
   } 
    else{
      return $logo;
    }
}

function format_money($amount='0')
{
  if ($amount=='0'){
    $amount = 'Undisclosed';
  }else{
    $fmt2 = new NumberFormatter( 'UG', NumberFormatter::DECIMAL );
    $fmt2->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
    $amount = $fmt2->formatCurrency(($amount),"USD");
    $amount = 'US $'.$amount;
  }
  return $amount;

}

?>
