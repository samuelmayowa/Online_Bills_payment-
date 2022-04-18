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

if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

$limit=5; 
$record_index=($pageno-1) * $limit;

if(isset($_GET['key'])){ 
  if ($_GET['key']=="created"){
    
    $successReport="Your Api key has been generated successfully";
    } else {
        $successReport="Your Api key has been generated successfully. But something went wrong with the URL";
    }
    echo "<div  class='showSuccess'><p>". $successReport . "</p><button id='closeTwo'>CLOSE</button></div>";
  }





 if(isset($_GET['error'])){ 
        $api_error=""; 
    switch($_GET['error']){ 
      case "emptyFields":
            $errorMsg="Ensure you fill favourite city.";
            break;
      case "apikeyExist":
            $errorMsg="You have an existing api key.";
            break;
      case "highAmount":
            $errorMsg="Maximum amount that can be recharged is  ₦25,000. .";
            break;
            case "insufficientBaln":
            $errorMsg="Insufficient balance to complete the transanction.";
            break;
            default:
            $errorMsg="Unknown error occured"; 
            break;
      }

      echo "<div  class='showErrors'><p>". $errorMsg . "</p><button id='close'>CLOSE</button></div>";
    
  }


?>



<!DOCTYPE  html>
<html>
<head><title>VtuTopCenter-Api-services-</title>
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
        <section class='container-for-all'>
        <nav>
            <ul>
                <li><a>Referral Comm <br/><br/>
                   <?php
                         $ref_bonus=refBonus($user_num);

                         echo "<p>₦". $ref_bonus. " .00</p>";
                    ?>
                  

                </li>   
            <li><a href='../members/api-service'><span><i  class="fas fa-fw fa-home"></i></span>
                <span>Api - Home page </span></a></li>
                 
               <!--  <li><a href="#"><span></span>
                <span>Api-tranx </span></a></li>-->
                <li>
                     <a href="api-airtime-tranx"><span><i  class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Airtime Topup</span></a>

                </li>
                <li>
                     <a href="api-mtndata-tranx"><span><i  class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Mtn Data</span></a>

                </li>
                <li>
                     <a href="api-bulkmtn-tranx"><span><i  class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Bulk Mtn Data</span></a>

                </li>
                 <li>
                     <a href="api-othernetworkd-tranx"><span><i class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Other Network Data</span></a>

                </li>
                 <li>
                     <a href="api-braodband-tranx"><span><i class="fas fa-fw fa-lightbulb"></i></span>
                     <span>BroadBand Data</span></a>

                </li>
                 <li>
                     <a href="api-cabletv-tranx"><span><i class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Cable Tv</span></a>

                </li>
                <li>
                     <a href="api-electricity-tranx"><span><i class="fas fa-fw fa-lightbulb"></i></span>
                     <span>Electricity</span></a>

                </li>
                <li>
                     <a href="api-education-tranx"><span><i class="fas fa-fw fa-lightbulb"></i></span>
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
                    <a href='../members/dashboard'><img src="../web-images/vtuCenter-logoNew.png" alt="company's logo" /> </a>
                </span>
                <span   class="hideMenu" >
                 <i class="fa fa-window-close" ></i>
                </span>
                <span  class="showMenu"  >
                 <i class="fas fa-bars" id='showMenu'></i>
                </span> 
                <?php  
                
                    echo "<p>Welcome to  Api- services, connect your web application to our web services: </p>";
                 

                ?>
            </div>
            <div class="main-dashboard"> 
                <header class='dash-header'>
                    <div id="dash-div">
                        <!--<h1><i class="fas fa-tachometer-alt"></i>User Dashboard</h1>-->
                       <h1>User's name :</h1>
                     <?php   echo "<p>  $fulname   </p>";?>
                    </div>
                    
                </header>
                <?php  
                $nonAdmin='';
                if($user_num!=="09065522031"){
                   $nonAdmin="nonAdmin"; 
                }

                    $api_details=getApidetails($user_num);
                    if($api_details!==false){
                        $api_key=$api_details['api_key'];
                    }else{
                       $api_key="You have no Api - key yet."; 
                    }
                 
                   


                ?>
                

                <div class="inner-div">
                        <h1 class='reflink'>Api keys generating form </h1>
                    <div id="registration-form"> 
                     
                            <div class='fieldset'>
                            
                             <!--   <form action="../enclosed/generateApi.inc" method="post" id="wallet-form" data-validate="">
                        
                            <div class='row'>
                                <label for='Amount'>Api-key:</label> 
                            <input type="text"   name='apikey' id="apikey"  value="<?php echo $api_key; ?> " readonly/> 
                            </div>

                            
                  <?php 
                         if($api_details==false){
                       
                    ?>

                            <div class='row'>
                                <label for='Amount to pay'>Favorite city:</label> 
                            <input type="text"  name='favCity' id="favCity"  value="" required  /> 
                            </div>
                             <input type="submit" name='getApi' value="Generate new api key" onClick='return confirmSubmit()'>
                    <?php
                    }
                    ?>   
                        </form>-->
                    </div>
                </div>
             </div>


                
                <div class="inner-div">
                    <div class="transaction">
                     <h1>Api based transactions in last one month </h1>


    <div  class='' >                 
     <table border="1px" id="table">
         <thead>
        <tr><th> SN</th> <th>User no:</th> <th>Date</th><th>Product</th><th>Beneficiary</th><th>Old Balance</th><th>Amount Charged</th><th>New Balance</th><th>Status</th>
            </tr>
        </thead>
            <tbody>
            <?php
                include "../condb.inc/connection.php";
                 $total_pages_sql = "SELECT * FROM apitransactions WHERE User_mobile='$user_num'";
                $result = mysqli_query($con,$total_pages_sql);
                $total_rows=mysqli_num_rows($result);
                $total_pages = ceil($total_rows/ $limit);


 $sql="SELECT * FROM apitransactions WHERE TheDate  > date_sub(now(),Interval 1 month) AND User_mobile='$user_num' ORDER BY 
  Trans_id DESC LIMIT $record_index, $limit "; 
                $query=mysqli_query($con,$sql);

                if(!empty($query)){
                    $sn=$record_index;
                    while($rows=mysqli_fetch_array($query)){
                        $date=$rows['TheDate'];
                        $date=convert_date($date);
                        $type=$rows['Type'];
                        $old_baln=$rows['Old_balance'];
                        $amount_charged=$rows['Amount_charged'];
                        $new_baln=$rows['New_balance'];
                        $beneficiary=$rows['Beneficiary_number'];
                        $status=$rows['Status'];
                         $user_mobile=$rows['User_mobile'];
                        if($status=='yes'){
                            $status="Successful";
                        }else{
                            $status="Pending";
                        }
                        $sn++;
                    ?>

            <tr>
<td><?php echo $sn ; ?></td><td><?php echo $user_mobile ; ?><td><?php echo $date ; ?> </td><td><?php echo $type; ?></td>
<td><?php echo $beneficiary; ?></td><td>&#8358;<?php echo $old_baln; ?></td>
            <td>&#8358;<?php echo $amount_charged; ?></td><td>&#8358;<?php echo $new_baln; ?></td><td><?php echo $status; ?></td>
            </tr>

                    <?php

                    }
                }


            ?>
                
                
            </tbody>
    </table>
</div>
 
       
                   </div>

</div class="splitRecord">

        <a href="?pageno=1"><button>First</button></a>
        
  <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"> 
    <button class="<?php if($pageno <= 1){ echo 'hideButton'; } ?>" > Prev</button></a>
      
     
    
 <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">
    <button class="<?php if($pageno >= $total_pages){ echo 'hideButton'; } ?>">
Next</button></a>
       
       <a href="?pageno=<?php echo $total_pages; ?>"> <button>Last</button></a>
<?php    echo "Total records : ".$total_rows; ?>
<!-- <span><p><a href="https://vtutopcenterapi.readme.io/" target="_blank">API's documentation</a></p></span>-->
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

       $("#viewTranx").click(function(){
        $(".wallet_table").show();

     });

       $("#tranx").click(function(){
        $(".wallet_table").show();
         $("#tranx").hide();

     });


    $("#triggerLogOut").click(function(){
        $("#logout").show();
     });

    $(".no").click(function(){
        $("#logout").hide();
    });

    $("#close").click(function(){
       $(".showErrors").css("display","none");
       });

       $("#closeTwo").click(function(){
       $(".showSuccess").css("display","none");
       });



     });    
    </script>

    <div id="logout">
        <p><?php echo  $f_name ;?>, are you sure you want to log-out now?</p>
        <a href="../codes/logoutFile.php?logout=true"><button class='yes'>Yes</button></a> <button class='no'>No</button>
    </div>
    
    </body>

</html>