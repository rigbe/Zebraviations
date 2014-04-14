<?php
session_start(); 

if( session_is_registered("properuser") )
{
			//include_once("admin_ui.php");
  
			 // include("file:///C|/wamp/www/databasemanagement/dbhandler.php"); 
      		 //include_once("../ecardhandler.php");  /////////////////////       needs to be changed if the directory changes
			// include_once("../customerhandler.php");

	
		  //webheader();  ///////////////////   add the header file
		  
		  ?><title>BABURE - Administration Panel</title>
			<table width="80%" border="0" cellpadding="6" cellspacing="8" align="center"  >
	  <!--DWLayoutTable-->
	  <tr> 
				
    <td width="676" rowspan="2" valign="top" bgcolor="#FFFFFF" class="vertical"><table width="87%" border="0" align="center">
        <tr bgcolor="#CCCCCC"> 
          <td height="13" colspan="2"><font color="#000000"><em></em></font> <div align="center"><font color="#000000"><strong>Select from the menu on the right </strong><em><strong>..... </strong></em></font></div></td>
        </tr>
        <tr> 
          <td width="79%" height="13" bgcolor="#CCCCFF">&nbsp;</td>
          <td width="21%" bgcolor="#CCCCFF"><div align="center"></div></td>
        </tr>
      </table></p></td>
				<td width="181" height="168" valign="top" bgcolor="#CCCCCC" ><p align="center"><em><font color="#FF0000">welcome</font></em> 
			<?php echo $_SESSION['properuser'];?> <font size="4">!</font></p>
		  
      <p><a href="paymentreports.php?report=weekly">Add / Drop Train Station </a></p>
      <p><a href="gmanager.php"></a>Add / Drop Trains </p>
      <p><a href="gmanager_ecardinfo.php">Add / Drop Routes </a></p>
      <p><a href="paymentreports.php?report=commission"></a>Set Departure Times </p>
      <p><a href="adminlogout.php">Log out</a></p>
				  <p>&nbsp; </p>
				  <p>&nbsp;</p></td>
			  </tr>
			  <tr> 
				<td height="128" valign="top" bgcolor="#CCCCCC" ><p><a href="change_account.php">Change 
        My Account</a></p>
      <p>Create Accounts</p></td>
			  </tr>
			</table>
			
           <?php
		
		   

/////////////////// THIS WILL BE THE FOOTER
/////////////////  
		 
		//webfooter();   
		
		
	    }
	
	
	else
	   {
	
		 header ("Location: index.php?ermsg=You are not logged in,You have to first log in !");  //////////    sends error message to index.php of administrators
	 
	  }              //////////////////////     if the user is not a registed user
	



		///////////////////////////           FUNCTIONS.........................
		
		
		
		
		
		/////////////    this diplays ecards that  have been generated 
		






?>
