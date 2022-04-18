<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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




	if(!isset($_POST['suspendUser'])){
	$status=false;
	 header("location:../404?error=unknowPage"); 
	exit();
}
 include "../codes/function.inc.php"; // include function file in code directory
  include("../adminCodes/adminFunctions.php"); 
$trnxinfo=trim($_POST['traninfo']);
$mobile=trim($_POST['mobile']);
$id=trim($_POST['id']); 
   
if(empty($trnxinfo) ||  empty($mobile) ||  empty($id)){
	$status=false;
	header("location:../alegbeleye/suspenduser?error=emptyFields&user=$mobile");
	exit();
}
// check if the user they want to remove is not the main admin, if yes, pls stop the programm.

$mainAdmin="09065522031";
if($mobile==$mainAdmin){
	$status=false;
	header("location:../alegbeleye/suspenduser?error=isMainAdmin&user=$mobile");
	exit();
}



// get admin details and user details
$adminDetails=adminDetails($mobile_id);
$adminName=$adminDetails['Name'];
$userDetails=memberDetailsTwo($mobile);
$userFname=$userDetails['FirstName'];
$UserEmail=$userDetails['Email'];
//lets delete the user record from member
//even from wallet and wallet fund records
$processed=suspendUser($mobile,$UserEmail);

if($processed==true){
// we will send email to user and admin for this removal
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$mail = new PHPMailer;
 $mail->isHTML(true);
  $mail->setFrom('admin@vtutopcenter.com', 'VTU-TOP-CENTER NIGERIA');
 $mail->addReplyTo('admin@vtutopcenter.com', 'Admin');
 // Add a recipient
$mail->addAddress($UserEmail);
$mail->AddEmbeddedImage('../web-images/regmail_banner.png','testImage','regmail_banner.png');
$mail->Subject = 'VtuTopCenter Suspended You';
// format the message
$message="<p><img src=\"cid:testImage\" height='200px' width='90%' style='margin-left:5%;' /></p>";
$message.="<h1 style='font-size:16px; color:#660000;'> Hi  $userFname !</h1>";
$message.="<p>Sorry, to infrom you that you have been suspended from VtuTopCenter services. </p>";
$message.="<p><b>Purpose of suspension : </b><br/>$trnxinfo </p>";
$message.="<br/>";
$message.="<p  style='background-color:#F0FFFF; color:#A52A2A;'>Regards from Team VtuTopCenter.<p/>";
$message.="<p>Visit our website:<a href='https://aocsavers.com'>vtutopcenter.com</a></p>";
$mail->Body = "<div style='font-size:14px;padding-left:4%;'>$message</div>";
$ok=$mail->send();	
// we have to	also send mail to Admin too
$mailUser = new PHPMailer;
$mailUser->isHTML(true);
$mailUser->setFrom('admin@vtutopcenter.com', 'VTU-TOP-CENTER NIGERIA');
$mailUser->addReplyTo('admin@vtutopcenter.com', 'Admin');
 // Add a recipient
$mailUser->addAddress('vtutopcenter@gmail.com');
$mailUser->AddCC("sundayhalegbs@gmail.com");
$mailUser->AddCC("admin@vtutopcenter.com");
//Email subject
$mailUser->Subject = 'A User Suspended ';
// format the message
$message="<h1>This is to inform the admin that a user has been suspended from the system.</h1>";
$message.="<p>See few details of the user..</p>";
$message.="<p><b>Email:</b> $UserEmail </p>";
$message.="<p><b>User Phone Number:</b> $mobile </p>";
$message.="<p><b>Purpose of removal:</b> $trnxinfo </p>";
$message.="<p><b>Admin responsible:</b> $adminName </p>";
$mailUser->Body =$message;
$ok_mailUser=$mailUser->send();	


header("location:../alegbeleye/seeUser?suspend=success&user=$mobile");
	exit();

}else{
	$status=false;
	header("location:../alegbeleye/suspenduser?error=annoucefailed&user=$mobile");
	exit();

}



?>