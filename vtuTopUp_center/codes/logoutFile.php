<?php 
// log out codes.

if(isset($_GET['logout'])==true){
session_start();

 session_unset();
 session_destroy();
 header("location:../index");
  exit();
 
} 
else{
   header("location:../index?error=logoutNotproper");
   exit();	
	
}













?>