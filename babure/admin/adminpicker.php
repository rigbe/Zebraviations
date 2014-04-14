<?php
session_start(); 
include("../Connections/dbconnection.php");


$userid=$_POST['userid'];
$password=$_POST['password'];

$getuser="SELECT * from administrators WHERE (userid='$userid' And password='$password')";

// the type of administrator has not been checked
$result= mysql_query($getuser); 


	if (mysql_num_rows($result) >= 1 ) 
		{
		  $row=mysql_fetch_array($result);
		  $usertype=$row['type'];
		
		  $properuser=$row['userid']; 
		  $_SESSION['properuser']=$properuser;                      
		
		  $_SESSION['account_type']=$usertype;
		  $_SESSION['password']=$password;
		                                       
											   
   // Pickin the right kind of user and page for each admin type....
  										   
		  switch($usertype)
		   {
		     case 'admin':
			    header("Location: administration.php");
				 break;
			 case 'sales_person':
			   header("Location: sales_person.php");
			   break;
			 case 'manager':
			    header("Location: manager.php");
				break;
			}		
	 exit;	
		}
		
		
   else  
       {
    
     header ("Location: index.php?ermsg=Sorry, wrong username and /or password");
		
		
     	}
		

/////////////////////////////         user has been identified




?>