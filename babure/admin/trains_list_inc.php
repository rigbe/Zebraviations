
<?php require_once('../Connections/dbconnection.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

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
  $insertSQL = sprintf("INSERT INTO trains (id, line_id, depart_origin_time) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['line_id'], "int"),
                       GetSQLValueString($_POST['depart_origin_time'], "date"));

  mysql_select_db($database_dbconnection, $dbconnection);
  $Result1 = mysql_query($insertSQL, $dbconnection) or die(mysql_error());

  $insertGoTo = "administrator.php?link=trains";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Trainlist = 10;
$pageNum_Trainlist = 0;
if (isset($_GET['pageNum_Trainlist'])) {
  $pageNum_Trainlist = $_GET['pageNum_Trainlist'];
}
$startRow_Trainlist = $pageNum_Trainlist * $maxRows_Trainlist;

mysql_select_db($database_dbconnection, $dbconnection);
$query_Trainlist = "SELECT * FROM trains ORDER BY id ASC";
$query_limit_Trainlist = sprintf("%s LIMIT %d, %d", $query_Trainlist, $startRow_Trainlist, $maxRows_Trainlist);
$Trainlist = mysql_query($query_limit_Trainlist, $dbconnection) or die(mysql_error());
$row_Trainlist = mysql_fetch_assoc($Trainlist);

if (isset($_GET['totalRows_Trainlist'])) {
  $totalRows_Trainlist = $_GET['totalRows_Trainlist'];
} else {
  $all_Trainlist = mysql_query($query_Trainlist);
  $totalRows_Trainlist = mysql_num_rows($all_Trainlist);
}
$totalPages_Trainlist = ceil($totalRows_Trainlist/$maxRows_Trainlist)-1;

mysql_select_db($database_dbconnection, $dbconnection);
$query_Linelist = "SELECT * FROM raillines ORDER BY id ASC";
$Linelist = mysql_query($query_Linelist, $dbconnection) or die(mysql_error());
$row_Linelist = mysql_fetch_assoc($Linelist);
$totalRows_Linelist = mysql_num_rows($Linelist);

mysql_select_db($database_dbconnection, $dbconnection);
$query_traincount = "SELECT count(*)+1 as nxt FROM trains";
$traincount = mysql_query($query_traincount, $dbconnection) or die(mysql_error());
$row_traincount = mysql_fetch_assoc($traincount);
$totalRows_traincount = mysql_num_rows($traincount);

$queryString_Trainlist = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Trainlist") == false && 
        stristr($param, "totalRows_Trainlist") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Trainlist = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Trainlist = sprintf("&totalRows_Trainlist=%d%s", $totalRows_Trainlist, $queryString_Trainlist);


?><script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<hr>
<p>&nbsp;</p>
<table width="580" border="0" cellpadding="5" cellspacing="2">
<tr bgcolor="#CCCCCC">
    <td colspan="3"><strong>List of Trains </strong></td>
  </tr>
  <tr>
    <td width="103"><strong>Train Id</strong></td>
    <td width="127"><strong>Line (route) Id</strong></td>
    <td width="312"><strong>Departure time from Origin station</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Trainlist['id']; ?></td>
      <td><div align="center"><?php echo $row_Trainlist['line_id']; ?></div></td>
      <td><div align="center"><?php echo $row_Trainlist['depart_origin_time']; ?></div></td>
    </tr>
    <?php } while ($row_Trainlist = mysql_fetch_assoc($Trainlist)); ?>
</table>
<p>&nbsp;</p>
<p>
<table border="0" width="23%" align="left">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_Trainlist > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Trainlist=%d%s", $currentPage, 0, $queryString_Trainlist); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_Trainlist > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Trainlist=%d%s", $currentPage, max(0, $pageNum_Trainlist - 1), $queryString_Trainlist); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Trainlist < $totalPages_Trainlist) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Trainlist=%d%s", $currentPage, min($totalPages_Trainlist, $pageNum_Trainlist + 1), $queryString_Trainlist); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Trainlist < $totalPages_Trainlist) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Trainlist=%d%s", $currentPage, $totalPages_Trainlist, $queryString_Trainlist); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Add new train:</strong></p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('depart_origin_time','','RisNum');return document.MM_returnValue">
  <table align="left" bgcolor="#9999FF">
    <tr valign="baseline">
      <td nowrap align="right">Id:</td>
      <td><input type="text" name="id" value="<?php echo $row_traincount['nxt']; ?>" size="32" disabled="disabled"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Line_id:</td>
      <td><select name="line_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_Linelist['id']?>" ><?php echo $row_Linelist['name']?></option>
        <?php
} while ($row_Linelist = mysql_fetch_assoc($Linelist));
?>
      </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Departure time from origin:</td>
      <td><input type="text" name="depart_origin_time" value="" size="10">
        <em>(      hh:mm)</em></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>

