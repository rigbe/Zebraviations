<?php
session_start(); 

if( !session_is_registered("properuser") )
    header ("Location: index.php?ermsg=You are not logged in,You have to first log in !");
	
else

{

$link_value=$_REQUEST['link'];
?>	
	





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/babure_admin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Babure Administration</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
.style2 {
	color: #990000;
	font-weight: bold;
	font-size: 18px;
}
-->
</style>
</head>

<body>
<table width="100%" height="467" border="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="404" height="23" valign="top"><div align="left"><a href="../index.php">Home</a> &nbsp;&nbsp;&nbsp;<a href="../train_schedule.php">Train schedule</a> &nbsp;&nbsp;&nbsp;<a href="../departures.php">Departures</a> &nbsp;&nbsp;&nbsp; <a href="../arrivals.php">Arrivals &nbsp;</a>&nbsp;&nbsp; </div></td>
  <td colspan="2" valign="top"><div align="center" class="style2">Administration page </div></td>
    <td width="528" valign="top"><div align="right"><a href="adminlogout.php">Logout</a> </div></td>
  </tr>
  <tr>
    <td height="15" colspan="4" valign="top"><hr color="#993300" style="border-bottom-width:thin"/></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><div align="center">
      <p><img src="../images/Babure.jpg" alt="Babure banner" width="454" height="42" /></p>
        <p align="center" class="style1"><strong>Email :</strong> Babure@Babure.com , <strong>Tel:</strong> +251-116185542 </p>
    </div></td>
  <td height="39" colspan="2" valign="top"><div align="center"><a href="administration.php?link=line">Routes(RailLines)&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="administration.php?link=stations">RailStations</a> &nbsp;&nbsp; <a href="administration.php?link=schedule">Train schedules</a>&nbsp;&nbsp; <a href="administration.php?link=trains">Trains</a></div></td>
  </tr>
  <tr>
    <td width="169" height="44">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="334" colspan="4" valign="top"><!-- InstanceBeginEditable name="Body" -->
	
	<?php
	if(!empty($link_value))
        {
		
		  if($link_value=='line') 
		    {
			   $page="line_list_inc.php";
			     if(!empty($_REQUEST['line_id'])){
				   //$page=$page."?type=".$_REQUEST['type']."&line_id=".$_REQUEST['line_id'];
				     $_SESSION['type']=$_REQUEST['type'];  
					 $_SESSION['line_id']=$_REQUEST['line_id'];  
					 }  
				   
		         include($page);
			}
				 
		  if($link_value=='stations') 	
		         include("station_list_inc.php");
		
		
		   if($link_value=='trains') 	
		         include("trains_list_inc.php");
				
		
		}	    
	
	
	
	
	?>
	
	
	
	
	
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td height="3"></td>
    <td width="302"></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>

<?php

}

?>