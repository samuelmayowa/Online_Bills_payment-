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




	if(!isset($_POST['removeAdmin'])){
	$status=false;
	 header("location:../404?error=unknowPage"); 
	exit();
}
 include "../codes/function.inc.php"; // include function file in code directory
  include("../adminCodes/adminFunctions.php");

$adminmobile=trim($_POST['adminmobile']);

   
if(empty($adminmobile)){
	$status=false;
	header("location:../alegbeleye/createadmin?error=emptyFields");
	exit();
	}
//check if the number is a registred number
$member=memberDetailsTwo($adminmobile);	
$in_admin=adminDetails($adminmobile);
if($in_admin==false){
	$status=false;
	header("location:../alegbeleye/createadmin?error=notAdmin");
	exit();
}

if($member==false){
	$status=false;
	header("location:../alegbeleye/createadmin?error=notFound");
	exit();
}
 //if all those above coditions do not return error, then delete the user as admin


include "../condb.inc/connection.php"; 

$sql="DELETE FROM  admin WHERE Mobile='$adminmobile'";
if(mysqli_query($con,$sql)){
	header("location:../alegbeleye/createadmin?annouce=removed");
	exit();
}
else{
	$status=false;
	header("location:../alegbeleye/createadmin?error=notRemoved");
	exit();
}





?>