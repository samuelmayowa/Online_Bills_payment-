


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
<head><title>-Airtime_topUp-VtuTopCenter</title>
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
if(isset($_GET['recharge'])){ 
  if ($_GET['recharge']=="success"){
  	$amount=$_GET['amount'];
  	$receiver=$_GET['mobile'];
	$successReport="Airtime top up successful. You just credited  ₦".$amount. " to  ". $receiver. ".";
	} else {
		$successReport="Airtime top up successful. but something went wrong with the URL";
	}
    echo "<div  class='showSuccess'><p>". $successReport . "</p><button id='closeTwo'>CLOSE</button></div>";
  }

// incase of erorrs that comes from the function
 if(isset($_GET['functionError'])){ 
 	$errorMsg=$_GET['functionError'];
    echo "<div  class='showErrors'><p>". $errorMsg . "</p><button id='close'>CLOSE</button></div>";

 } 


       if(isset($_GET['error'])){  
    switch($_GET['error']){ 
      case "emptyFields":
            $errorMsg="Ensure you fill all required fields.";
            break;
      case "lowAmount":
            $errorMsg="Minimum amount that can be recharged is ₦10.";
            break;
      case "highAmount":
            $errorMsg="Maximum amount that can be recharged is  ₦25,000. .";
            break;
            case "insufficientBaln":
            $errorMsg="Insufficient balance to complete the transanction.";
            break;
      case "recahrgeFailed":
            $errorMsg="Error occurred during the processing.";
            break;
            case "selfTransfer":
            $errorMsg="You cannot transfer to your self."; 
            break;
             case "lowBalnc":
            $errorMsg="Insufficient wallet balance.";
            break;
            case "lowBalnc":
            $errorMsg="Insufficient wallet balance.";
            break;
            case "lowBalnc":
            $errorMsg="Insufficient wallet balance.";
            break;
            case "suspended":
            $errorMsg="You are currently suspended from this service.";
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
	              			<li><a href="#">Airtime Top Up</a></li>
		         	 	
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
         				
         					

					<h1 class='reflink'>Buy Airtime: </h1>
					<h1 style='margin-left:3%; color:green;'><em>Wallet balance:</em> ₦<?php $wallet=getWallet($u_id,$user_num);
        									echo $wallet.".00";
											?>
							</h1>
				<!-- discount for MTN: 2.00%  GLO: 2.05%  Airtel: 2.05%  9Mobile: 2.05%     -->			
					 <div id="registration-form"> <button id='wallet_funding'>Buy Airtime</button>
					 	 <button id='wallet_history'>Airtime History</button> <br/><br/> 
					 	 <p><em><b>Check Baln : </b></em>MTN: *556# &nbsp;  GLO: #124*1#   &nbsp; AIRTEL: *123#   &nbsp; 9MOBILE :*232#</p>
					 	<?php 
					 		$mtnDisct=productPrice(4);
					 		$gloDisct=productPrice(3);
					 		$airtelDisct=productPrice(2);
					 		$ninemoblDisct=productPrice(1);
					 		//convert to percetage
					 	$mtnDisctPertge=$mtnDisct."%";
					 	$gloDisctPertge=$gloDisct."%";
					 	$airtelDisctPertge=$airtelDisct."%";	
					 	$ninemoblDisctPertge=$ninemoblDisct."%";	

						?>

 <strong>MTN</strong>:<?php  echo $mtnDisctPertge ;  ?> &emsp;<strong>GLO</strong>:<?php  echo $gloDisctPertge ;  ?>  &emsp;
 <strong>Airtel</strong>:<?php  echo $airtelDisctPertge ;  ?>  &emsp;
 <strong>9Mobile</strong>: <?php  echo $ninemoblDisctPertge ;  ?> &emsp; <br/> <br/>

		<div class='fieldset' >
				 <img  id="image" src='../web-images/vtuCenter-logo.png'  style="width:70px; height:70px;display:block; margin:7px;"/>
					 <form action="../enclosed/airtimeTopUp.inc" method="post" id="wallet-form" data-validate="">
							<div class='row'>
								<label for='Network'>Select  Network: </label> 
								 <select id="network"  name='network' required >
                                		<option value="">-- Select --</option>
                                		<option value="mtn">MTN</option>
                                		<option value="glo">GLO</option>
                                		<option value="airtel">AIRTEL</option>
                                		<option value="9mobile">9MOBILE</option>
                                        
                                      </select>
							</div><br/>
							<div class='row'>
								<label for='mobile number'>Mobile Number:</label> 
									<div class="specialField">
							<input type="number" placeholder="Enter mobile number" minlength="11" maxlength="11" 
							required name='mobile' id="mobile"  value=""/> 
						
									</div><br/>
									<div class='row'>
								<label for='mobile number'>Enter Amount:</label> 
						
							<input type="number" placeholder="Enter amount" min="10" max="25000"
							required  name='amount' id="amount" value="" /> 
						
									</div><br/>
									<div class='row'>
								<label for='mobile number'>Amount To Pay:</label> 
						
							<input type="number" readonly name='amountToPay' id="amountToPay"  value="" />

						
						
									</div>
								<p id='hint'> </p>
							</div><br/>
						<p><span style="color:red;">NOTE:</span> Minimum airtime purchase is ₦50.00 and Maximum is ₦25,000.00 </p>
							<input type="submit" name='recharge' value="Buy Airtime" onClick='return confirmSubmit()'>
						</form>
					</div>
<script LANGUAGE="JavaScript">   
		function confirmSubmit()
		{
			var amount=$("#amount").val();
			var mobile=$("#mobile").val();
		var agree=confirm("You want to recharge N" +amount+ " on "+ mobile + "? press -ok- to confirm else press  -cancel- ");
		if (agree)
		 return true ;
		else
		 return false ;
		}

		
</script>
<script>
	 $(function(){
	 	$("#network").change( function(){
	 	var netwk=$("#network option:selected").val();
	 	var url="";
	 	if(netwk=="mtn"){
		 url="../web-images/mtn-logo.jpg";
		}else if (netwk=="glo"){
		 url="../web-images/glo-logo.jpg";
		}else if (netwk=="airtel"){
		 url="../web-images/airtel-logoTwo.png";
		}else if (netwk=="9mobile"){
		 url="../web-images/ninemobile-logo.png";
		}
	 $("#image").attr("src",url);

	 });

	 })
	</script>
					<!--- the table for transfer history but will display when the appropraite button is clicked -->
<div class='wallet_table' >
	<table border="1px" id="table">
		<thead>
	<tr><th> SN</th> <th> Network</th><th>Mobile No</th><th> Value</th><th>Old Balance</th> <th>Amount Deducted</th> <th>New Balance</th> 
		 <th>Status</th> <th>Date</th>
			</tr>
		</thead>
			<tbody>
				<?php
			 	include "../condb.inc/connection.php";
				$sql="SELECT * FROM airtimehistory WHERE User_id='$u_id' && User_mobile='$user_num' ORDER BY  airtm_id DESC LIMIT 10";
				$query=mysqli_query($con,$sql);
				if(!empty($query)){
					$sn=0;
					while($rows=mysqli_fetch_array($query)){
						$network=$rows['Network'];
						$mobile=$rows['Mobile'];
						$value=$rows['Value'];
						$oldBaln=$rows['Oldbalance'];
						$amount_deducted=$rows['AmountDeducted'];
						$new_baln=$rows['NewBalance'];
						$status=$rows['Status'];
						$date=$rows['TheDate'];
						if($status=='yes'){
							$status="Successfull";
						}else{
							$status="Complicated";
						}
						$sn++;
					?>
			
			<tr>
			<td><?php echo $sn ; ?></td><td><?php echo $network ; ?> </td><td><?php echo $mobile; ?></td>
			<td>&#8358;<?php echo $value; ?></td><td>&#8358;<?php echo $oldBaln; ?></td><td>&#8358;<?php echo $amount_deducted; ?></td>
			<td>&#8358;<?php echo $new_baln; ?></td><td><?php echo $status; ?></td><td><?php echo$date; ?></td>
			</tr>
			
					<?php

					}
				}


			?>	
				
			</tbody>
	</table>

</div>





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


       $("#confirmMember").click(function(){
		var mobile=$("#receiver").val();
		$.post("../enclosed/transferReceiver.inc.php",{
			   suggest:mobile
				},
			    function(data, status){
			  $("#hint").text(data);
  		});

		
	  	});

     
$("#amount").keyup(function(){
       	var sub_id="";
       var netwrk=$("#network").val();
		if(netwrk=="mtn"){
		sub_id=4;
		}else if (netwrk=="glo"){
		  sub_id=3;
		}else if (netwrk=="airtel"){
		 sub_id=2;
		}else if (netwrk=="9mobile"){
		  sub_id=1;
		}
		  	var discount="";
		$.post("../enclosed/getDataDiscount.inc",{
			   suggest:sub_id
				},
			    function(data, status){
			discount=data;
			var amount=$("#amount").val();
			discount=amount*discount;
			var amountToPay=amount-discount;
			$("#amountToPay").val(amountToPay);
			
  		});
		

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