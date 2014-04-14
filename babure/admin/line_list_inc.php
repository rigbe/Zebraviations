<?php
session_start(); 

if( !session_is_registered("properuser") )
    header ("Location: index.php?ermsg=You are not logged in,You have to first log in !");
	
else

{

// checking for session


?>
<?php require_once('../Connections/dbconnection.php'); ?>
<?php
 // THIS PAGE LISTS ALL RAIL LINES (ROUTES) IN AN EDITABLE FORMAT. 
 //IT ALLOWS ADDITION,DELETION,EDITIION OF RAIL LINES
 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO raillines (id, name, origin_id, destination_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['origin_id'], "int"),
                       GetSQLValueString($_POST['destination_id'], "int"));

  mysql_select_db($database_dbconnection, $dbconnection);
  $Result1 = mysql_query($insertSQL, $dbconnection) or die(mysql_error());

  $insertGoTo = "administration.php?link=line";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO raillines (id, name, origin_id, destination_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['origin_id'], "int"),
                       GetSQLValueString($_POST['destination_id'], "int"));

  mysql_select_db($database_dbconnection, $dbconnection);
  $Result1 = mysql_query($insertSQL, $dbconnection) or die(mysql_error());

  $insertGoTo = "administrator.php?link=line";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}






$maxRows_Linelist = 10;
$pageNum_Linelist = 0;
if (isset($_GET['pageNum_Linelist'])) {
  $pageNum_Linelist = $_GET['pageNum_Linelist'];
}
$startRow_Linelist = $pageNum_Linelist * $maxRows_Linelist;

mysql_select_db($database_dbconnection, $dbconnection);
$query_Linelist = "SELECT L.id,L.name as route,S.name as origin,E.name as destination FROM raillines L,railstations S,railstations E WHERE L.origin_id=S.id AND L.destination_id = E.id ORDER BY L.id ASC";
$query_limit_Linelist = sprintf("%s LIMIT %d, %d", $query_Linelist, $startRow_Linelist, $maxRows_Linelist);
$Linelist = mysql_query($query_limit_Linelist, $dbconnection) or die(mysql_error());
$row_Linelist = mysql_fetch_assoc($Linelist);

if (isset($_GET['totalRows_Linelist'])) {
  $totalRows_Linelist = $_GET['totalRows_Linelist'];
} else {
  $all_Linelist = mysql_query($query_Linelist);
  $totalRows_Linelist = mysql_num_rows($all_Linelist);
}
$totalPages_Linelist = ceil($totalRows_Linelist/$maxRows_Linelist)-1;

mysql_select_db($database_dbconnection, $dbconnection);
$query_stationlist = "SELECT * FROM railstations ORDER BY name ASC";
$stationlist = mysql_query($query_stationlist, $dbconnection) or die(mysql_error());
$row_stationlist = mysql_fetch_assoc($stationlist);
$totalRows_stationlist = mysql_num_rows($stationlist);

?>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:899px;
	top:131px;
	width:908px;
	height:209px;
	z-index:1;
	visibility: visible;
}
-->
</style>




<div id="Layer1">
  <table width="100%" height="212" border="0">
  <tr>
      <td height="63">&nbsp;</td>
    </tr>
  
  
    <tr>
      <td height="59">
	  <?php
	  $action=$_REQUEST['type'];
	  $line_id=$_REQUEST['line_id'];
	   if(!empty($action))
	   {
	       if($action=='detail')
		     echo "Details will be available here !";
		   if($action=='edit')
		     echo $_SESSION['line_id'];
		   if($action=='delete')
		     echo "Deletion will be available here !";
	    }	  
	  
	  
	  
	  
	  ?>	  </td>
    </tr>
    <tr>
      <td height="82">&nbsp;</td>
    </tr>
  </table>
</div>
<hr>
<p>&nbsp;</p>
<table border="0" cellpadding="5" cellspacing="2">
<tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>Babure Rail lines (Routes) </strong></td>
  </tr>
  <tr>
    <td width="78"><strong>Line id</strong></td>
    <td width="101"><strong>Line name</strong></td>
    <td width="101"><strong>Origin station</strong></td>
    <td width="134"><strong>Destination station</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><strong><?php echo $row_Linelist['id']; ?></strong></td>
      <td><strong><?php echo $row_Linelist['route']; ?></strong></td>
      <td><div align="center"><em><?php echo $row_Linelist['origin']; ?></em></div></td>
      <td><div align="center"><em><?php echo $row_Linelist['destination']; ?></em></div></td>
	   <td width="48"><em><a href="administration.php?link=line&type=detail&line_id=<?php echo $row_Linelist['id'];?>">Detail</a></em></td>
	   <td width="35"><em><a href="administration.php?link=line&type=edit&line_id=<?php echo $row_Linelist['id'];?>">Edit</a></em></td>
	    <td width="35"><em><a href="administration.php?link=line&type=delete&line_id=<?php echo $row_Linelist['id'];?>">Delete</a></em></td>
    </tr>
    <?php } while ($row_Linelist = mysql_fetch_assoc($Linelist)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Add new station:</strong></p>
<p>&nbsp;</p>

    
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="left" bgcolor="#9999CC">
        
        <tr valign="baseline">
          <td nowrap align="right">Line Name:</td>
          <td><input type="text" name="name" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Origin Station:</td>
          <td><select name="origin_id">
              <?php 
do {  
?>
              <option value="<?php echo $row_stationlist['id']?>" ><?php echo $row_stationlist['name']?></option>
              <?php
} while ($row_stationlist = mysql_fetch_assoc($stationlist));
?>
            </select>
          </td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Destination Station:</td>
          <td><select name="destination_id">
              <?php
// CONNECTING TO THE DATABASE AGAIN TO RETRIEVE THE PREVIOUS RECORDSET AGAIN......NOT SO CLEVER :)			  
mysql_select_db($database_dbconnection, $dbconnection);
$query_stationlist = "SELECT * FROM railstations ORDER BY name ASC";
$stationlist = mysql_query($query_stationlist, $dbconnection) or die(mysql_error());
$row_stationlist = mysql_fetch_assoc($stationlist);
$totalRows_stationlist = mysql_num_rows($stationlist); 
do { 

?>
              <option value="<?php echo $row_stationlist['id']?>" ><?php echo $row_stationlist['name']?></option>
              <?php
} while ($row_stationlist = mysql_fetch_assoc($stationlist));
?>
            </select>
          </td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php

?>




<?php

}

?>