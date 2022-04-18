<?php
// Functions here.
// these are functions for the new site vtutopcenter

function confirm_link($ref_num){
// function to confirm if a ref link exist. 
 //All we need do is just tofind out if the number is registered with us .	
	include "condb.inc/connection.php";  
	$sql="SELECT * FROM members WHERE Mobile='$ref_num'";
	$query=mysqli_query($con,$sql);
	if($query){
	$row=mysqli_fetch_array($query);
	if(empty($row)){
  	return false;
	exit();
	}
	else {
	      return true;
	}
	}
	 
	mysqli_close($con);
}
 function do_birthday_record($email,$mobile,$birth_month,$birth_day){
//funtion to add users birthday details into birthday table during registration
include "../condb.inc/connection.php"; 
$query_two="INSERT INTO birthday (Email,Mobile,Month,Day) VALUES('$email','$mobile','$birth_month','$birth_day')";
$query_three=mysqli_query($con,$query_two);
if($query_three){
  return true; 
    
}
else{
 return mysqli_error($con);
}

	mysqli_close($con);
}
 

function cleanseInput($input){
// this function sanitize form inputs from user.
$input=trim($input);
$input=strip_tags($input);
$input=htmlspecialchars($input,ENT_QUOTES); 
return $input;

}


function firstTime($id, $mobile_id){
// this function checks whether user is paying for the first time, by checkingfor record in wallet_funds_ record table.

	if(!is_numeric($id) ){
	 die();	
	}
	if(!is_numeric($mobile_id) ){
	 die();	
	}
// check if is the first time of saving.
 include "../condb.inc/connection.php";
$sql="SELECT * FROM wallet_funds_records WHERE User_id ='$id' AND Mobile='$mobile_id'"; 
 $query=mysqli_query($con,$sql);
 if(mysqli_num_rows($query)==0){
	
     return true;	
 }
else if(mysqli_num_rows($query)>=1){
	
	return false;
 }
	
mysqli_close($con);	
	
	
}


function convert_date($date){
//Ijust felt, the data format from the database does not look good to users
//year,month and day, its better as day, month and year.
$date=explode("-", $date);
$year=$date[0];
$month=$date[1];
$day=$date[2];
$formateDate=$day."-".$month."-".$year;
return $formateDate;
}

function is_refered($id, $mobile_id ){
	 // this function checks if a user was reffered. if reffered, it will return the referral number
	 // and if not reffered it will return false.
	if(!is_numeric($id) ){
	 die();	
	}
	if(!is_numeric($mobile_id) ){
	 die();	
	}
include "../condb.inc/connection.php";
$sql="SELECT Referrar  FROM members WHERE User_id ='$id' AND Mobile='$mobile_id'"; 
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)!==1){
	
	return false;
}
else{
$row=mysqli_fetch_array($query);
if($row['Referrar']==NULL){
	
	return false;
}
else if($row['Referrar']!==NULL){
	
	return $row['Referrar'];
}

	
}	 
	 
mysqli_close($con);	 
 } 


 function start_payin($email, $user_id,$mobile,$money,$is_first_payment,$was_referred,$is_reffered,$ref){
// this funtion stores details of payment before caling payment api.
 //we first need to delete possible exixting data that might be in table for this user
include "../condb.inc/connection.php";
$sql="DELETE FROM  payinrecords WHERE Email='$email' && User_id='$user_id' ";
mysqli_query($con,$sql); 
$date=date("Y-m-d");

//now lets insert new records
$sqlTwo="INSERT INTO  payinrecords(Email,User_id,User_mobile,Amount,Date_payed,FirstTime,Invited,Ref_link,Reference) 
VALUES('$email','$user_id','$mobile','$money','$date','$is_first_payment','$was_referred','$is_reffered','$ref')";
$query=mysqli_query($con,$sqlTwo);
	if(mysqli_affected_rows($con)!==1){

		return mysqli_error($con);
		exit();
	}else if (mysqli_affected_rows($con)==1){
		return true;

	}



mysqli_close($con);

 }

function finish_payin($email, $user_id){
// this function deletes the record of user in payin records after api has been called and value has been given
// to user.
include "../condb.inc/connection.php";
$sql="DELETE FROM  payinrecords WHERE Email='$email' && User_id='$user_id' && User_id='$user_id' ";
if(mysqli_query($con,$sql)){
	return true;
}
else{
	return false;
}


mysqli_close($con);

}
  function inForPaySavings($email,$id){
// this function checks for a user in the payin record table of the database,
// to know if user has initiated a payment'
include "../condb.inc/connection.php"; 
$query=mysqli_query($con,"SELECT * FROM   payinrecords WHERE Email='$email' AND User_id='$id'");
if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	mysqli_close($con);
}

}


function inForPaybyRef($ref){
// this function checks for a user in the payin record table of the database with ref 
// to know if user has initiated a payment'
include "../condb.inc/connection.php"; 
$query=mysqli_query($con,"SELECT * FROM  payinrecords WHERE Reference ='$ref'");
if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	
}
mysqli_close($con);
}




 function inOtp($number){
// this funtion checks if user has data in pwdreset table, actaully checking if his number is there
//If is there, then we are certain he had requested for otp, and f not there , we return the suer back to index page.
include "condb.inc/connection.php"; 
$query=mysqli_query($con,"SELECT * FROM pwdreset WHERE pwdResetEmail ='$number'");
if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	mysqli_close($con);
}

}


function inOtpAgain($number){
// this funtion checks if user has data in pwdreset table, actaully checking if his number is there
//If is there, then we are certain he had requested for otp, and f not there , we return the suer back to index page.
include "../condb.inc/connection.php"; 
$query=mysqli_query($con,"SELECT * FROM pwdreset WHERE pwdResetEmail ='$number'");
if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	mysqli_close($con);
}

}
function fetchWithSelector($selector){
// this funtion checks if user has data in pwdreset table, actaully checking if his number is there
//If is there, then we are certain he had requested for otp, and f not there , we return the suer back to index page.
include "../condb.inc/connection.php"; 
$query=mysqli_query($con,"SELECT * FROM pwdreset WHERE pwdResetSelector='$selector'");
if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	mysqli_close($con);
}

}

function clearPwdrest($identifyer){//$identifyer could be number or email
// function delete user records from pwdreset table as sson as the new password is set.
include "../condb.inc/connection.php"; 

$sql="DELETE FROM  pwdreset WHERE pwdResetEmail='$identifyer'";
if(mysqli_query($con,$sql)){
	return true;
}
else{
	return mysqli_error($con);
}


mysqli_close($con);

}
function admin_bonusPayed($ref_email, $ref_name,$ref_mobile,$bonus,$paid){
// a function to compensate admin of refferal bonus, in case the user was not referred and paying for the first time
	include "../condb.inc/connection.php";
	$sql="INSERT INTO admin_refrecords(Refered_email, Refered_name, Referred_number,Bonus,Paid )
	VALUES('$ref_email','$ref_name','$ref_mobile','$bonus','$paid')";
    $query=mysqli_query($con,$sql);
    if(mysqli_affected_rows($con)==1){
    
    return true;
    
	}else{
	   $error= mysqli_error($con);
	    return $error;
	}
		mysqli_close($con);
}

function user_bonusPayed($referral_mobile_id,$ref_email, $ref_name,$ref_mobile,$bonus,$paid){
// a function to compensate user that has referred another user
	// so we will insert the refrecords and change the ref status in member from off to "no" indicating that 
	// the bonus is now active , cos this user has paid, and the bonus can be collected now
	include "../condb.inc/connection.php";
	$sql="INSERT INTO refrecords(Ref_number,Refered_email, Refered_name, Referred_number,Bonus,Paid )
	VALUES('$referral_mobile_id','$ref_email','$ref_name','$ref_mobile','$bonus','$paid')";
    $query=mysqli_query($con,$sql);
    if(mysqli_affected_rows($con)!==1){
    
    return false;
    exit();
    }

    $sqlTwo="UPDATE members SET Ref_comm_status='no' WHERE  Mobile='$ref_mobile'";
    $queryTwo=mysqli_query($con,$sqlTwo);
    	if(mysqli_affected_rows($con)!==1){
				return false;
				exit();
				 }else{
			 	return true;
			 }


		mysqli_close($con);
}


 function getAnnouncement( ){
 	include "../condb.inc/connection.php";  
    $sql="SELECT * FROM annoucement WHERE ann_id='1' ";
    $query=mysqli_query($con,$sql);
   if($query){
	$row=mysqli_fetch_array($query);
	if(empty($row)){
  	return mysqli_error($con);
	exit();
	}
	else{
		return $row['annoucement'];
	}
	
}
else{
	
	return false;
	exit();
}


 }
  function mtnDataPin( ){
 	include "../condb.inc/connection.php";  
    $sql="SELECT * FROM vtupins WHERE networkCodes='1' ";
    $query=mysqli_query($con,$sql);
   if($query){
	$row=mysqli_fetch_array($query);
	if(empty($row)){
  	return mysqli_error($con);
	exit();
	}
	else{
		return $row['pin'];
	}
	
}
else{
	
	return false;
	exit();
}


 }


 function getBankdetails( ){
 	include "../condb.inc/connection.php";  
    $sql="SELECT * FROM bankdetails WHERE bank_id='1' ";
    $query=mysqli_query($con,$sql);
   if($query){
	$row=mysqli_fetch_array($query);
	if(empty($row)){
  	return mysqli_error($con);
	exit();
	}
	else{
		return $row;
	}
	
}
else{
	
	return false;
	exit();
}


 }


function memberDetails($id, $mobile_id ){
	//function that get user details  from members 
include "../condb.inc/connection.php";  
$sql="SELECT * FROM members WHERE User_id='$id' && Mobile='$mobile_id'";
$query=mysqli_query($con,$sql);
if($query){
	$row=mysqli_fetch_array($query);
	if(empty($row)){
  	return false;
	exit();
	}
	else{
		return $row;
	}
	
}
else{
	
	return false;
	exit();
}
	 
	mysqli_close($con); 
	 
 }



function memberDetailsTwo($mobile_id ){
	//function that get user details  from members just by supplying mobile number
	// purposely designed for transfer money page to check if the reciever is member 
include "../condb.inc/connection.php";  
$sql="SELECT * FROM members WHERE  Mobile='$mobile_id'";
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);

	return $row;
	}
	else{
		return false;
		exit();
		}
	 
	mysqli_close($con); 
	 
 }
function memberDetailsThree($mobile_id ){
//this is a more powerful function that get user details 
// from both member of wallet table using join keyword
	include "../condb.inc/connection.php";  
	$sql="SELECT * FROM members JOIN wallet 
		ON members.Mobile=wallet.Mobile  WHERE  members.Mobile='$mobile_id'";
$query=mysqli_query($con,$sql);
if($query){
	$row=mysqli_fetch_array($query);
	return $row;
}else{
	 return false;
}


}









function first_time_wallet_funding($id, $mobile_id,$amount){
//This is function that will take care of the wallet funding of firsttime paying user
//it will insert record of payment into wallet_funds_record and also in wallet table 
	$old_bal=0;
	$new_bal=$amount;
	$date=date("Y-m-d");
	include "../condb.inc/connection.php"; 
	$sql="INSERT INTO wallet_funds_records(User_id ,Mobile, Amount ,Old_balance ,New_balance,TheDate)
	VALUES('$id','$mobile_id','$amount','$old_bal','$new_bal','$date')";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){

		return false;
		exit();
	} else{
		$sqlTwo="INSERT INTO wallet(User_id ,Mobile, Amount)
		VALUES('$id','$mobile_id','$amount')";
		$queryTwo=mysqli_query($con,$sqlTwo);
			if(mysqli_affected_rows($con)==1){
				return true;
				exit();
			}else{
				return mysqli_error($con);
			}


	}



}


function getWallet($id,$mobile_id){
	// this function gets the amount in user wallet
 include "../condb.inc/connection.php";
$sql="SELECT Amount FROM wallet WHERE User_id ='$id' AND Mobile='$mobile_id'"; 
 $query=mysqli_query($con,$sql);
 if(mysqli_num_rows($query)!==1){
    $report=0;
	return $report;
	exit();
 }
 else if(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
    $report=$row['Amount'];	
	return $report;
 }
 
	mysqli_close($con);
	
	
}



function second_time_wallet_funding($id, $mobile_id,$amount,$old_balance){
	// this function handles wallet funding for user that are not funding for the first time
	//it updates the wallet table and insert payment record in wallet funding records table.
	$new_bal=$amount+$old_balance;
	$date=date("Y-m-d");
	include "../condb.inc/connection.php"; 
	$sql="INSERT INTO wallet_funds_records(User_id ,Mobile, Amount ,Old_balance ,New_balance,TheDate)
	VALUES('$id','$mobile_id','$amount','$old_balance','$new_bal','$date')";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){

		return mysqli_error($con);
		exit();
	} else{
		//we will update wallet with the new amount

			$sqlTwo="UPDATE wallet SET Amount ='$new_bal' WHERE User_id='$id' AND Mobile='$mobile_id'";
			$queryTwo=mysqli_query($con,$sqlTwo);
			if(mysqli_affected_rows($con)==1){
			    
			    return true;
			    
			}else{
			   return mysqli_error($con);
			}

			}



}


function loadCategories( ){
//function that gets the categories of products
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM categories ORDER BY category";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>1){
	while($row=mysqli_fetch_array($query)){
		$cat_code=$row['cat_code'];
		$category=$row['category'];

		$output.="<option value='$cat_code'>".$category."</option>";

	}

	echo  $output;
	} else{
		echo false;
	}
	mysqli_close($con); 



 }

 function loadSub_product($prodt_code){
//function that gets the prodcuts fro sub_product table, is more general because it 
 //can work to select any sub product, you just need to supply the prodcut code
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE prd_code='$prodt_code'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>1){
	while($row=mysqli_fetch_array($query)){
		$sub_id=$row['sub_id'];
		$sub_product=$row['sub_product'];

		$output.="<option value='$sub_id'>".$sub_product."</option>";

	}

	echo  $output;
	} else{
		echo false;
	}
	mysqli_close($con); 



 }

function mtnDataBundles( ){
//function that gets the categories of products
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE prd_code='18' ORDER BY sub_id DESC";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>1){
	while($row=mysqli_fetch_array($query)){
		$sub_id=$row['sub_id'];
		$sub_product=$row['sub_product'];

		$output.="<option value='$sub_id'>".$sub_product."</option>";

	}

	echo  $output;
	} else{
		echo false;
	}
	mysqli_close($con); 



 }

function bulkSmsPlans( ){
//function that gets tthe bulk sms plans
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE prd_code='14'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>1){
	while($row=mysqli_fetch_array($query)){
		$sub_id=$row['sub_id'];
		$sub_product=$row['sub_product'];

		$output.="<option value='$sub_id'>".$sub_product."</option>";

	}

	echo  $output;
	} else{
		echo false;
	}
	mysqli_close($con); 



 }


function loadBroadBands( ){
//function that gets broadband products
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE prd_code='18'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>1){
	while($row=mysqli_fetch_array($query)){
		$sub_id=$row['sub_id'];
		$sub_product=$row['sub_product'];

		$output.="<option value='$sub_id'>".$sub_product."</option>";

	}

	echo  $output;
	} else{
		echo false;
	}
	mysqli_close($con); 



 }



 function productPrice( $sub_prodt_id){
//function that gets the categories of products
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE sub_id='$sub_prodt_id'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)==1){
		$row=mysqli_fetch_array($query);
		$price=$row['price'];
			return $price;
		} 
	     else{

			return false;
		}
			mysqli_close($con); 

}
function simHostingDetails($networkCode){
//function that gets the sim hosting  details of a particular network 
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM simhosting WHERE Network_code='$networkCode'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)==1){
		$row=mysqli_fetch_array($query);
		
			return $row;
		} 
	     else{

			return false;
		}
			mysqli_close($con); 

}

function subProductDetails( $sub_prodt_id){
//function that gets the details of product from thesub product table
include "../condb.inc/connection.php"; 
$output=" "; 
    $sql="SELECT * FROM subproducts WHERE sub_id='$sub_prodt_id'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)==1){
		$row=mysqli_fetch_array($query);
		//$price=$row['price'];
			return $row;
		} 
	     else{

			return false;
		}
			mysqli_close($con); 

}





function refBonus($mobile_id){
//this function gets referal bonus of a user.
// note that paid status can be any of : 'no' or 'yes' or 'collected'
// no-- is when referree attempted to pay but not successful, -yes- is when referee paid and 
//-collected- is when referral has collected the bonus
include "../condb.inc/connection.php";
$mobile_id=htmlspecialchars($mobile_id, ENT_QUOTES, "UTF-8");

$sql="SELECT Bonus FROM  refrecords WHERE Ref_number ='$mobile_id' && Paid='no'"; 
$query=mysqli_query($con,$sql);
$total_bonus=0;
if(mysqli_num_rows($query)<1){
	return $total_bonus=0;
	exit();
}else{
			 while($row=mysqli_fetch_array($query)){
				    $bonus=$row['Bonus'];
					$total_bonus+=$bonus;
					}
				return $total_bonus;
			
	 }
 
 mysqli_close($con);
	 
	 
 }



 function totalTranx($mobile_id){
//-cal all transaction user made
include "../condb.inc/connection.php";
$mobile_id=htmlspecialchars($mobile_id, ENT_QUOTES, "UTF-8");

$sql="SELECT Amount_charged FROM  transactions WHERE User_mobile='$mobile_id' && Status='yes'"; 
$query=mysqli_query($con,$sql);
$total_amount_charged=0;
if(mysqli_num_rows($query)<1){
	return $total_bonus=0;
	exit();
}else{
			 while($row=mysqli_fetch_array($query)){
				    $amount_charged=$row['Amount_charged'];
					$total_amount_charged+= $amount_charged;
					}
				return $total_amount_charged;
			
	 }
 
 mysqli_close($con);
	 
	 
 }


 function updateMembersToYes($mobile_id){
 	 include "../condb.inc/connection.php";
 	 // this function will change the "no" status to "yes" but wont change for "off" because "off" 
 	 // means the member refered has not made any payment to turn it form off to no , hence it cant be received by the referar now. 
 	 
 $sqlTwo="UPDATE members SET Ref_comm_status='yes' WHERE Referrar='$mobile_id' && Ref_comm_status='no'";
     $queryTwo=mysqli_query($con,$sqlTwo);
		if(mysqli_affected_rows($con)<1){
				$function_status=false;
				//echo "System could not complete the undoing of the ref bonus record ";
				return false;
				exit();
				 }else{
			 	return true;
			 }

mysqli_close($con);
 }

 


function updateRefToYes($mobile_id){
	 include "../condb.inc/connection.php";
$sql="UPDATE refrecords SET Paid='yes' WHERE Ref_number='$mobile_id'";
	$queryFive=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){
			$function_status=false;
			//echo "Failure to complete the undoing of the ref bonus record";
			return false;
			 exit();
			 
			 } else{
			 	return true;
			 }

	mysqli_close($con);

}



function recordBulkSms($user_id,$mobile_id,$senderId,$receipients,$message,$user_wallet,$total_price,$new_balnce){
//this funtion records transaction for bulk sms
$each_number=explode(",",$receipients);
$count_numbers=count($each_number);
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="yes";
 $tranx_info="You sent bulk sms to total of  ".$count_numbers." numbers,  which costs : ₦".$total_price;
$type="Bulk-Sms";
$sqlTwo="INSERT INTO bulksmshistory (User_id, User_mobile,SenderId,Receipients,Message,Old_balance,Amount_charged,New_balance,
Status,TheDate) 
  VALUES('$user_id','$mobile_id','$senderId','$receipients','$message','$user_wallet','$total_price','$new_balnce','$status','$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return mysqli_error($con);
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$total_price','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
   if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return "Error in update".mysqli_error($con);
			}


}

mysqli_close($con);



}

function recordVtuWebsite($user_id,$mobile_id,$product,$user_wallet,$amount,$new_balnce,$name,$timeTostart){
//fuction that stores details of resellers website
//charge the user's wallet too 
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="no";
 $tranx_info="You ordered for   --".$product." and it costs : ₦".$amount;
$type="Website--( ".$product." )";
 $sqlTwo="INSERT INTO websiteoders (User_id, User_mobile,Product,Oldbalance,Amount_charged,New_balance,Status,StartTime,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$user_wallet','$amount','$new_balnce','$status','$timeTostart','$date')";
$queryTwo=mysqli_query($con,$sqlTwo);
if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return mysqli_error($con);
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$amount','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return mysqli_error($con);
			}


}

mysqli_close($con);




}
function recordElectricPay($user_id,$mobile_id,$product,$user_wallet,$amount,$new_balnce,$token){
//fuction that stores details of electric bill payment
//charge the user's wallet too 
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="no";
 $tranx_info="You paid electricity bill of  --".$product." and it costs : ₦".$amount;
$type="Electric Bills--( ".$product." )";
 $sqlTwo="INSERT INTO electrichistory (User_id, User_mobile,Product,Old_balance,Amount_charged,New_balance,
 Token,Status,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$user_wallet','$amount','$new_balnce','$token','$status', '$date')";
$queryTwo=mysqli_query($con,$sqlTwo);
if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return false;
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$amount','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return false;
    	exit();
   	}
   }
if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return false;
			}


}

mysqli_close($con);




}
function recordEduPay($user_id,$mobile_id,$pin,$serial_no,$product,$examBody,$user_wallet,$amount,$new_balnce){
// function that stores education payment data and charge wallet of user also insert into transaction
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="yes";
 $tranx_info="You purchased --".$product."for  which costs : ₦".$amount; 
$type="Education :".$product;
$sqlTwo="INSERT INTO educationhistory (User_id, User_mobile,Product,Exambody,Pin,Serial_No,Old_balance,Amount_charged,New_balance,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$examBody','$pin','$serial_no','$user_wallet','$amount','$new_balnce','$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return mysqli_error($con);
    exit();
   }
   else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$amount','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
   if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return mysqli_error($con);
			}


}

mysqli_close($con);


}

function recordMtnBulkData($user_id,$mobile_id,$product,$bulkNumbers,$user_wallet,$price,$new_balnce,$network){
// this is a function that insert records of databundlepurchased into databundle history and transaction table
//but its called after we had given value via smartsolutions api
//$count_numbers=count($bulkNumbers);
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="yes";
 $tranx_info="You purchased Bulk databundle --".$product."  which costs : ₦".$price;
 $bundleSize="bulk"; // note it is  "bulk", since it involves multiple numbers 
$type="Mtn Bulk-Data Bundle";
$beneficiary_number=null;
 $sqlTwo="INSERT INTO  databundlehistory (User_id, User_mobile,Product,Beneficiary_number,Old_balance,Amount_charged,New_balance,
 Network,BundleSize,BulkNumbers,Status,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$beneficiary_number','$user_wallet','$price','$new_balnce','$network','$bundleSize',
  '$bulkNumbers','$status', '$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return mysqli_error($con);
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$price','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
	if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return false;
			}


}

mysqli_close($con);

}



function recordBroadData($user_id,$mobile_id,$network,$product,$deviceNumber,$user_wallet,$price,$new_balnce){
// this is a function that records the subscription of broadband data; the likes of Smile 4g lte 
// and spectranent 4g lte
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="no";
 $tranx_info="You loaded Broad band databundle --".$product. " which costs : ₦".$price;

$type="BroadBandData Bundle :(".$network .")";
$sqlTwo="INSERT INTO broadbandhistory (User_id,User_mobile,Network,Product,Account_no,Old_balance,Amount_charged,New_balance,
Status,TheDate) 
  VALUES('$user_id','$mobile_id','$network','$product','$deviceNumber','$user_wallet','$price','$new_balnce','$status', '$date')";

  $queryTwo=mysqli_query($con,$sqlTwo);
   if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return false;
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$price','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return false;
    	exit();
   	}
   }
   if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return false;
			}


}

mysqli_close($con);

}




function recordTvSub($user_id,$mobile_id,$network,$product,$deviceNumber,$user_wallet,$price,$new_balnce){
//this function records cable tv sub into database and deduct the money from user account
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="no";
 $tranx_info="You made cable Tv  subscription --".$product. " which costs : ₦".$price;
 $bundleSize="single"; // note it will be "bulk", if it were a bulk datap purchase
$type="Cable Tv Sub : (".$network. ")";
$sqlTwo="INSERT INTO cabletvhistory (User_id, User_mobile,Product,Decoder_no,Oldbalance,AmountDeducted,NewBalance,Status,TheDate, 
Network) 
  VALUES('$user_id','$mobile_id','$product','$deviceNumber','$user_wallet','$price','$new_balnce','$status','$date',
  '$network')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return "error one".mysqli_error($con);
    exit();
   }
   else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$price','$new_balnce','none')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return  "error two". mysqli_error($con);

    	exit();
   	}
   }
   if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return mysqli_error($con);

			}


}

mysqli_close($con);



}



function recorDataBundle($user_id,$mobile_id,$product,$beneficiary_number,$user_wallet,$price,$new_balnce,$network){
// this is a function that insert records of databundlepurchased into databundle history and transaction table
//but its called after we had given value via smartsolutions api
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="yes";
  $tranx_info="You loaded databundle --".$product. " on ".$beneficiary_number." which costs : ₦".$price;
 $bundleSize="single"; // note it will be "bulk", if it were a bulk datap purchase
$type="Mtn Data Bundle";
$bulkNumbers=null;
 $sqlTwo="INSERT INTO databundlehistory (User_id, User_mobile,Product,Beneficiary_number,Old_balance,Amount_charged,New_balance,
 Network,BundleSize,BulkNumbers,Status,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$beneficiary_number','$user_wallet','$price','$new_balnce','$network','$bundleSize',
  '$bulkNumbers','$status', '$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return mysqli_error($con);
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$price','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
	if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return mysqli_error($con);
			}


}


mysqli_close($con);


	
}








function recordOtherNetworkData($user_id,$mobile_id,$product,$beneficiary_number,$user_wallet,$price,$new_balnce,$network){
// this is a function that insert records of databundlepurchased into databundle history and transaction table
//but its called after we had given value via smartsolutions api
$function_status=true;
include "../condb.inc/connection.php";
date_default_timezone_set("Africa/Lagos");
 $date=date("Y-m-d");
 $status="yes";
 $tranx_info="You loaded {$network} databundle --".$product. " on " .$beneficiary_number. " which costs : ₦".$price;
 $bundleSize="single"; // note it will be "bulk", if it were a bulk datap purchase
 $type= $network." Data Bundle";
$bulkNumbers=null;
 $sqlTwo="INSERT INTO databundlehistory (User_id, User_mobile,Product,Beneficiary_number,Old_balance,Amount_charged,New_balance,
 Network,BundleSize,BulkNumbers,Status,TheDate) 
  VALUES('$user_id','$mobile_id','$product','$beneficiary_number','$user_wallet','$price','$new_balnce','$network','$bundleSize',
  '$bulkNumbers','$status', '$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return  mysqli_error($con);
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$user_wallet','$price','$new_balnce','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return mysqli_error($con);
    	exit();
   	}
   }
	if($function_status=true){
	//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return mysqli_error($con);
			}


}





	
}

function recordAirtimeTopUp($user_id,$user_mobile,$network,$mobile,$value,$wallet_baln,$amount_dedcuted){
// this function after airtime has been given, this function helps to insert record into two tables namely:
//airtimehistory and transaction
$function_status=true;
include "../condb.inc/connection.php";
 date_default_timezone_set("Africa/Lagos"); 
  $date=date("Y-m-d");
  $status='yes';
  $type="Airtime Top up";
  $tranx_info="You recharged this number -".$mobile. " with ".$value. " but we gave discount and deducted ₦".$amount_dedcuted ;
  $new_baln=$wallet_baln-$amount_dedcuted;
  $sqlTwo="INSERT INTO airtimehistory (User_id, User_mobile,Network, Mobile,Value,Oldbalance, AmountDeducted,NewBalance,Status,TheDate ) 
  VALUES('$user_id','$user_mobile','$network','$mobile','$value','$wallet_baln','$amount_dedcuted','$new_baln', '$status', '$date')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    return false;
    exit();
   }else if (mysqli_affected_rows($con)==1){
   	$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$user_mobile','$date','$type','$tranx_info','$wallet_baln','$amount_dedcuted','$new_baln','$status')";
    $query=mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)!==1){
     	$function_status=false;
       return false;
    	exit();
   	}
   }
	if($function_status=true){
//lets update the amount in users wallet
		//include "../condb.inc/connection.php";
		$sqlThree="UPDATE wallet SET Amount ='$new_baln' WHERE User_id='$user_id' AND Mobile='$user_mobile'";
		$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)==1){
			 return true;
			    
			}else{
			   return "Error in update".mysqli_error($con);
			}


}





mysqli_close($con);
}

 function transferFromWallet($user_id,$user_mobile,$receiver_mobile,$amount,$sender_wallet_baln){
 	$function_status=true;
 	$error="";
 	if($amount>$sender_wallet_baln){// amount is bigger than what is in the user wallet
 		return false;
 		exit();
 	}
//lets get the reciever bal ,and add the new fund to his wallet
 	//$receiver_details=memberDetailsThree($receiver_mobile);
  include "../condb.inc/connection.php";
    $sqlAgain="SELECT * FROM members WHERE Mobile='$receiver_mobile'";
   $receiver_details=mysqli_query($con,$sqlAgain);
   $receiver_details=mysqli_fetch_array($receiver_details);
 	$recv_id=$receiver_details['User_id'];
 	$recv_fname=$receiver_details['FirstName'];
 	$recv_lname=$receiver_details['LastName'];
 	$recv_fullname=$recv_fname. " ".$recv_lname;
 	$sender_new_balance=$sender_wallet_baln-$amount;
 //lets update the sender new wallet and insert record in transfer history and transactions tables
$sql="UPDATE wallet SET Amount='$sender_new_balance'  WHERE User_id='$user_id' AND Mobile='$user_mobile'";
$query=mysqli_query($con,$sql);
if(mysqli_affected_rows($con)!==1){
    $function_status=false;
    $error="Failure to update user's  wallet";
    return $error;
    exit();
  }
//lets insert into transferHistory table
  date_default_timezone_set("Africa/Lagos"); 
  $date = date("Y-m-d");
  $status='yes';
  $sqlTwo="INSERT INTO transferhistory(TheDate,user_id,user_mobile, Receiver, Amount,Status) 
  VALUES('$date','$user_id','$user_mobile','$receiver_mobile','$amount','$status')";
  $queryTwo=mysqli_query($con,$sqlTwo);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    $error="Failure to enter transfer history records";
    return $error;
    exit();
   }

$type="Share Money Transaction";
$trax_info="You transfered {$amount} from your wallet to the wallet of another customer :{$recv_fullname}";
 $sqlThree="INSERT INTO transactions(User_id,User_mobile,TheDate,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
 VALUES('$user_id','$user_mobile','$date','$type','$trax_info','$sender_wallet_baln','$amount','$sender_new_balance','$status')";
  $queryThree=mysqli_query($con,$sqlThree);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    $error="Failure to enter transaction records";
    return $error;
    die();
   }

  // lets now see how we can insert into wallet or update the wallet of receiver,
   //i dont think we need to insert in wallet funds records, since the user is not 
   //funding by him self , this is a transfer from someone
if($function_status==true){// if all the above codes has not returned $function_status to false, it means no error so far
//will check if receiver has record in wallet, if yes we update if no; we insert.
 $sqlAnother="SELECT * FROM wallet WHERE Mobile='$receiver_mobile'";
  $queryAnother=mysqli_query($con,$sqlAnother);
  if(!$queryAnother){
  	return mysqli_error($con);
  	exit(); 
  }
	  $recv_wallet_row=mysqli_num_rows($queryAnother);

 if($recv_wallet_row!==1){
 // the receiver has no record in wallet, so we get his details from members table and insert the transfer record to his wallet.
   $receiver_details=memberDetailsTwo($receiver_mobile);
   $recv_id=$receiver_details['User_id'];

   $sqlFour="INSERT INTO wallet(User_id,Mobile,Amount) 
   VALUES('$recv_id','$receiver_mobile','$amount')";
  $queryFour=mysqli_query($con,$sqlFour);
  if(mysqli_affected_rows($con)!==1){
  	$function_status=false;
    $error="Failure to enter record for receiver";
     return  $error;
    exit();
   }

	}
	else if($recv_wallet_row==1){// for this to be true, it means receiver has 0 or above in wallet, we will update
		$RCV_Arry=mysqli_fetch_array($queryAnother);
		$recv_baln=$RCV_Arry['Amount'];
		$recv_new_balance=$amount+$recv_baln;
		$sqlFive="UPDATE wallet SET Amount='$recv_new_balance' WHERE User_id='$recv_id' AND Mobile='$receiver_mobile'";
		$queryFive=mysqli_query($con,$sqlFive);
		if(mysqli_affected_rows($con)!==1){
		    $function_status=false;
		    $error="Failure to update receiver wallet";
   		    return $error;
		    exit();
		  }


	}

if($function_status==true){

	return true;
	exit();
}

}

mysqli_close($con);
}



function sendSmsBulk($message,$senderid,$to,$gateway_code){
$token="hVKd0SApV6wv7TtWCZ8YgcylOvCmINJqdgWFTqruEplR24m0al1NY13Uq8NNFpnkVEO22hWCfrZ5zpI2ipwMFcLzj5WVS6PmNHhL";
$baseurl = 'https://smartsmssolutions.com/api/json.php?';
if(empty($gateway_code)){
	$gateway_code=3;
}

$sms_array = array 
  (
  'sender' => $senderid,
  'to' => $to,
  'message' => $message,
  'type' => '0', 
  'routing' => 	$gateway_code,
  'token' => $token
);

$params = http_build_query($sms_array);
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$baseurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 

$output=curl_exec($ch);

curl_close($ch);
$output=json_decode($output);
return $output;


}


function sendSmsSingle($message,$senderid,$to,$gateway_code){
$token="hVKd0SApV6wv7TtWCZ8YgcylOvCmINJqdgWFTqruEplR24m0al1NY13Uq8NNFpnkVEO22hWCfrZ5zpI2ipwMFcLzj5WVS6PmNHhL";
$baseurl = 'https://smartsmssolutions.com/api/json.php?';
if(empty($gateway_code)){
	$gateway_code=3;
}
$sms_array = array 
  (
  'sender' => $senderid,
  'to' => $to,
  'message' => $message,
  'type' => '0',
  'routing' => $gateway_code,
  'token' => $token
);

$params = http_build_query($sms_array);
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$baseurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

$response = curl_exec($ch);
$response=json_decode($response);
curl_close($ch);
return  $response;






}




function sendUssdCode($ussd_code,$serverToken){
$token="WJ5XgXUpQzB0rT1bZouzP03PK4ujLsiWGpRobAlfiHROBFrdj8";
$baseurl = "https://ussd.simhosting.ng/api/ussd/?";

$ussdArray = array (
  "ussd"=> $ussd_code,
  "servercode" => $serverToken,
  "token" =>$token
);

$params = http_build_query($ussdArray);
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$baseurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

$response = curl_exec($ch);
$response=json_decode($response);

curl_close($ch);
return  $response;

}




function getApidetails($user){
 	include "../condb.inc/connection.php";  
    $sql="SELECT * FROM apidetails WHERE user_number='$user'  AND valid='1'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)!==1){
	 return false;
	exit();

}elseif(mysqli_num_rows($query)==1){
	$row=mysqli_fetch_array($query);
	  return $row;
	  exit();		
	mysqli_close($con);
}


 }

function checkApiKey($api){
	// function that check if an api key is exixting in database or not
 	include "../condb.inc/connection.php";  
    $sql="SELECT * FROM apidetails WHERE api_key='$api'  AND valid='1'";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
	 return true;
	exit();

}elseif(mysqli_num_rows($query)<1){
	
	  return false;
	  exit();		
	mysqli_close($con);
}


 }

function storeApi($api,$userNo){
//function that stores newly generated api key for a user
include "../condb.inc/connection.php"; 
$valid=1;
$sql="INSERT INTO apidetails(api_key,valid,user_number)
VALUES('$api','$valid','$userNo')";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){
      return false;
      exit();
	} else if(mysqli_affected_rows($con)==1){
	  //we will update wallet with the new amount
	   return true;
       exit();
   }



mysqli_close($con);
}


function apiCustomers(){
//function that returns the numberof active api customer
include "../condb.inc/connection.php"; 
$valid=1;
$sql="SELECT * FROM apidetails WHERE  valid='1'";
$query=mysqli_query($con,$sql);
if(!$query){
	return false;
	exit;
}
$count=mysqli_num_rows($query);
if ($count<1){
	$zero="0";
	return $zero;
}else if ($count>0){
	return $count;
}



mysqli_close($con);
}

function totalApiTranx(){
//function that returns the total api tranx
include "../condb.inc/connection.php"; 
 $total_trnx=0;
$sql="SELECT Amount_charged FROM apitransactions WHERE  Status ='yes'";
$query=mysqli_query($con,$sql);
if(!$query){
    return false;
    exit;
}
$count=mysqli_num_rows($query);
if ($count<1){
    return false;
    exit;
}
$total_trnx=0;
while($dataArray=mysqli_fetch_array($query)){
        $amount=$dataArray["Amount_charged"];
        $total_trnx=$total_trnx+$amount;
       
      
}

return  $total_trnx;

mysqli_close($con);

}

function oneMonthApiTranx(){
//function that returns the total api tranx
include "../condb.inc/connection.php"; 
 $total_trnx=0;
$sql="SELECT Amount_charged FROM apitransactions WHERE TheDate  > date_sub(now(),Interval 1 month) &&  Status ='yes'";
$query=mysqli_query($con,$sql);
if(!$query){
    return false;
    exit;
}
$count=mysqli_num_rows($query);
if ($count<1){
    return false;
    exit;
}
$total_trnx=0;
while($dataArray=mysqli_fetch_array($query)){
        $amount=$dataArray["Amount_charged"];
        $total_trnx=$total_trnx+$amount;
       
      
}

return  $total_trnx;

mysqli_close($con);

}















 ?>