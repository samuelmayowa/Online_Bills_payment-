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

 if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

$limit=10; 
$record_index=($pageno-1) * $limit;





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
                
                    echo "<p>Welcome to  Api transactions  section: </p>";
                 

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

                
                <div class="inner-div">
                    <div class="transaction">
                     <h1>Api-Airtime Transaction </h1>


    <div  class='paginate' >                 
     <table border="1px" id="table">
        <thead>
    <tr><th> SN</th> <th> Network</th><th>Mobile No</th><th> Value</th><th>Old Balance</th> <th>Amount Deducted</th> <th>New Balance</th> 
       <th>User Name</th>   <th>Status</th> <th>Date</th>
            </tr>
        </thead>
            <tbody>
                <?php
                include "../condb.inc/connection.php";
                 $total_pages_sql = "SELECT * FROM apiairtimehistory  WHERE User_mobile='$user_num'";
                $result = mysqli_query($con,$total_pages_sql);
                $total_rows=mysqli_num_rows($result);
               
                $total_pages = ceil($total_rows/ $limit);


                $sql="SELECT * FROM apiairtimehistory WHERE User_mobile='$user_num'  ORDER BY  airtm_id DESC LIMIT $record_index, $limit";
                $query=mysqli_query($con,$sql);
                if(!empty($query)){
                    $sn=$record_index;
                    while($rows=mysqli_fetch_array($query)){
                        $network=$rows['Network'];
                        $mobile=$rows['Mobile']; 
                        $user_mobile=$rows['User_mobile'];  
                        $value=$rows['Value'];
                        $oldBaln=$rows['Oldbalance'];
                        $amount_deducted=$rows['AmountDeducted'];
                        $new_baln=$rows['NewBalance'];
                        $status=$rows['Status'];
                        $date=$rows['TheDate'];
                        if($status=='yes'){
                            $status="Successful";
                        }else{
                            $status="Complicated";
                        }
                         $user_details=memberDetailsTwo($user_mobile);
                          $user_fname=$user_details['FirstName'];

                        $sn++;
                    ?>
            
            <tr>
            <td><?php echo $sn ; ?></td><td><?php echo $network ; ?> </td><td><?php echo $mobile; ?></td>
            <td>&#8358;<?php echo $value; ?></td><td>&#8358;<?php echo $oldBaln; ?></td><td>&#8358;<?php echo $amount_deducted; ?></td>
    <td>&#8358;<?php echo $new_baln; ?></td><td><?php echo  $user_fname; ?></td><td><?php echo $status; ?></td><td><?php echo$date; ?></td>
            </tr>
            
                    <?php

                    }
                }




            ?>  
                
            </tbody>
    </table>

    
</div>
</div>
<div class="splitRecord">

        <a href="?pageno=1"><button>First</button></a>
        
  <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"> 
    <button class="<?php if($pageno <= 1){ echo 'hideButton'; } ?>" > Prev</button></a>
      
     
    
 <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">
    <button class="<?php if($pageno >= $total_pages){ echo 'hideButton'; } ?>">
Next</button></a>
       
       <a href="?pageno=<?php echo $total_pages; ?>"> <button>Last</button></a>
<?php    echo "Total records : ".$total_rows; ?>
                     
                    
                    <!-- <button id='tranx'> View Transactions</button>-->
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


     });    
    </script>

    <div id="logout">
        <p><?php echo  $f_name ;?>, are you sure you want to log-out now?</p>
        <a href="../codes/logoutFile.php?logout=true"><button class='yes'>Yes</button></a> <button class='no'>No</button>
    </div>
    
    </body>

</html>