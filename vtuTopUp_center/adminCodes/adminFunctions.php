<?php
// functions for admin activites

function adminDetails($mobile_id ){
	//function that get user details  from admin 
include "../condb.inc/connection.php";  
$sql="SELECT * FROM admin WHERE Mobile='$mobile_id' ";
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



function adminRefBonus(){
include "../condb.inc/connection.php";

$sql="SELECT Bonus FROM admin_refrecords"; 
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



function getMembersWallet(){
	// this function gets total amount of wallet value of all memebers
 include "../condb.inc/connection.php";
$total_money=0;
$sql="SELECT Amount FROM wallet"; 
 $query=mysqli_query($con,$sql);
 if(mysqli_num_rows($query)<1){
    $report=0;
	return $report;
	exit();
 }
 else {
 		 while($row=mysqli_fetch_array($query)){
				    $money=$row['Amount'];
					$total_money+=$money;
					}
				return $total_money;



 }
 
	mysqli_close($con);
	
	
}



function registeredMembers(){
	//function that get user details  from members 
include "../condb.inc/connection.php";  
$sql="SELECT * FROM members ";
$query=mysqli_query($con,$sql);
if($query){
	$rows=mysqli_num_rows($query);
		return $rows;
	}
	else{
		return "0";
		
	}
	


	 
	mysqli_close($con); 
	 
 }



function activeMembers(){
// this function checks for active memebrs, meaning users that have mony in wallet

// check if is the first time of saving.
 include "../condb.inc/connection.php";
 $mem_numbers=[];
 $countUniqueNumbers=0;
$sql="SELECT * FROM wallet"; 
 $query=mysqli_query($con,$sql);
if($query){
  while($rows=mysqli_fetch_array($query)){
  			$amount=$rows['Amount'];
  		if($amount>0){
  			$countUniqueNumbers++;
  		}


  	}

  	return $countUniqueNumbers;

}else{
	return 0;
}
mysqli_close($con);	
	
	
}



function totalTranxMonthly(){
//-cal all transaction user made
include "../condb.inc/connection.php";

$sql="SELECT Amount_charged FROM  transactions WHERE TheDate  > date_sub(now(),Interval 1 month) ";  
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

 function walletFundedEver(){
// this function checks whether user is paying for the first time, by checkingfor record in wallet_funds_ record table.

// check if is the first time of saving.
 include "../condb.inc/connection.php";
 $total=0;
$sql="SELECT * FROM wallet_funds_records"; 
 $query=mysqli_query($con,$sql);
 if($query){
 	while($rows=mysqli_fetch_array($query)){
 			$amount=$rows['Amount'];
 			 $total=$total+$amount;


 			}
 			return $total;
 }





	
}


function getUserTranx($mobile_id){
//it gets user transactions from the database 
include "../condb.inc/connection.php";  
$sql="SELECT * FROM transactions WHERE  User_mobile='$mobile_id'";
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)>=1){
	$row=mysqli_fetch_array($query);

	return $row;
	}
	else{
		return false;
		exit();
		}
	 
	mysqli_close($con); 
	 
 }


 function creditUser($user_id,$mobile_id,$amount,$old_balance,$tranx_info){
	//function that will credit user base on the admin request
	$new_balnce=$amount+$old_balance;
	$date=date("Y-m-d");
	$type="Credit";
	$amount_charged=0;
	$status="yes";

	include "../condb.inc/connection.php"; 
$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$old_balance','$amount_charged','$new_balnce','$status')";
    $queryTwo=mysqli_query($con,$sql);
  if(mysqli_affected_rows($con)!==1){
    return false;
    exit();
   }

$sqlTwo="INSERT INTO wallet_funds_records(User_id ,Mobile, Amount ,Old_balance ,New_balance,TheDate)
	VALUES('$user_id','$mobile_id','$amount','$old_balance','$new_balnce','$date')";
	$queryTwo=mysqli_query($con,$sqlTwo);
	if(mysqli_affected_rows($con)!==1){

		return false;
		exit();
	} 
		//we will update wallet with the new amount
	$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
	$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)!==1){
			   return mysqli_error($con);
			   exit(); 
			}else{
			   	return true;
			   }




}

function creditFirstTimeUser($user_id,$mobile_id,$amount,$tranx_info,$was_referred,$UserEmail,$fulName,$is_reffered){
	//function that will credit user base on the admin request
	$new_balnce=$amount;
	$old_balance=0;
	$date=date("Y-m-d");
	$type="Credit (First time)";
	$amount_charged=0;
	$status="yes";
	$paid="no";
	include "../condb.inc/connection.php";	
//lets see if reffered
if($was_referred=="no"){ 
      $admin_comm=1200;
	  $moneyleft= $amount-$admin_comm;
		//lets pay admin the ref bonus.  
		$sql="INSERT INTO admin_refrecords(Refered_email, Refered_name, Referred_number,Bonus,Paid )
			VALUES('$UserEmail','$fulName','$mobile_id','$admin_comm','$paid')";
		    $query=mysqli_query($con,$sql);
		     if(mysqli_affected_rows($con)!==1){
    
			    return false;
			    exit();
				}

   }elseif($was_referred=="yes"){
      		  		$user_comm=1000;
					$admin_comm=200;
					$total_comm=$user_comm+$admin_comm;
					$moneyleft=$amount-$total_comm;
					// give admin the bonus ofN200
			  
			$sql="INSERT INTO admin_refrecords(Refered_email, Refered_name, Referred_number,Bonus,Paid )
			VALUES('$UserEmail','$fulName','$mobile_id','$admin_comm','$paid')";
		    $query=mysqli_query($con,$sql);
		     if(mysqli_affected_rows($con)!==1){
    
			    return false;
			    exit();
				}
				// lets give user bonus
				$sqlTwo="INSERT INTO refrecords(Ref_number,Refered_email, Refered_name, Referred_number,Bonus,Paid )
				VALUES('$is_reffered','$UserEmail','$fulName','$mobile_id','$user_comm','$paid')";
			    $queryTwo=mysqli_query($con,$sqlTwo);
				    if(mysqli_affected_rows($con)!==1){
	    
				    return false;
				    exit();
					}
					
					// lets change the ref com status of the user from "off" to "no" meaning the user has made first payment , and the ref 
					// bonus can be received by the referar of this user
					$sqlMe="UPDATE members SET Ref_comm_status='no' WHERE  Mobile='$mobile_id'";
    				$queryMe=mysqli_query($con,$sqlMe);
    				if(mysqli_affected_rows($con)!==1){
				 			return false;
							exit();
							 }


      		  		}


include "../condb.inc/connection.php"; 
$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$old_balance','$amount_charged','$moneyleft','$status')";
    $queryTwo=mysqli_query($con,$sql);
  if(mysqli_affected_rows($con)!==1){
   return false;
    exit();
   }

$old_bal=0;
$new_bal=$moneyleft;
$sql="INSERT INTO wallet_funds_records(User_id ,Mobile, Amount ,Old_balance ,New_balance,TheDate)
	VALUES('$user_id','$mobile_id','$amount','$old_bal','$moneyleft','$date')";
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)!==1){

	return false;
		exit();
	} else{
		$sqlTwo="INSERT INTO wallet(User_id ,Mobile, Amount)
		VALUES('$user_id','$mobile_id','$moneyleft')";
		$queryTwo=mysqli_query($con,$sqlTwo);
			if(mysqli_affected_rows($con)==1){
				return true;
				exit();
			}else{
				return mysqli_error($con);
			}


	}



}




function debitUser($user_id,$mobile_id,$amount,$old_balance,$tranx_info){
	//function that will debit user base on the admin request
	$new_balnce=$old_balance-$amount;
	$date=date("Y-m-d");
	$type="Debit";
	$amount_charged=0;
	$status="yes";

	include "../condb.inc/connection.php"; 
$sql="INSERT INTO transactions(User_id, User_mobile,TheDate ,Type,Trans_info,Old_balance,Amount_charged,New_balance,Status) 
    VALUES('$user_id','$mobile_id','$date','$type','$tranx_info','$old_balance','$amount_charged','$new_balnce','$status')";
    $queryTwo=mysqli_query($con,$sql);
  if(mysqli_affected_rows($con)!==1){
    return false;
    exit();
   }

$sqlTwo="INSERT INTO wallet_funds_records(User_id ,Mobile, Amount ,Old_balance ,New_balance,TheDate)
	VALUES('$user_id','$mobile_id','$amount','$old_balance','$new_balnce','$date')";
	$queryTwo=mysqli_query($con,$sqlTwo);
	if(mysqli_affected_rows($con)!==1){

		return false;
		exit();
	} 
		//we will update wallet with the new amount
	$sqlThree="UPDATE wallet SET Amount ='$new_balnce' WHERE User_id='$user_id' AND Mobile='$mobile_id'";
	$queryThree=mysqli_query($con,$sqlThree);
		if(mysqli_affected_rows($con)!==1){
			   return mysqli_error($con);
			   exit(); 
			}else{
			   	return true;
			   }




}



function makeAdmin($adminmobile,$adminemail,$fulname,$pass){
///this funtion helps create an dmin that can maanage the site
include "../condb.inc/connection.php"; 	
$sqlTwo="INSERT INTO admin(Email ,Mobile,Password,Name)
	VALUES('$adminemail','$adminmobile','$pass','$fulname')";
	$queryTwo=mysqli_query($con,$sqlTwo);
	if(mysqli_affected_rows($con)==1){
  		return true;
    	exit();
	   }else{
	   	return mysqli_error($con);
	   }

}



function removeUser($mobile,$user_id){
//this removed user from member table, user ceasedto be a memeber.
//also the record in wallet and wallet fund records are removed
$status=false;	
include "../condb.inc/connection.php";
$sql="DELETE FROM  members WHERE User_id='$user_id' &&  Mobile='$mobile'";
$del=mysqli_query($con,$sql);
if(mysqli_affected_rows($con)!==1){
	return mysqli_error($con);
	exit();
}

$sqlTwo="DELETE FROM wallet WHERE User_id='$user_id' &&  Mobile='$mobile'";
$delTwo=mysqli_query($con,$sqlTwo);
if(!$delTwo){
	return  mysqli_error($con);
	exit();
}

$sqlThree="DELETE FROM wallet_funds_records WHERE User_id='$user_id' &&  Mobile='$mobile'";

$delThree=mysqli_query($con,$sqlThree);
if(!$sqlThree){
	return  mysqli_error($con);
	exit();
}else{
	return true;
}


mysqli_close($con);

}






function suspendUser($mobile,$UserEmail){
// function suspend user
// by simply inserting user records in the suspend memebr table

include "../condb.inc/connection.php";
$sqlTwo="INSERT INTO suspendusers(Email,Mobile)
	VALUES('$UserEmail','$mobile')";
	$queryTwo=mysqli_query($con,$sqlTwo);
	if(mysqli_affected_rows($con)==1){
  		return true;
    	exit();
	   }else{
	   	return mysqli_error($con);
	   }


mysqli_close($con);

}



function is_suspended($mobile_id){
// check if user is suspended, i.e user in suspenduser table
 include "../condb.inc/connection.php";
$sql="SELECT * FROM suspendusers WHERE  Mobile='$mobile_id'"; 
 $query=mysqli_query($con,$sql);
 if(mysqli_num_rows($query)>=1){
	
     return true;	
 }
else if(mysqli_num_rows($query)==0){
	
	return false;
 }
	
mysqli_close($con);	
	
	
}


function unSuspendUser($mobile){
// remove user form suspension table
 include "../condb.inc/connection.php";

$sqlTwo="DELETE FROM suspendusers WHERE Mobile='$mobile'";
$delTwo=mysqli_query($con,$sqlTwo);
if(!$delTwo){
	return  false;
	exit();
}else{
	return true;
}
	
}


 
 ?>