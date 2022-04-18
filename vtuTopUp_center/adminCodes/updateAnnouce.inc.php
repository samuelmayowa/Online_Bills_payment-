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




	if(!isset($_POST['notify'])){
	$status=false;
	header("location:../alegbeleye/systemSettings");
	exit();
}

$annouce=trim($_POST['annouce']);
if(empty($annouce)){
	$status=false;
	header("location:../alegbeleye/updateAnnmnt?error=emptyFields");
	exit();
	}

  include "../condb.inc/connection.php";
  $sql="UPDATE annoucement SET annoucement='$annouce' WHERE ann_id='1'";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){
			$status=false;
			header("location:../alegbeleye/updateAnnmnt?error=annoucefailed");
			exit();
			 
			 } 
			 else{
			 	$status=false;
				header("location:../alegbeleye/updateAnnmnt?annouce=success");
				exit();
			 }


			 mysqli_close($con);
?>