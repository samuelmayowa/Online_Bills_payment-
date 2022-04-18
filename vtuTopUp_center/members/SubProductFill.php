


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
<head><title>-Share-Money-VtuTopCenter</title>
	<meta  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta name="robots" content="noindex">

<script src="https://kit.fontawesome.com/f733bd60da.js" crossorigin="anonymous"></script>
<link href="../css/dashboardStyle.css" rel="stylesheet">
<link href="../css/generalFormStyle.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Handlee|Pontano+Sans" rel="stylesheet">
<script src="../jquery-3.3.1.min.js"></script>


</head>
	<body>



<?php
 include "../condb.inc/connection.php";

if(isset($_POST['submit'])){     
	$prd_code=$_POST['prd_code'];  
	$sub_product= $_POST['sub-product'];
	$price=$_POST['price'];
	//echo "<div  class='showSuccess'>". $cat_code." ". $category."</div>";
//lets insert in  data into category table
	$sql="INSERT INTO subproducts (prd_code ,sub_product,price )
	VALUES('$prd_code',	'$sub_product','$price')";  
	$query=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)==1){
		echo "<div  class='showSuccess'> Sub Product insertted.</div>";
		//exit();
	}else{
		echo "<div  class='showSuccess'>Sub Product was not inserted.</div>";
	}


//echo "<div  class='showSuccess'>". $cat_code." ". $product." ".$prod_code."</div>";

mysqli_close($con);
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
	              			<li><a href="wallet">Add Money </a></li>
		         	 		<li><a href='#'>Share Money</a></li>
		         	 		<li><a href='transaction'>All Transactions</a></li>
		         	 		<li><a href='refEarnings'>Referral Earning</a></li>
		         	 		<li href='updateProfile'><a>Price List</a></li>
		         	 		<li><a>Update Profile</a></li>
		         	 		<li><a>Change Password</a></li>
		         	 		
	              		</ul>
	             </li>
	            <li>
		         	 <a href="#" class='appear'><span><i class="fas fa-fw fa-envelope"></i></span>
		             <span class='collapse'>Airtime Top up</span></a>
		             	<ul>
	              			<li><a>Airtime Top Up</a></li>
		         	 	
		         	 	</ul>

		        </li>
		         <li>
		         	 <a href="#" class='appear'>
		         	 	<span>
		         	 		<i class="fas fa-cube"></i>
		         	 	</span>
		             	<span class='collapse'>Data Bundle</span></a>
		               <ul>
					 		<li><a>MTN SME Data </a></li>
		         	 		<li><a>MTN Direct Data</a></li>
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
		         	 <a href="#" class='appear'><span><i class="fas fa-fw fa-graduation-cap"></i></span>
		             <span class="collapse">Education</span></a>
		            <ul>
		             	<li>Waec Result Checker</li>
		             </ul>

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
         				
         					
			
				
					<h1 class='reflink'>Fill the Sub-Products  table: </h1>
					
							
					 <div id="registration-form"> 
					 	 <button id='wallet_history'>For sub-products table</button>
					 	 	<div class='fieldset' >
					 	 		<form action="" method="post" id="wallet-form" data-validate="">
							<div class='row'>
								<label for='productCode'>product Code:</label> 
								<input type="number" placeholder="" name='prd_code' id="cat_code" /> 
								
							</div><br/>
							<div class='row'>
								<label for='Products'>Sub-Product:</label> 
								<input type="text" placeholder="" name='sub-product' id="sub_code" /> 
								
							</div><br/>
							<div class='row'>
								<label for='price'>Price:</label> 
								<input type="text" placeholder="" name='price' id="price" /> 
							</div>
								<input type="submit" name='submit' value="Submit Sub-Product" >
						</form>
					</div>
<script LANGUAGE="JavaScript">
		function confirmSubmit()
		{
			var num=$("#receiver").val();
			var money=$("#amount").val();
		var agree=confirm("Do you really want to transfer N" +money+ " to "+ num + "? press -ok- to confirm else press  -cancel- ");
		if (agree)
		 return true ;
		else
		 return false ;
		}

		
</script>
					<!--- the table for transfer history but will display when the appropraite button is clicked -->
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
		<button class='yes'><a href="../codes/logoutFile.php?logout=true">Yes</a></button> <button class='no'>No</button>
	</div>
	</body>

</html>