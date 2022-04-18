
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
<head><title>-MTN Databundle-VtuTopCenter</title>
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
if(isset($_GET['data'])){ 
  if ($_GET['data']=="success"){
  	$amount=$_GET['amount'];
  	$product=$_GET['product'];
	$successReport="Your subscription  of ".$product. " was successful for this amount : ". $amount. ".";
	} else {
		$successReport="Data bundle subscription was  successful. But something went wrong with the URL";
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
      case "noPrice":
            $errorMsg="Price of product was not found.";
            break;
      case "dataFailed":
            $errorMsg="There was an error while processing your request .";
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
             case "insufficientBaln":
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
         				
         					

					<h1 class='reflink'>Buy Mtn Data Bundle: </h1>
					<h1 style='margin-left:3%; color:green;'><em>Wallet balance:</em> ₦<?php $wallet=getWallet($u_id,$user_num);
        									echo $wallet.".00";
											?>
							</h1>
		
				<!-- discount for MTN: 2.00%  GLO: 2.05%  Airtel: 2.05%  9Mobile: 2.05%     -->			
					 <div id="registration-form"> <button id='wallet_funding'>Buy Data</button>
					 	 <button id='wallet_history'>Data History</button> <br/><br/> 
					  <p><em><b>Check data Baln : </b></em>MTN: *461*4# &nbsp;</p>
					 	 	<div class='fieldset' >
					 	 	<img  id="image" src='../web-images/mtn-logo.jpg'  style="width:70px; height:70px;display:block; margin:7px;"/>
					 	 		<form action="../enclosed/buymtndata.inc" method="post" id="wallet-form" data-validate="">   
							<div class='row'>
								<label for='Data Type'>Select  Data Type: </label> 
								 <select id="dataType"  name='dataType' required > 
                                		<option value="">-- Select --</option>
                             			<?php mtnDataBundles( ) ?>
                                        
                                      </select>
							</div><br/>
							<div class='row'>
								<label for='Amount'>Amount:</label> 
							<input type="text"  readonly name='amount' id="amount"  value=" "/> 
							</div>
							<div class='row'>
								<label for='Amount to pay'>Amount To Pay:</label> 
							<input type="text"  readonly name='amountToPay' id="amountToPay"  value="" /> 
							</div>
							<div class='row'>
								<label for='Amount to pay'>Mobile Number:</label> 
							<input type="number"   name='mobile' id="mobile"  value="" /> 
							</div>
							<input type="submit" name='buyMtnData' value="Buy Mtn Data" onClick='return confirmSubmit()'>
						</form>
					</div>
<script LANGUAGE="JavaScript">
		function confirmSubmit()
		{
			var amount=$("#amount").val();
			var mobile=$("#mobile").val();
		var agree=confirm("You are about to buy MTN data bundle worth of  " +amount+ " on "+ mobile+" ,  press -ok- to confirm else press  -cancel- ");
		if (agree)
		 return true ;
		else
		 return false ;
		}

		
</script>
<script type="text/javascript">
		$("#dataType").change(function(){
		var sub_prodt_id=$(this).val();

		$.post("../enclosed/getMtnDataPrice",{
			   suggest:sub_prodt_id
				},
			    function(data, status){
			    data=' ₦'+data;
			$("#amount").val(data);
			$("#amountToPay").val(data);
  		});
		});



			</script>
					<!--- the table for transfer history but will display when the appropraite button is clicked -->
<div class='wallet_table' >
	<table border="1px" id="table">
		<thead>
	<tr><th> SN</th> <th>Product</th><th>Mobile No</th><th>Old Balance</th> <th>Amount Deducted</th> <th>New Balance</th> 
		 <th>Status</th> <th>Date</th>
			</tr>
		</thead>
			<tbody>
				<?php
			 	include "../condb.inc/connection.php";
$sql="SELECT * FROM databundlehistory WHERE User_id='$u_id'  && Network='Mtn' && BundleSize='single' 
 ORDER BY  dataHist_id DESC";
				$query=mysqli_query($con,$sql);
				if(!empty($query)){
					$sn=0;
					while($rows=mysqli_fetch_array($query)){
						$product=$rows['Product'];
						$mobile=$rows['Beneficiary_number'];
						$oldBaln=$rows['Old_balance'];
						$amount_deducted=$rows['Amount_charged'];
						$new_baln=$rows['New_balance'];
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
			<td><?php echo $sn ; ?></td><td><?php echo $product; ?> </td><td><?php echo $mobile; ?></td>
			<td>&#8358;<?php echo $oldBaln; ?></td><td>&#8358;<?php echo $amount_deducted; ?></td><td>&#8358;<?php echo $new_baln; ?></td>
			<td><?php echo $status; ?></td><td><?php echo $date; ?></td>
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
       	var discount="";
       var netwrk=$("#network").val();
		if(netwrk=="mtn"){
		discount=0.02;
		}else if (netwrk=="glo"){
		  discount=0.0205;
		}else if (netwrk=="airtel"){
		  discount=0.0205;
		}else if (netwrk=="9mobile"){
		  discount=0.0205;
		}
		var amount=$("#amount").val();
		discount=amount* discount;
		var amountToPay=amount-discount;
		$("#amountToPay").val(amountToPay);

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