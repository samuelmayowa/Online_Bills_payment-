


<?php
session_start();
if(!isset($_SESSION['user'])){
 header("location:../404.php?error=unknowPage");
 die();
 }
if( !$user_id=$_SESSION['user']['u_id']){
	header("location:../404.php?error=unknowPage"); 
	}
 if(!$user_num=$_SESSION['user']['num']){
	 header("location:../404.php?error=unknowPage"); 
	 }


	 //lets fetch out user's info.
       include "../condb.inc/connection.php";
		$sql="SELECT * FROM members WHERE Mobile=$user_num";
		$query=mysqli_query($con,$sql);
		if(mysqli_num_rows($query)!==1){
		 echo "unexpected number of row";	
		}
		else{
			$row=mysqli_fetch_array($query);
			$f_name=$row['FirstName'];
			$l_name=$row['LastName'];
			ucfirst($f_name);
			$u_id=$row['User_id'];
			$email=$row['Email'];
			$Regitered_date=$row['DateRegistered'];
			}
	mysqli_close($con);	
		
 
    $fulname= $f_name. " ". $l_name;
    include "../codes/function.inc.php"; // include function file in code directory
     include("../adminCodes/adminFunctions.php");


?>



<!DOCTYPE  html>
<html>
<head><title>VtuTopCenter-Dashboard-</title>
	<meta  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta name="robots" content="noindex">

<script src="https://kit.fontawesome.com/f733bd60da.js" crossorigin="anonymous"></script>
<link href="../css/dashboardStyle.css" rel="stylesheet">
<link href="../css/generalFormStyle.css" rel="stylesheet">
<link rel='shortcut icon' href='../web-images/falvicon.png' type='image/x-icon' />
<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Handlee|Pontano+Sans" rel="stylesheet">
<script src="../jquery-3.3.1.min.js"></script>

</head>
	<body>

<?php
if(isset($_GET['success'])){ 
	 if ($_GET['success']=="walletFunded"){
	 	$amount=$_GET['amount'];
		$successReport="Wallet Funded successfuly with  ₦".$amount;
	}else {
		$amount=$_GET['amount'];
		$successReport="Bank deposit initialization for wallet ₦". $amount. " funding has been sent to Admin.";
	}
	
    echo "<div  class='showSuccess'><p>". $successReport . "</p><button id='closeTwo'>CLOSE</button></div>";
  }



       if(isset($_GET['error'])){  
    switch($_GET['error']){ 
      case "lowFirstPay":
            $errorMsg="The amount entered is lower than expected. Minimum amount is ₦1200.";
            break;
      case "adminBonusFail":
            $errorMsg="Admin compensation failed. Please re-try.";
            break;
      case "userBonusFail":
            $errorMsg="Referral's compensation failed. Please re-try.";
            break;
            case "fundindFail":
            $errorMsg="Wallet funding failed. Please re-try.";
            break;
      case "lowSubsequentPay":
            $errorMsg="The entered amount is lower than expected. Minimum amount is ₦3000.";
            break;
      case "fundindnotConfirmed":
            $errorMsg="Indiscriminate data, data from api different from database.";
            break;
      case "noRef":
            $errorMsg="No reference from payment gateway.";  
            break;
             case "notSent":
            $errorMsg="Bank deposit request not sent.";  
            break;
        default:
            $errorMsg="Unknown error occured"; 
            break;
      }

      echo "<div  class='showErrors'><p>". $errorMsg . "</p><button id='close'>CLOSE</button></div>";
    
  }



?>






		<section class='container-for-all'>
         <nav>
         	<ul>
         		<li><a>Referral Comm <br/><br/>
         			<?php
         				 $ref_bonus=refBonus($user_num);

         				 echo "<p>₦". $ref_bonus. " .00</p>";
         			?>
                  

         		</li>  
	        
	             <li >
		         	 <a href="#"  class='appear'><span><i class="fa fa-user"></i></span>
		             <span class='collapse' >My Account</span></a>
	              		<ul>
	              			<li><a href='wallet'>Add Money </a></li>
		         	 		<li><a href='sharemoney'>Share Money</a></li>
		         	 		<li><a href='transaction'>All Transactions</a></li>
		         	 		<li><a href='refEarnings'>Referral Earning</a></li>
		         	 		<li><a href='priceList'>Price List</a></li>
		         	 		<li><a href='updateProfile'>Update Profile</a></li>
		         	 		<li><a href='changePass'>Change Password</a></li>
	              		</ul>
	             </li>
	            <li>
		         	 <a href="#" class='appear'><span><i class="fas fa-fw fa-envelope"></i></span>
		             <span class='collapse'>Airtime Top up</span></a>
		             	<ul>
	              			<li><a href='airtimeTopup'>Airtime Top UP</a></li>
		         	 
		         	 		
		         	 	</ul>

		        </li>
		         <li>
		         	 <a href="#" class='appear'>
		         	 	<span>
		         	 		<i class="fas fa-cube"></i>
		         	 	</span>
		             	<span class='collapse'>Data Bundle</span></a>
		               <ul>
					 		<li><a href='mtndata'>MTN Data Bundle </a></li>
		         	 		<li><a href='bulkMtndata'>Bulk MTN  Data </a></li>
		         	 		<li><a href='otherNetworkData'>Other GSM Data </a></li>
		         	 		<li><a href="broadBand">Broadband Data</a></li>
		         	 		
         	 		 </ul>
				</li>
				<li>
		         	 <a href="cableTv"><span><i class="fas fa-fw fa-tv"></i></span>
		             <span>Cable Tv</span></a>

		        </li>
		        <li>
		         	 <a href="bulkSms"><span><i class="fas fa-fw fa-envelope"></i></span>
		             <span>SendBulkSms</span></a>


		        </li>
		         <li>
		         	 <a href="electricityPay"><span><i class="fas fa-fw fa-lightbulb"></i></span>
		             <span>Electricity</span></a>

		        </li>
		        <li>
		         	<a href="waecPin"><span><i class="fas fa-fw fa-lightbulb"></i></span>
		             <span>Education</span></a>

		        </li>
         		<li id="triggerLogOut">
		         	 <a  ><span><i class="fa fa-sign-out"></i></span>
		             <span>Logout</span></a>

		        </li>
         	 		
    	</ul>
         	 
         </nav> 
         
         <aside id="dasboard">
         	<div id="menu" > 
				<span >
         			<a href='dashboard'><img src="../web-images/vtuCenter-logoNew.png" alt="company's logo" /> </a>
         		</span>
	         	<span   class="hideMenu" >
	         	 <i class="fa fa-window-close" ></i>
	         	</span>
	         	<span  class="showMenu"  >
	         	 <i class="fas fa-bars" id='showMenu'></i>
	         	</span> 
			</div>

         	<div class="main-dashboard"> 
         		<div class="alternate_inner-div">
         			<h1 style='margin-left:3%; color:green;'><em>Wallet balance:</em> ₦<?php $wallet=getWallet($u_id,$user_num);
        									echo $wallet.".00";
											?>
							</h1>

				 <div id="registration-form"> <button id='wallet_funding'>Wallet Funding</button> <button id='wallet_history'>Wallet History</button>
					<div class='fieldset' >
						<?php 
					// bank details for the calculation here.
                             $bankDetails=getBankdetails();
                             $bank=$bankDetails['Bankdetails'];
                             $duty=$bankDetails['StampDuty'];
                            $min_funding=$bankDetails['MinFunding'];


                              ?>
						<form action="" method="post" id="wallet-form" data-validate="">
							<div class='row'>
								<label for='amount'>Amount</label> 
								<input type="number" placeholder="Amount to add" name='amount' id="amount" /> 
								<?php 
									$min_amount_payable=0;
								 	
									if(firstTime($u_id,$user_num)==true){
										$min_amount_payable=1200;
									}
									else{
										$min_amount_payable=500;
									}


									echo "<p id='hint'>Minimum online wallet funding is ₦". $min_amount_payable. "</p>";
								 ?>
								
							</div>
							<div class='row'>
								<label for="email">Select Payment Method</label>
									  <select id="mode_of_payment"  name='payment_mode'>
                                		<option value="">-- Select --</option>
                                         <option value="offline" id="val-offline"> Bank DepositTransfer </option>
                                         <option value="online" id="val-online"> Online Payment </option>
                                      </select>
                                 </div>
                            <!-- This will appear conditionally, base on whether user choose online mode or offline mode -->
                            <div id="for-deposit">
								<label for="email">Amount to be credited</label>
								<input type="number" value="0" name='deposit-amount'  id="deposit-amount" readonly /> 
					<p id="hint">Funding via Bank Deposit or Transfer attracts ₦<?php echo $duty; ?> stamp duty on every deposit.
					And minimum funding is  ₦<?php echo $min_funding; ?> </p>
									
                                 </div>
                                <input type="hidden" value="<?php echo $email;?>" name='email'  id="email" readonly /> 
                                 <input type="hidden" value="<?php echo $duty;?>" name='duty'  id="duty" readonly /> 
								<!--<div class='row'>
								<label for="cemail">Confirm your E-mail</label>
								<input type="text" placeholder="Confirm your E-mail" name='cemail' data-required="true" data-error-message="Your E-mail must correspond">
							</div>-->
							<input type="submit" name='pay' value="Proceed">
						</form>
					</div>
<!--- the table for wallet history but will display when the appropraite button is clicked -->
<div class='wallet_table' >
	<table border="1px" id="table">
		<thead>
			<tr><th> SN</th> <th> Date</th><th>Old Balance</th><th> Amount</th><th>New Bal</th> ,
			</tr>
		</thead>
			<tbody>
			<?php
			 	include "../condb.inc/connection.php";
	$sql="SELECT * FROM wallet_funds_records WHERE User_id ='$u_id' && Mobile='$user_num' ORDER BY  WalletRecord_id DESC LIMIT 10 ";
				$query=mysqli_query($con,$sql);
				if(!empty($query)){
					$sn=0;
					while($rows=mysqli_fetch_array($query)){
						$thedate=convert_date($rows['TheDate']); 
						$old_bal=$rows['Old_balance'];
						$amount=$rows['Amount'];
						$new_bal=$rows['New_balance'];
						$sn++;
					?>

			<tr>
			<td><?php echo $sn ; ?></td><td><?php echo $thedate ; ?> </td><td>&#8358;<?php echo $old_bal; ?></td>
			<td>&#8358;<?php echo $amount; ?></td><td>&#8358;<?php echo $new_bal; ?></td>
			</tr>

					<?php

					}
				}


			?>
				
				
			</tbody>
	</table>

</div>

<!--- the table for wallet history but will display when the appropraite button is clicked -->



				</div>
			</div>
		</div>
         	 <footer>
	           <div class="sub-footer">
	     		<h1 style='text-align:center; font-size:100%;'> &reg;Registered VTUTOPCenter | &copy;Copyright 2020.</h1>
	     	   </div>
     </footer>  
         </aside>
         
	</section>
	<script type="text/javascript">
	 $(document).ready(function(){
	 $(".appear").click(function(){
	 $(this).next().toggle(500);
	 $(this).find("i").toggleClass("brightIcon");

	 });
	  $(".hideMenu").click(function(){
	  $(this).hide(1000);
	  $('nav').hide(1000);
	  $("#menu").animate({width:'100%', marginLeft: "0%"}, 1000);
	  $(".showMenu").show(1000);

	  });

	  $(".showMenu").click(function(){
	  $(this).hide(1000);
	  $('nav').show(1000);
	  $("#menu").animate({width:'60%', marginLeft: "35%"}, 1000);
	  $(".hideMenu").show(1000);

	  });

	  $("#amount").keyup(function(){
		var amount=$(this).val();
		var stamp_duty=$("#duty").val();
	
		var amt_crt;
		 if(amount!=""){
		 	amt_crt=amount-stamp_duty;
		 	$("#deposit-amount").val(amt_crt)
		 }
		 
	  	});
	  	
	 $("#wallet_history").click(function(){
	 	$(".fieldset").hide();
	 	$(".wallet_table").show();

	 });

	 $("#wallet_funding").click(function(){
	 	$(".fieldset").show();
	 	$(".wallet_table").hide();

	 });
	  


	   $("#close").click(function(){
       $(".showErrors").css("display","none");
       });

       $("#closeTwo").click(function(){
       $(".showSuccess").css("display","none");
       });


       $("#triggerLogOut").click(function(){
	 	$("#logout").show();
	 });

 	$(".no").click(function(){
 		$("#logout").hide();
 	});



	 });	
	</script>


	<script>
	 $(function(){
	 	$("#mode_of_payment").change( function(){
	 	 var pay_mode= $("#mode_of_payment option:selected").val();
	 		if(pay_mode=="offline"){
	 			$("#for-deposit").show();
	 			$("#wallet-form").attr("action", "deposit_action");

				}
	 		if(pay_mode=="online"){
	 			$("#for-deposit").hide();
	 			$("#wallet-form").attr("action", "../enclosed/paywithcardFile");
	 		}

	 	})

	 })
	</script>
	
	<div id="logout">
		<p>Thanks for being our esteemed customer, are you sure you want to log-out now?</p>
		<a href="../codes/logoutFile.php?logout=true"><button class='yes'>Yes</button></a> <button class='no'>No</button>
	</div>
	</body>

</html>