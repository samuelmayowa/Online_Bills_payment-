<?php
// Login codes here.
$status=true;
if(!isset($_POST['login'])){
	$staus=false;
	header("location:index");
	die();
}
// Get the inputs.
$mobile=strip_tags($_POST['mobile']);
$password=strip_tags($_POST['pass']);


// Perform some checks, return back to registration page if error found.

if(empty($mobile) || empty($password) ){
	$status=false;
	header("location:../login?error=emptyFields&num=$mobile");
	exit();
	}
else if(!is_numeric($mobile)){
	$status=false;
	header("location:../login?error=invalidmobile&num=$mobile");
	exit();
}

$mobile_digit=strlen($mobile);
if ($mobile_digit<11){
 $status=false;
	header("location:../login?error=shortmobile&num=$mobile");
	exit();

}



// Continue with form processing if above statements do not return error.
if($status==true){
	include "../condb.inc/connection.php";
	$stmt= mysqli_stmt_init($con);
	$sql="SELECT * FROM members WHERE Mobile=?";
	if(!mysqli_stmt_prepare($stmt,$sql)){
		$status=false;
		header("location:../login?error=sqlerror&num=$mobile");
		
	   }
	   else{
			mysqli_stmt_bind_param($stmt,'i',$mobile);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result)==1){
					$row=mysqli_fetch_assoc($result);
					$passCheck=password_verify($password, $row['Password']);
					if($passCheck==false ){
						$status=false;
						header("location:../login?error=incorrectdetails&num=$mobile");
						exit();
	 					}
	 				else if($passCheck==true){
						// log the user in 
						//echo"The user is registered with us and both email and password are correct..";
						session_start();
						$data=array("u_id"=>$row['User_id'],"num"=>$row['Mobile']);
						$_SESSION['user']=$data;
						header("location:../members/IntelsD/dashboard");
	 					}
	 					else{
							 $status=false;
							header("location:../login?error=incorrectdetails&num=$mobile");
							exit();
						 	}
			    }
			    else{  // i can put else statement here, telling the user he is not found in the register 
			    		$status=false;
						header("location:../login?error=unregsiterednum&num=$mobile");
						exit();

			        }

			}
	mysqli_stmt_close($stmt);
	mysqli_close($con);




}




	?>