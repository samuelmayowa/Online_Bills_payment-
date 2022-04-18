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
    if(adminDetails($user_num)==false){
        header("location:../404.php?error=unknowPage"); 
        exit();

        }

?>



<!DOCTYPE  html>
<html>
<head><title>Admin-AirtimeTopup-</title>
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

 if(isset($_GET['sms'])){ 
  if ($_GET['sms']=="success"){

    $successReport="Sms sent successfully.";
    echo "<div  class='showSuccess'><p>". $successReport . "</p><button id='closeTwo'>CLOSE</button></div>";
    } 
    
  }


  if(isset($_GET['error'])){  
    switch($_GET['error']){ 
      case "emptyFields":
            $errorMsg="Ensure you fill all required fields.";
            break;
      case "noPrice":
            $errorMsg="No price detected .";
            break;
      case "invalidNumber":
            $errorMsg="Number is invalid.";
            break;
            case "insufficientBaln":
            $errorMsg="Insufficient balance to complete the transanction.";
            break;
            case "lowBalnc":
            $errorMsg="Insufficient wallet balance.";
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
                         $admin_bonus=adminRefBonus();

                         echo "<p style='margin-right:1%;'>₦". $admin_bonus. " .00</p>";
                    ?>
                  

                </li>   
            <li><a href='../members/dashboard'>User's Dashboard</a></li>
                 <li >
                     <a href="#"  class='appear'><span><i class="fa fa-user"></i></span>
                     <span class='collapse' >Updating</span></a>
                        <ul>
                            <li><a href='updateAnnmnt'>Annou & Bank </a></li>
                            <li><a href='updatePrice'>Price</a></li>
                            
                            
                        </ul>
                 </li>
               <!-- <li>
                     <a href="#" class='appear'><span><i class="fas fa-fw fa-envelope"></i></span>
                     <span class='collapse'>Admin Task</span></a>
                        <ul>
                            <li><a href='airtimeTopup'>Task</a></li>
                     
                        </ul>

                </li>-->
                 <li>
                     <a href="#" class='appear'>
                        <span>
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class='collapse'>Tranx-Info</span></a>
                       <ul>
                            <li><a href='airtimetopTranx'>Airtime Topup </a></li>
                            <li><a href='mtndataTranx'>Mtn Data </a></li>
                            <li><a href='bulkmtndataTranx.php'>Bulk Mtn Data </a></li>
                            <li><a href='otherntwdataTranx.php'>Other Network Data </a></li>
                            <li><a href='broadbandTranx'>BroadBand Data </a></li>
                        
                            <li><a href="cabletvTranx">Cable Tv</a></li>
                            <li><a href="bulksmsTranx">Bulk Sms</a></li>
                            <li><a href="electricityTranx">Electricity</a></li> 
                            <li><a href="educationTranx">Education</a></li>
                            <li><a href="websiteOrderTranx">Website Orders</a></li>
                           
                            
                     </ul>
                </li>
                <li>
                     <a href="createadmin"><span><i class="fas fa-fw fa-tv"></i></span>
                     <span>Create Admin</span></a>

                </li>
                <li>
                     <a href="seeUser"><span><i class="fas fa-fw fa-envelope"></i></span>
                     <span>See a User</span></a>

                </li>
                 <li>
                     <a href="seeMembers"><span><i class="fas fa-fw fa-lightbulb"></i></span>
                     <span>All members</span></a>

                </li>
                <li><a href="#" class='appear'>
                        <span>
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class='collapse'>SMS</span></a>
                    <ul>
                        <li><a href="sendSms">Single</a></li>
                         <li><a href="sendBulkSms">Bulk</a></li>
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
                    <a href='#'><img src="../web-images/vtuCenter-logoNew.png" alt="company's logo" /> </a>
                </span>
                <span   class="hideMenu" >
                 <i class="fa fa-window-close" ></i>
                </span>
                <span  class="showMenu"  >
                 <i class="fas fa-bars" id='showMenu'></i>
                </span> 
                <?php  
                
                    echo "<p>Welcome to  Admin Section: </p>";
                 

                ?>
            </div>
            <div class="main-dashboard"> 
                <header class='dash-header'>
                    <div id="dash-div">
                        <!--<h1><i class="fas fa-tachometer-alt"></i>User Dashboard</h1>-->
                       <h1>Admin Name :</h1>
                     <?php   echo "<p>  $fulname   </p>";?>
                    </div>
                    
                </header>

                
            <div class="inner-div">
              <div id="registration-form"> <button id='wallet_funding'>Send Bulk Sms</button>
                       <br/><br/> 
                     
                            <div class='fieldset' >
                                <form action="../adminCodes/sendBulksms.inc" method="post" id="wallet-form" data-validate="">
                            <div class='row'>
                            <label for='Sender Id'>Sender ID:</label> 
                            <input type="text" name='senderId' id="senderId"  required value=""/> 
                            </div>
                            <div class='row'>
                             <label for='receipient'>Recipeint  Numbers separated with commas(,):</label> 
                            <textarea name="receipients" id="receipients" required >
                                
                            </textarea>
                            </div>
                            <div class='row'>
                                <label for='Data Type'>Sms Gateway: </label> 
                                 <select id="gateWay"  name='gateWay' required > 
                                        <option value="">-- Select --</option>
                                        <?php  bulkSmsPlans( ); ?>
                                        
                                      </select>
                                      <p id="hint">.</p>
                            </div><br/>
                            <div class='row'>
                            <label for='Message'>Message:</label> 
                            <textarea name="message" id="message"  required="">
                                
                            </textarea>
                        </div>
                            <input type="submit" name='sendsms' value="SEND SMS" onClick='return confirmSubmit()'>
                        </form>
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

       $("#viewTranx").click(function(){
        $(".wallet_table").show();

     });

       $("#tranx").click(function(){
        $(".wallet_table").show();
         $("#tranx").hide();

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

    <div id="logout">
        <p><?php echo  $f_name ;?>, are you sure you want to log-out now?</p>
        <a href="../codes/logoutFile.php?logout=true"><button class='yes'>Yes</button></a> <button class='no'>No</button>
    </div>
    
    </body>

</html>