<?php require_once('Connections/dbconnection.php'); ?>
<?php

//  This page contains codes that enable searching of train schedules: 
mysql_select_db($database_dbconnection, $dbconnection);
$query_stations = "SELECT * FROM railstations ORDER BY name ASC";
$stations = mysql_query($query_stations, $dbconnection) or die(mysql_error());
$row_stations = mysql_fetch_assoc($stations);
$totalRows_stations = mysql_num_rows($stations);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Babure.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Babure - Train schedule</title>
<SCRIPT SRC="common/calendar.js"></SCRIPT>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.style2 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
<!-- InstanceEndEditable -->
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
-->
</style>
</head>

<body>
<table width="100%" height="467" border="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="883" height="23" valign="top"><div align="left"><a href="index.php">Home</a> &nbsp;&nbsp;&nbsp;<a href="train_schedule.php">Train schedule</a>  &nbsp;&nbsp;&nbsp;<a href="departures.php">Departures</a> &nbsp;&nbsp;&nbsp; <a href="arrivals.php">Arrivals &nbsp;</a>&nbsp;&nbsp; </div></td>
  <td width="528" valign="top"><div align="right"><a href="admin/index.php">BabureLogin</a> </div></td>
  </tr>
  <tr>
    <td height="15" colspan="2" valign="top"><hr color="#993300" style="border-bottom-width:thin"/></td>
  </tr>
  <tr>
    <td height="85" colspan="2" valign="top"><div align="center">
      <p><img src="images/Babure.jpg" alt="Babure banner" width="454" height="42" /></p>
      <p align="center" class="style1"><strong>Email :</strong> Babure@Babure.com , <strong>Tel:</strong> +251-116185542 </p>
    </div></td>
  </tr>
  <tr>
    <td height="334" colspan="2" valign="top"><!-- InstanceBeginEditable name="Body" -->
      <table width="100%" height="325" border="0">
        <!--DWLayoutTable-->
        <tr>
          <td width="339" height="25">&nbsp;</td>
          <td width="64">&nbsp;</td>
          <td width="42">&nbsp;</td>
          <td width="124">&nbsp;</td>
          <td width="449">&nbsp;</td>
          <td width="371" rowspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" rowspan="4" valign="top">&nbsp;
	      <?php
		    if(isset($_GET['btnsearch']))
			  {
			   
			    include("quick_search_inc.php");
			  
			  }
		   
		      
		      
		      
          
		  
		  ?>		  </td>
        </tr>
        
        <tr>
          <td height="179" colspan="2" valign="top">
            <fieldset>
            <form action="train_schedule.php" method="get" name="frmsearch" id="frmsearch">
            <table width="200" border="0">
              <tr>
                <td colspan="2"><p><em><strong>Schedule Search </strong></em></p>
                  <hr /></td>
                </tr>
              <tr>
                <td width="46"><span class="style1"><strong>From:</strong></span></td>
                <td width="144"><label>
                  <select name="station_from" id="station_from">
                    <?php
do {  
?>
                    <option value="<?php echo $row_stations['id']?>"><?php echo $row_stations['name']?></option>
                    <?php
} while ($row_stations = mysql_fetch_assoc($stations));
  $rows = mysql_num_rows($stations);
  if($rows > 0) {
      mysql_data_seek($stations, 0);
	  $row_stations = mysql_fetch_assoc($stations);
  }
?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td><span class="style1"><strong>To: </strong></span></td>
                <td><label>
                  <select name="station_to" id="station_to">
                    <?php
do {  
?>
                    <option value="<?php echo $row_stations['id']?>"><?php echo $row_stations['name']?></option>
                    <?php
} while ($row_stations = mysql_fetch_assoc($stations));
  $rows = mysql_num_rows($stations);
  if($rows > 0) {
      mysql_data_seek($stations, 0);
	  $row_stations = mysql_fetch_assoc($stations);
  }
?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td><span class="style1"><strong>When:</strong></span></td>
                <td><label>
                  <input name="date" type="text" id="date" onFocus="this.select();lcs(this)" onClick="event.cancelBubble=true;this.select();lcs(this)" value="dd/mm/yy" size="14">
                </label></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><label>
                  <input name="btnsearch" type="submit" id="btnsearch" value="Search">
                </label></td>
              </tr>
            </table>
            </form>
          </fieldset></td>
          <td>&nbsp;</td>
        </tr>
        
        
        <tr>
          <td colspan="2" rowspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
          <td height="24">&nbsp;</td>
        </tr>
        <tr>
          <td height="82">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="6"></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td height="135"></td>
          <td colspan="3" valign="top"><p align="justify" class="style2">Note:</p>            
            <p align="justify">This schedule viewer is only for demonstration. The rail system has only one rail line/route information in the database.           It has two trains that move on the route in opposite directions. The information pertaining to each station is made up. </p></td>
        <td>&nbsp;</td>
          <td></td>
        </tr>
      </table>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($stations);
?>
