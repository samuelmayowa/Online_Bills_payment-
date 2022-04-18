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


	if(!isset($_POST['sendsms'])){
	$status=false;
	header("location:../index");
	exit();
}

include "../codes/function.inc.php"; // include function file in code directory
// lets get the form inputs  
$senderId=$_POST['senderId'];
$receipient=$_POST['mobile'];
$gateWay=$_POST['gateWay'];  
$message=$_POST['message'];
$message=trim($message);
$senderId=cleanseInput($senderId);
$receipient=cleanseInput($receipient);

if(empty($senderId) || empty($receipient) || empty($gateWay) || empty($message)){
	$status=false;
	header("location:../alegbeleye/sendSms?error=emptyFields");
	exit();
	}

if(!is_numeric($receipient)){
		$status=false;
		header("location:../alegbeleye/sendSms?error=invalidNumber");
		exit();
		}

//lets get discount
$real_gateway="";
$gateway_code="";

switch($gateWay){
	case "30":
	$real_gateway="Non DND Route";
	$gateway_code=2;
	break;
	case "31":
	$real_gateway="DND Route";
	$gateway_code=3;
	break;
	default:
	$real_gateway="Unknown Route";
	break;
}


//lets get the number of numbers to receive the message
// we will use that to calculate the cost of the bulk sms
//get the price of product
$price=productPrice($gateWay);
	if($price==false){
		$status=false;
		header("location:../alegbeleye/sendSms?error=noPrice");
		exit();
	}


// Now that we have collected all the data for the sms, we wil use smssmsapi to send the message 
// and when succesfull we will give redirect to give successs messge to admin 
$processed=sendSmsSingle($message,$senderId,$receipient,$gateway_code);
$code= $processed->code;
$success= $processed->successful;
$comment= $processed->comment;

// print_r ($processed);
if( $code=="1000"){

	header("location:../alegbeleye/sendSms?sms=success");
		exit();

}else{
	$status=false;
		header("location:../alegbeleye/sendSms?error=dataFailed&reason=$comment");
		exit();
}



?>

