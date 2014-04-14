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
  $insertSQL = sprintf("INSERT INTO railstations (id, name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_dbconnection, $dbconnection);
  $Result1 = mysql_query($insertSQL, $dbconnection) or die(mysql_error());

  $insertGoTo = "administration.php?link=stations";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

//  RECORDSET THAT LISTS ALL STATIONS 

$maxRows_Stationlist = 10;
$pageNum_Stationlist = 0;
if (isset($_GET['pageNum_Stationlist'])) {
  $pageNum_Stationlist = $_GET['pageNum_Stationlist'];
}
$startRow_Stationlist = $pageNum_Stationlist * $maxRows_Stationlist;

mysql_select_db($database_dbconnection, $dbconnection);
$query_Stationlist = "SELECT * FROM railstations ORDER BY id ASC";
$query_limit_Stationlist = sprintf("%s LIMIT %d, %d", $query_Stationlist, $startRow_Stationlist, $maxRows_Stationlist);
$Stationlist = mysql_query($query_limit_Stationlist, $dbconnection) or die(mysql_error());
$row_Stationlist = mysql_fetch_assoc($Stationlist);

if (isset($_GET['totalRows_Stationlist'])) {
  $totalRows_Stationlist = $_GET['totalRows_Stationlist'];
} else {
  $all_Stationlist = mysql_query($query_Stationlist);
  $totalRows_Stationlist = mysql_num_rows($all_Stationlist);
}
$totalPages_Stationlist = ceil($totalRows_Stationlist/$maxRows_Stationlist)-1;

$queryString_Stationlist = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Stationlist") == false && 
        stristr($param, "totalRows_Stationlist") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Stationlist = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Stationlist = sprintf("&totalRows_Stationlist=%d%s", $totalRows_Stationlist, $queryString_Stationlist);

//mysql_free_result($Stationlist);
?>
<hr>
<p>&nbsp;</p>
<table width="30%" border="0">
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><strong>List Of Stations </strong></td>
  </tr>
  <tr>
    <td><strong>Station Id</strong></td>
    <td><strong>Station Name</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Stationlist['id']; ?></td>
      <td><?php echo $row_Stationlist['name']; ?></td>
    </tr>
    <?php } while ($row_Stationlist = mysql_fetch_assoc($Stationlist)); ?>
</table>
<hr align="left" width="30%">
<p> 
<table border="0" width="18%" align="left">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_Stationlist > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Stationlist=%d%s", $currentPage, 0, $queryString_Stationlist); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_Stationlist > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Stationlist=%d%s", $currentPage, max(0, $pageNum_Stationlist - 1), $queryString_Stationlist); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Stationlist < $totalPages_Stationlist) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Stationlist=%d%s", $currentPage, min($totalPages_Stationlist, $pageNum_Stationlist + 1), $queryString_Stationlist); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_Stationlist < $totalPages_Stationlist) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Stationlist=%d%s", $currentPage, $totalPages_Stationlist, $queryString_Stationlist); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Add new station:</strong></p>

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="left" bgcolor="#9999FF">
       
        <tr valign="baseline">
          <td nowrap align="right">Name:</td>
          <td><input type="text" name="name" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insert Station"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
