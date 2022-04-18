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




	if(!isset($_POST['bankdetails'])){
	$status=false;
	header("location:../alegbeleye/systemSettings");
	exit();
}

$bank=trim($_POST['bank']); 
$minFunding=trim($_POST['minFunding']);
$stampDuty=trim($_POST['stampDuty']);   
if(empty($bank) ||  empty($minFunding) ||  empty($stampDuty)){
	$status=false;
	header("location:../alegbeleye/updateAnnmnt?error=emptyFields");
	exit();
	}

 include "../condb.inc/connection.php";
  $sql="UPDATE bankdetails SET Bankdetails='$bank', StampDuty='$stampDuty', MinFunding='$minFunding'  WHERE bank_id='1'";
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