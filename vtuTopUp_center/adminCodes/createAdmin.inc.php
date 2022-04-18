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




	if(!isset($_POST['becomeAdmin'])){
	$status=false;
	 header("location:../404?error=unknowPage"); 
	exit();
}
 include "../codes/function.inc.php"; // include function file in code directory
  include("../adminCodes/adminFunctions.php");
$adminemail=trim($_POST['adminEmail']); 
$adminmobile=trim($_POST['adminmobile']);

   
if(empty($adminemail) ||  empty($adminmobile)){
	$status=false;
	header("location:../alegbeleye/createadmin?error=emptyFields");
	exit();
	}
//check if the number is a registred number
$member=memberDetailsTwo($adminmobile);	
$in_admin=adminDetails($adminmobile);
if($in_admin!==false){
	$status=false;
	header("location:../alegbeleye/createadmin?error=alreadyAdmin");
	exit();
}

if($member==false){
	$status=false;
	header("location:../alegbeleye/createadmin?error=notFound");
	exit();
}
 $fname=$member['FirstName'];
$lname=$member['LastName'];
$fulname= $fname. " ".$lname;
$pass="microbiology";
//so, at thispoint we can make the user an admin

 $processed=makeAdmin($adminmobile,$adminemail,$fulname,$pass);

 if($processed==true){
	header("location:../alegbeleye/createadmin?annouce=success");
	exit();

}else{
	$status=false;
	header("location:../alegbeleye/createadmin?error=annoucefailed");
	exit();

}




?>