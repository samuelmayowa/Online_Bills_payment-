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




	if(!isset($_POST['pin'])){
	$status=false;
	header("location:../alegbeleye/systemSettings?hey");
	exit();
}

$mtnpin=trim($_POST['mtnpin']);
if(empty($mtnpin)){
	$status=false;
	header("location:../alegbeleye/updateAnnmnt?error=emptyFields");
	exit();
	}

  include "../condb.inc/connection.php";
  $sql="UPDATE vtupins SET pin='$mtnpin' WHERE networkCodes='1'";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){
			$status=false;
			header("location:../alegbeleye/updateAnnmnt?error=pinfailed");
			exit();
			 
			 } 
			 else{
			 	$status=false;
				header("location:../alegbeleye/updateAnnmnt?annouce=success");
				exit();
			 }


			 mysqli_close($con);
?>