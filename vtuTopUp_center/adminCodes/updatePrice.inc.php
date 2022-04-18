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




	if(!isset($_POST['updateprice'])){
	$status=false;
	header("location:../alegbeleye/updatePrice");
	exit();
}

$price=trim($_POST['price']); 
$sub_id=trim($_POST['sub_id']);
   
if(empty($price) ||  empty($sub_id)){
	$status=false;
	header("location:../alegbeleye/updatePrice?error=emptyFields");
	exit();
	}

 include "../condb.inc/connection.php";
  $sql="UPDATE subproducts SET price ='$price'  WHERE sub_id='$sub_id'";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){
			$status=false;
			header("location:../alegbeleye/updatePrice?error=annoucefailed");
			exit();
			 
			 } 
			 else{
			 	$status=false;
				header("location:../alegbeleye/updatePrice?annouce=success");
				exit();
			 }


			 mysqli_close($con);

?>