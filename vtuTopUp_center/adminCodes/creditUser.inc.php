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




	if(!isset($_POST['creditUser'])){
	$status=false;
	 header("location:../404?error=unknowPage"); 
	exit();
}
 include "../codes/function.inc.php"; // include function file in code directory
  include("../adminCodes/adminFunctions.php");
$credit=trim($_POST['credit']); 
$trnxinfo=trim($_POST['traninfo']);
$mobile=trim($_POST['mobile']);
$id=trim($_POST['id']); 
   
if(empty($credit) ||  empty($trnxinfo) ||  empty($mobile) ||  empty($id)){
	$status=false;
	header("location:../alegbeleye/credituser?error=emptyFields&user=$mobile");
	exit();
	}

$adminDetails=adminDetails($mobile_id);
$adminName=$adminDetails['Name'];
$userDetails=memberDetailsTwo($mobile);
$userFname=$userDetails['FirstName'];
$userLname=$userDetails['LastName'];
$fulName=$userFname." ".$userLname;
$UserEmail=$userDetails['Email'];
$UserId=$userDetails['User_id'];
$UserMobile=$userDetails['Mobile'];
$firsTimer=firstTime($id, $mobile);
$old_balance=getWallet($id,$mobile);
$new_balnce=$old_balance+$credit;

if($firsTimer==true){//if its first timer, the we will first insert into wallet and the into wallet funds records
if($credit<1200){
 	$status=false;
    header("location:../alegbeleye/credituser?error=lowFirstPay&user=$mobile");
	exit();
 	}
// checkiing if the user was referrred, we do this  when its users first time payment
 		
		$is_reffered=is_refered($UserId, $UserMobile);
		if ($is_reffered==false){
			$was_referred="no";
			

		}
		else if ($is_reffered!==false) {
			 $was_referred="yes";
		}

$done=creditFirstTimeUser($id,$mobile,$credit,$trnxinfo,$was_referred,$UserEmail,$fulName,$is_reffered);

$Newcredit=$credit-1200;

if($done==true){
//we will send email to notify both user and admin
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
$mail->Subject = 'VtuTopCenter Wallet Credited';
// format the message
$message="<p><img src=\"cid:testImage\" height='200px' width='90%' style='margin-left:5%;' /></p>";
$message.="<h1 style='font-size:16px; color:#660000;'> Hi  $userFname !</h1>";
$message.="<p>This is to inform you that your wallet has been manually credited by the admin at VTU-TOP-CENTER. </p>";
$message.="<p>Amount credited ₦: $credit, and your new balance is  ₦: $Newcredit</p>";
$message.="<p><b>Purpose of credit : </b><br/>$trnxinfo </p>";


$message.="<ul><li> You can buy cheap data of any network from us. </li>
                <li> You can get airtime at discount and on time from us.</li>
				<li> You can pay your power bill through us without you stressing your self . </li>
				<li> You can also send bulk sms to one or more numbers through our site. </li>
				<li>So many more services we offer; please feel free to login into your dashboard to find out more. </li>

</ul>";
$message.="<br/><br/>";
$message.="<p  style='background-color:#F0FFFF; color:#A52A2A;'>Regards from Team VtuTopCenter.<p/>";
$message.="<p>Visit our website:<a href='https://vtutopcenter.com'>vtutopcenter.com</a></p>";
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
$mailUser->Subject = 'A User Manually Credited';
// format the message
$message="<h1>This is to inform the admin that a user has been manually credted.</h1>";
$message.="<p>See few details of the new user..</p>";
$message.="<p><b>Email:</b> $UserEmail </p>";
$message.="<p><b>User Phone Number:</b> $mobile </p>";
$message.="<p><b>Amount ₦:</b>  $credit </p>";
$message.="<p><b>Purpose of credit:</b> $trnxinfo </p>";
$message.="<p><b>Admin responsible:</b> $adminName </p>";
$mailUser->Body =$message;
$ok_mailUser=$mailUser->send();	

	header("location:../alegbeleye/credituser?annouce=success&user=$mobile");
	exit();

}



	

}else{



//lest use funtion to perfom the creditng of user.
// this funtion will update the wallet, insert record in wallet funds record and also in transaction

 

 $processed=creditUser($id,$mobile,$credit,$old_balance,$trnxinfo);
if($processed==true){
// we will send email to user and admin for this crediting ofwallet
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
$mail->Subject = 'VtuTopCenter Wallet Credited';
// format the message
$message="<p><img src=\"cid:testImage\" height='200px' width='90%' style='margin-left:5%;' /></p>";
$message.="<h1 style='font-size:16px; color:#660000;'> Hi  $userFname !</h1>";
$message.="<p>This is to inform you that your wallet has been manually credited by the admin at VTU-TOP-CENTER. </p>";
$message.="<p>Amount credited ₦: $credit, and your new balance is  ₦: $new_balnce</p>";
$message.="<p><b>Purpose of credit : </b><br/>$trnxinfo </p>";


$message.="<ul><li> You can buy cheap data of any network from us. </li>
                <li> You can get airtime at discount and on time from us.</li>
				<li> You can pay your power bill through us without you stressing your self . </li>
				<li> You can also send bulk sms to one or more numbers through our site. </li>
				<li>So many more services we offer; please feel free to login into your dashboard to find out more. </li>

</ul>";
$message.="<br/><br/>";
$message.="<p  style='background-color:#F0FFFF; color:#A52A2A;'>Regards from Team VtuTopCenter.<p/>";
$message.="<p>Visit our website:<a href='https://vtutopcenter.com'>vtutopcenter.com</a></p>";
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
$mailUser->Subject = 'A User Manually Credited';
// format the message
$message="<h1>This is to inform the admin that a user has been manually credted.</h1>";
$message.="<p>See few details of the new user..</p>";
$message.="<p><b>Email:</b> $UserEmail </p>";
$message.="<p><b>User Phone Number:</b> $mobile </p>";
$message.="<p><b>Amount ₦:</b>  $credit </p>";
$message.="<p><b>Purpose of credit:</b> $trnxinfo </p>";
$message.="<p><b>Admin responsible:</b> $adminName </p>";
$mailUser->Body =$message;
$ok_mailUser=$mailUser->send();	





	header("location:../alegbeleye/credituser?annouce=success&user=$mobile");
	exit();

}else{
	$status=false;
	header("location:../alegbeleye/credituser?error=annoucefailed&user=$mobile");
	exit();

}

}


?>