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

?>



<!DOCTYPE  html>
<html>
<head><title>ReferralCommission-VtuTopCenter-</title>
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
         		<span><h2 class='reflink'>Your referral link: &nbsp;
         			<?php
         					if(firstTime($user_id, $user_num)==true){
         					echo"For new customers, referral's link is available after you fund your wallet.";
         					}elseif(firstTime($user_id, $user_num)==false){
         						// Assembling the ref link
         				 	 $pre_link="https://vtutopcenter.com/register?ref=$user_num";
         				   	echo "<a href='$pre_link'> $pre_link </a>";

         					}
         				?>
         		</h2></span>
				<span><h2 class='reflink'>Referral Bonus:
						<?php 
         				$ref_bonus=refBonus($user_num);
						echo "₦". $ref_bonus. ".00";
         									?>
					<i class="fas fa-exchange-alt"></i> 
					
					
						<button style='width:70px; height:30px;' type='submit' id='bonusTowallet'><a href='#'>Convert</a></button>
			
				</h2></span>
					<div class="alternate_inner-div">
         			<h1 style='margin-left:3%; color:green;'><em>Wallet balance:</em> ₦<?php $wallet=getWallet($u_id,$user_num);
        									echo $wallet.".00";
											?>
							</h1>

				 <div id="registration-form"> <button id='wallet_funding'>My Referrals</button> 
				 	<button id='wallet_history'>Referral Commission</button>
					<div class='fieldset' > <h1>Users referred: </h1>

	<table border="1px" id="table">
		<thead>
			<tr><th> SN</th> <th> Name</th><th>Email</th><th>Phone Number</th><th>Status</th>
			</tr>
		</thead>
			<tbody>
			<?php
			 	include "../condb.inc/connection.php";
				$sql="SELECT * FROM members WHERE Referrar='$user_num' ORDER BY  User_id DESC  LIMIT 10";
				$query=mysqli_query($con,$sql);

				if(!empty($query)){
					$sn=0;
					while($rows=mysqli_fetch_array($query)){
						$ref_fname=$rows['FirstName'];
						$ref_lname=$rows['LastName'];
						$ref_email=$rows['Email'];
						$ref_mobile=$rows['Mobile'];
						$ref_com_status=$rows['Ref_comm_status'];
					if($ref_com_status=='off'){
							$ref_com_status="Pending";
						}elseif ($ref_com_status=='no'){
							$ref_com_status="Available";
						}
						elseif ($ref_com_status=="yes"){
							$ref_com_status="Received";
						}	
						$ref_fullName=$ref_fname.' '.$ref_lname;
						$sn++;
					?>

			<tr>
			<td><?php echo $sn ; ?></td><td><?php echo$ref_fullName ; ?> </td><td><?php echo $ref_email; ?></td>
			<td><?php echo $ref_mobile; ?></td><td><?php echo $ref_com_status; ?></td>
			</tr>

					<?php

					}
				}


			?>
				
				
			</tbody>
	</table>
						
					</div>
<!--- the table for wallet history but will display when the appropraite button is clicked -->
<div class='wallet_table' > <h1>Commission Record</h1>
	<table border="1px" id="table">
		<thead>
			<tr><th> SN</th> <th> Date</th><th>User Referred</th><th>Commission</th><th>Status</th> 
			</tr>
		</thead>
			<tbody>
			<?php
			 	include "../condb.inc/connection.php";
				$sql="SELECT * FROM refrecords JOIN members ON Referred_number=Mobile WHERE Ref_number='$user_num' LIMIT 10";
				$query=mysqli_query($con,$sql);
				if(!empty($query)){
					$sn=0;
					while($rows=mysqli_fetch_array($query)){
						$thedate=$rows['DateRegistered'];
						$referred=$rows['Referred_number'];
						$bonus=$rows['Bonus'];
						$status=$rows['Paid'];
						if($status=='no'){
						// status is set to "no" from the point of first payment of the referred guy. Indicating that it has not been 
						//claimed by the referral. It will be set to yes when eventaully collected
							$status="Available";
						}elseif ($status=='yes'){
							
							$status="Paid Out";
						}
						
						$sn++;
					?>

			<tr>
			<td><?php echo $sn ; ?></td><td><?php echo $thedate ; ?> </td><td><?php echo $referred; ?></td>
			<td>&#8358;<?php echo $bonus; ?></td><td><?php echo $status; ?></td>
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
		<div class='showNotice' id ='showNotice'></div>
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

       $("#bonusTowallet").click(function(){
       var convertPrompt=confirm("You want to move your ref bonus into wallet. Click -ok- to continue; else click-cancel-");
       if(convertPrompt){
       	$.get("../enclosed/moveRefBonus.inc.php", 
       			function(data, status){
       			alert(data);
       		
  		});
	
		}
       else{
       		return false;
       }
	});


  	$("#triggerLogOut").click(function(){
	 	$("#logout").show();
	 });

 	$(".no").click(function(){
 		$("#logout").hide();
 	});






	 });	
	</script>

	
 <!--  $("#dasboard").animate({width:'95%', marginLeft: "2.5%"}, 1000);  $("#dasboard").animate({width:'98%', marginLeft: "0" }, 1000); -->
 	<div id="logout">
		<p>Thanks for being our esteemed customer, are you sure you want to log-out now?</p>
		<a href="../codes/logoutFile.php?logout=true"><button class='yes'>Yes</button></a> <button class='no'>No</button>
	</div>
	</body>

</html>