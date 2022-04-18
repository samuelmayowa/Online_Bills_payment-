

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



// Login codes here.
$status=true;
if(!isset($_POST['loginuser'])){
	$staus=false;
	header("location:index");
	die();
}
// Get the inputs.
$mobile=strip_tags($_POST['mobile']);
$id=strip_tags($_POST['id']);
// Perform some checks, return back to registration page if error found.

if(empty($mobile) || empty($id) ){
	$status=false;
	header("location:../alegbeleye/loginuser?error=emptyFields&user=$mobile");
	exit();
	}
else if(!is_numeric($mobile)){
	$status=false;
	header("location:../alegbeleye/loginuser?error=invalidmobile&user=$mobile");
	exit();
}

$mainAdmin="09065522031";
if($mobile==$mainAdmin){
	$status=false;
	header("location:../alegbeleye/loginuser?error=isMainAdmin&user=$mobile");
	exit();
}
//lets see if admin is trying to login with his own details, we wont allow that , since he is already logged in
// admin should only log in anotther users account.
if ($mobile==$mobile_id){
	$status=false;
	header("location:../alegbeleye/loginuser?error=nosleflogin&user=$mobile");
	exit();	
}



//now lets login the admin into the user's account
//first we wiill destroy the current sesssion and create another for the admin as the user.
session_unset();
session_destroy();

$data=array("u_id"=>$id,"num"=>$mobile);
session_start();
$_SESSION['user']=$data;
header("location:../members/dashboard");






	?>