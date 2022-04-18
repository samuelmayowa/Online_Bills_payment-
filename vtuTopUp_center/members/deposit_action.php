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

	if(!isset($_POST['pay'])){
	$status=false;
	header("location:../index");
	exit();
	}

     $amount=$_POST['amount'];
    


include "../codes/function.inc.php"; // include function file in code directory . 
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
		<section class='container-for-all'>
         <nav>
         	<ul>
         		<li><a>Referral Comm <br/><br/>
                   <p > <del style="text-decoration-style: double;">N</del> 00</p></a>

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
					 		<li><a>MTN Data Bundle </a></li>
		         	 		<li><a>Bulk MTN  Data Bundle</a></li>
		         	 		<li><a>Other GSM Data </a></li>
		         	 		<li><a>Broadband Data</a></li>
         	 		 </ul>
				</li>
				<li>
		         	 <a href="#"><span><i class="fas fa-fw fa-tv"></i></span>
		             <span>Cable Tv</span></a>

		        </li>
		        <li>
		         	 <a href="#"><span><i class="fas fa-fw fa-envelope"></i></span>
		             <span>SendBulkSms</span></a>

		        </li>
		         <li>
		         	 <a href="#"><span><i class="fas fa-fw fa-lightbulb"></i></span>
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
         			<img src="../web-images/vtuCenter-logoNew.png" alt="company's logo" /> 
         		</span>
	         	<span   class="hideMenu" >
	         	 <i class="fa fa-window-close" ></i>
	         	</span>
	         	<span  class="showMenu"  >
	         	 <i class="fas fa-bars" id='showMenu'></i>
	         	</span> 
			</div>
         	<div class="main-dashboard"> 
         		<div class="inner-div">

				 <div id="registration-form"> <a  href='wallet'><button> Back <<-</button></a> 
				 	<p>Thank you for placing wallet funding request
						Kindly make payment into the following account details</p>
					<p class="bankinfo">   
						<?php 
								$bankDetal=getBankdetails( );
								$bnkName=$bankDetal['Bankdetails'];
								$bnkDuty=$bankDetal['StampDuty'];
								$min_funding=$bankDetal['MinFunding'];
								echo $bnkName;
								 $amount_tobe_credited=$amount-$bnkDuty;

						?>


					</p>
					<?php // we want to tell user to fuckoff, incase he wants to pay below min- funding
					 if ($amount<$min_funding) {
					 $payError="This payment cannot be made as you are paying below the minimum bank deposit which is :₦ $min_funding";
					  echo "<div  class='showErrors'><p>". $payError . "</p><button id='close'>CLOSE</button></div>";
    
					 }else{

					 	?>

					<p>NB:Request ADD MONEY ONCE. </p>
					<p>Your wallet will be credited automatically once your payment is CONFIRMED. </p>
					<p>Thank You. </p>
					<p>Stamp Duty: ₦<?php echo $bnkDuty;  ?> </p>
					 <?php   echo "<p>Amount: ₦". $amount. " </p>";  ?>
					 <?php echo "<p>Amount to be credited: ₦" .$amount_tobe_credited. " </p>"; ?> 
 			<p style="color:green; font-size: 120%;">Please send this payment request to admin by clicking the <em style="color:red;">Initialize pay </em> button below, and go ahead to make the bank deposit of   ₦<?php echo  $amount; ?>
 			<form action="../enclosed/bankDeposit.inc" method="POST">
 			<input type="hidden" name="amount" value="<?php echo $amount;  ?>"/>
 			<input type="hidden" name="duty" value="<?php echo $bnkDuty;  ?>"/>
 			<input type="hidden" name="amount_credited" value="<?php echo$amount_tobe_credited;  ?>"/>
 			<input type="hidden" name="fullname" value="<?php echo $fulname;  ?>"/>    
 			<input type="hidden" name="mobile" value="<?php echo $user_num;  ?>"/>
 			<input type="hidden" name="email" value="<?php echo  $email;  ?>"/>   
 			<input type="submit" name="bankPay" value="Initialize pay"/>
 			</form>

					
					 <?php

					 }
					?>
					


					
				</div>
			</div>
		</div>
         	 <footer>
	           <div class="sub-footer">
	     		<h1 style='text-align:center; font-size:100%;'> &reg;Registered Pronfor General Merchandise Trading | &copy;Copyright 2020.</h1>
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
		var stamp_duty=50;
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
	 			$("#wallet-form").attr("action", "../index");

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
		<button class='yes'><a href="../codes/logoutFile.php?logout=true">Yes</a></button> <button class='no'>No</button>
	</div>
	
 
	</body>

</html>