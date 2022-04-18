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
$electric_id=$_POST['electric_id'];
$table=$_POST['table'];

if(empty($electric_id) || empty($table)){
	$status=false;
	header("location:../alegbeleye/electricityTranx?error=emptyFields");
	exit();
	}

 include "../condb.inc/connection.php";
  $sqlTwo="UPDATE {$table} SET Status='yes' WHERE electric_id='$electric_id' &&  Status='no' ";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)==1){
$status=false;
header("location:../alegbeleye/electricityTranx?power=success");
exit();

  }else{
  	$status=false;
	header("location:../alegbeleye/electricityTranx?error=notUpdate");
	exit();

  }



?>

