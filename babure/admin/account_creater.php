<?
session_start(); 
include("../databasemanagement/dbhandler.php");
/////////////*************************               assigment of http post variables to local vars
$account_type=$HTTP_POST_VARS['accounttype'];
$userid=$HTTP_POST_VARS['userid'];
$password=$HTTP_POST_VARS['password'];

  if( session_is_registered("properuser") )
          {
				  $query_acc="INSERT INTO userverify (`userid`,`password`,`type`) VALUES ('$userid','$password','$account_type')";
				  if(mysql_query($query_acc))
					{
					//session_unregister("properuser");
					$topage="create_accounts.php?ermsg=The account has been successfully created !";
					$time=0;
				   
					echo "<meta http-equiv=\"refresh\" content=\"{$time}; url={$topage}\" />";  

					}
              	else
				 {
				 	$topage="create_accounts.php?ermsg=The account could not be created,Please try again !";
					$time=0;
				   
					echo "<meta http-equiv=\"refresh\" content=\"{$time}; url={$topage}\" />";  

                 }




         }
	else
	   {
	
		 header ("Location: index.php?ermsg=You are not logged in,You have to first log in !");  //////////    sends error message to index.php of administrators
	 
	  }              //////////////////////     if the user is not a registed user
		 
?>		 