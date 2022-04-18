<?php

session_start();
$status=true;
if(!isset($_SESSION['user'])){
	$status=false;
 header("location:../404?error=unknowPage");
 die();
 }
if( !$user_id=$_SESSION['user']['u_id']){ 
	$status=false;
	header("location:../404?error=unknowPage"); 
	}
 if(!$mobile_id=$_SESSION['user']['num']){
	 $status=false;
	 header("location:../404?error=unknowPage"); 
	 }


	if(!isset($_POST['finish'])){
	$status=false;
	header("location:../index");
	exit();
}

include "../codes/function.inc.php"; // include function file in code directory
// lets get the form inputs  
$cable_id=$_POST['cable_id'];
$table=$_POST['table'];

if(empty($cable_id) || empty($table)){
	$status=false;
	header("location:../alegbeleye/cabletvTranx?error=emptyFields");
	exit();
	}

 include "../condb.inc/connection.php";
  $sqlTwo="UPDATE {$table} SET Status='yes' WHERE cable_id='$cable_id' &&  Status='no' ";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)==1){
$status=false;
header("location:../alegbeleye/cabletvTranx?tv=success");
exit();

  }else{
  	$status=false;
	header("location:../alegbeleye/cabletvTranx?error=notUpdate");
	exit();

  }



?>

