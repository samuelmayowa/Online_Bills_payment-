<?php
// Registration codes here.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$status=true;
if(!isset($_POST['register'])){
	$staus=false;
	header("location:../index");
	exit();
}
// Get the inputs.
$firstName=$_POST['fname'];  
$lastName=$_POST['lname'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$ref_link=$_POST['referal'];
$password=$_POST['password'];   
$birth_month=$_POST['month'];
$birth_day=$_POST['day'];


// Perform some checks, return back to registration page if error found.

if(empty($firstName) || empty($lastName) || empty($email) || empty($mobile) || empty($password)){
	$status=false;
	header("location:../register?error=emptyFields&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	exit();
	}
	else if(empty($birth_month) || empty($birth_day)){
		$status=false;
		header("location:../register?error=emptyBirthdate&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
		exit();


	}
	else if(strlen(trim($password))<7 ){
	$status=false;
	header("location:../register?error=shortpassword&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	exit();
}
else if(!is_numeric($mobile)){
	$status=false;
	header("location:../register?error=invalidmobile&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	exit();
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
   $status=false;
	header("location:../register?error=invalidemail&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	exit();
} 

// check maybe number is up to 11 digit

$mobile_digit=strlen($mobile);
if ($mobile_digit<11){
 $status=false;
	header("location:../register?error=shortMobile&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	exit();

}

 include "../codes/function.inc.php";
if(!empty($ref_link)){
 $ref_details=memberDetailsTwo($ref_link);
	 if ($ref_details==false){
		$status=false;
		header("location:../register?error=wrongRef&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
		      exit();
		}
 $ref_fname=$ref_details['FirstName'];
 $ref_lname=$ref_details['LastName'];
 $refName=$ref_fname. " ".$ref_lname;	
 $ref_id=$ref_details['User_id'];	
 
	 if(firstTime($ref_id, $ref_link)==true){
	 	
	 	$status=false;
header("location:../register?error=ftReferral&refName=$refName&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	      exit();
	 }

}

// Continue with form processing if above statements do not return error.
if($status==true){
	include "../condb.inc/connection.php";
	//Sanitazing inputs
	$firstName=filter_var($firstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$lastName=filter_var($lastName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);
	$mobile= filter_var($mobile, FILTER_SANITIZE_NUMBER_INT);
	$ref_link=filter_var($ref_link, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$firstName=mysqli_real_escape_string($con, $firstName);
	$lastName=mysqli_real_escape_string($con, $lastName);
	$mobile=mysqli_real_escape_string($con,$mobile);
	$ref_link=mysqli_real_escape_string($con,$ref_link);
	$fullname=$firstName." ".$lastName;
	//lets check if the email or phone number has not been used to register here before now.
	$stmt= mysqli_stmt_init($con);
	$sql="SELECT * FROM members WHERE Email=? OR Mobile=?";
	if(!mysqli_stmt_prepare($stmt,$sql)){
		$status=false;
		header("location:../register?error=sqlerror&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	   }
		else{
			
	mysqli_stmt_bind_param($stmt,'ss',$email,$mobile);
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result)>0){
		
		$status=false;
	    header("location:../register?error=onceregistered&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	    exit();
		mysqli_stmt_close($stmt);
		mysqli_close($con);
		
		}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($con);
	}
	
	else{
	// return the user back with an unknow error.
	}


if($status==true){
     include "../condb.inc/connection.php";
	
	//prepared statement to insert the data in to database
	 date_default_timezone_set("Africa/Lagos"); 
	 //date_default_timezone_set("Asia/Dubai");
	 $time = date("h:i");
	 $date = date("Y-m-d");
	 $password=strip_tags($password);
	 $newPass=password_hash($password, PASSWORD_DEFAULT);
	 $ref_comm_status='off';
	 $dob=$birth_month."-".$birth_day;
	 // storing birth day and month in birthday table for birthday messages
	 $store_dob=do_birthday_record($email,$mobile,$birth_month,$birth_day);
		if($store_dob==false){
			$status=false;
			header("location:../register?error=birthdatesError&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
				exit();	
			}

	 // Prepared statement actually starts from here.
	 $stmtTwo= mysqli_stmt_init($con);
	 $sqlTwo="INSERT INTO members (FirstName,LastName,Email,Dob,Mobile,Password,Referrar,Ref_comm_status,DateRegistered,TimeRegistered )
	  VALUES(?,?,?,?,?,?,?,?,?,?)";	 
     
    if(!mysqli_stmt_prepare($stmtTwo,$sqlTwo)){
	    header("location:../register?error=sqlerror2&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	   
		}
	 else{
		 
	mysqli_stmt_bind_param($stmtTwo,'ssssssssss',$firstName,$lastName,$email,$dob,$mobile,$newPass,$ref_link, $ref_comm_status,$date,$time);
	    if(!mysqli_stmt_execute($stmtTwo)){
			 header("location:../register.php?error=sqlerror3&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
			//echo mysqli_error($con);
		}
		else{


	
		// before we refer user back for the success message, lets send welcome mail to user and also notify the admin
 require '../PHPMailer/src/Exception.php';
 require '../PHPMailer/src/PHPMailer.php';
 require '../PHPMailer/src/SMTP.php';
 $mail = new PHPMailer;
 $mail->isHTML(true);
  $mail->setFrom('admin@vtutopcenter.com', 'VTU-TOP-CENTER NIGERIA');
 $mail->addReplyTo('admin@vtutopcenter.com', 'Admin');
 // Add a recipient
$mail->addAddress($email);
$mail->AddEmbeddedImage('../web-images/regmail_banner.png','testImage','regmail_banner.png');
$mail->Subject = 'Thank you for joining VtuTopCenter';
// format the message
$message="<p><img src=\"cid:testImage\" height='200px' width='90%' style='margin-left:5%;' /></p>";
$message.="<h1 style='font-size:16px; color:#660000;'> Hi $firstName!</h1>";
$message.="<p>We at VTU-TOP-Center are glad to have you in our midst. We like you to stick with us as we give our best to enhance your daily digital needs.</p>";


$message.="<ul><li> You can buy cheap data of any network from us. </li>
                <li> You can get airtime at discount from 4% -7%  and 20% on data of all networks from Us.</li>
				<li> You can subscribe your Gotv,DSTV,Startimes and electricity bill on our platform without you stressing your self  . </li>
		<li>You can also send bulk sms to one or more numbers through our site.</li>
				<li>We have an automated gateway (A robot) that delivers your orders instantly!
        Our customers support are just a dial away .
 			</li>
 <li>We have an automated gateway (A robot) that delivers your orders instantly!Our customers support are just a dial away .</li>

</ul>";
$message.="<p>So many more services we offer; please feel free to login into your dashboard to find out more. </p>";
$message.="<p>We once again welcome you to our community. We promise an ever interesting and transparent dealings with us. </p>";
//$message.="<p style='color:lavender;'><b>Regards from Team Aoc Savers </b></p>";
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
$mailUser->Subject = 'New User Registered on VtuTopCenter';
// format the message
$message="<h1>This is to inform the admin of VtuTopCenter Nigeria that a new user just registered on the website.</h1>";
$message.="<p>See few details of the new user..</p>";
$message.="<p><b>Email:</b> $email </p>";
$message.="<p><b>User Full Name:</b> $fullname </p>";
$message.="<p><b>User Phone Number:</b>$mobile </p>";
$mailUser->Body =$message;
$ok_mailUser=$mailUser->send();	
header("location:../register?process=registered&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
		}
		/*else{
		    
			 header("location:../register?error=birthday_error&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");    
		}*/
	   
	    }
       mysqli_stmt_close($stmtTwo);
	   mysqli_close($con);

}
else{
	// return the user back with an unknow error.
	 header("location:../register?error=sqlerror4&fname=$firstName&lname=$lastName&email=$email&mobile=$mobile&heard=$heard");
	}


?>