<?php require_once('Connections/dbconnection.php'); ?>
<?php
include("common/date_funcs_inc.php");

$date_right=rightdate($_GET['date']);
 
     
$station_from=$_GET['station_from'];
$station_to=$_GET['station_to'];
//$t=time();  date("H:i",$t);



//  Record sets  to be used in this page
//  GET THE RIGHT ROUTE ON WHICH THE TWO STATIONS ARE FOUND.
mysql_select_db($database_dbconnection, $dbconnection);
$query_Getcommon_line = "Select S.line_id From stationlines S,stationlines E where (S.station_id='$station_from' And E.station_id= '$station_to')AND (S.line_id=E.line_id) AND (S.stop_number < E.stop_number) ";
$Getcommon_line = mysql_query($query_Getcommon_line, $dbconnection) or die(mysql_error());
$row_Getcommon_line = mysql_fetch_assoc($Getcommon_line);
$totalRows_Getcommon_line = mysql_num_rows($Getcommon_line);

$maxRows_spec_Schedule = 10;
$pageNum_spec_Schedule = 0;
if (isset($_GET['pageNum_spec_Schedule'])) {
  $pageNum_spec_Schedule = $_GET['pageNum_spec_Schedule'];
}
$startRow_spec_Schedule = $pageNum_spec_Schedule * $maxRows_spec_Schedule;

$right_line=$row_Getcommon_line['line_id'];

// GET SPECIFIC SCHEDULE FOR THE QUERY, GET THE DEPARTURE TIME AND STATION NAME
 
 
mysql_select_db($database_dbconnection, $dbconnection);
$query_spec_Schedule = "SELECT train_id,name,departure_time FROM departuretimes,railstations WHERE departuretimes.line_id='$right_line' AND railstations.id=departuretimes.station_id AND departuretimes.station_id='$station_from'";

$query_limit_spec_Schedule = sprintf("%s LIMIT %d, %d", $query_spec_Schedule, $startRow_spec_Schedule, $maxRows_spec_Schedule);
$spec_Schedule = mysql_query($query_limit_spec_Schedule, $dbconnection) or die(mysql_error());
$row_spec_Schedule = mysql_fetch_assoc($spec_Schedule);

if (isset($_GET['totalRows_spec_Schedule'])) {
  $totalRows_spec_Schedule = $_GET['totalRows_spec_Schedule'];
} else {
  $all_spec_Schedule = mysql_query($query_spec_Schedule);
  $totalRows_spec_Schedule = mysql_num_rows($all_spec_Schedule);
}
$totalPages_spec_Schedule = ceil($totalRows_spec_Schedule/$maxRows_spec_Schedule)-1;


// GET STATION NAMES 
mysql_select_db($database_dbconnection, $dbconnection);
$query_GetstationName = "Select name from railstations where id='$station_to'";
$GetstationName = mysql_query($query_GetstationName, $dbconnection) or die(mysql_error());
$row_GetstationName = mysql_fetch_assoc($GetstationName);
$totalRows_GetstationName = mysql_num_rows($GetstationName);

mysql_select_db($database_dbconnection, $dbconnection);
$query_GetstationNamefrom = "Select name from railstations where id='$station_from'";
$GetstationNamefrom = mysql_query($query_GetstationNamefrom, $dbconnection) or die(mysql_error());
$row_GetstationNamefrom = mysql_fetch_assoc($GetstationNamefrom);
$totalRows_GetstationNamefrom = mysql_num_rows($GetstationNamefrom);



//GET FINAL DESTINATION OF A LINE 


mysql_select_db($database_dbconnection, $dbconnection);
$query_Getdestination = "SELECT S.name FROM raillines L,railstations S WHERE L.id = '$right_line' AND S.id=L.destination_id";
$Getdestination = mysql_query($query_Getdestination, $dbconnection) or die(mysql_error());
$row_Getdestination = mysql_fetch_assoc($Getdestination);
$totalRows_Getdestination = mysql_num_rows($Getdestination);



// GET DURATION OF THE JOURNEY
$train=$row_spec_Schedule['train_id'];
	// train should be taken into consideration because it could have an impact on the duratio time...there could be faster trains
mysql_select_db($database_dbconnection, $dbconnection);
$query_Getduration = "SELECT TIMEDIFF(E.arrival_time,S.departure_time) as duration,E.departure_time FROM departuretimes S,departuretimes E WHERE S.line_id='$right_line' AND E.line_id = '$right_line' AND S.station_id='$station_from' AND E.station_id='$station_to' AND S.train_id='$train' AND E.train_id='$train'";
$Getduration = mysql_query($query_Getduration, $dbconnection) or die(mysql_error());
$row_Getduration = mysql_fetch_assoc($Getduration);
$totalRows_Getduration = mysql_num_rows($Getduration);


//mysql_free_result($Getcommon_line);

//mysql_free_result($spec_Schedule);

//mysql_free_result($GetstationName);





/////////////////////////////////   Tables to show the search result 

?>





<style type="text/css">
<!--
.style1 {color: #0000CC}
.style2 {
	color: #0000CC;
	font-weight: bold;
	font-size: 16px;
}
.style3 {color: #990000}
.style5 {color: #990000; font-weight: bold; }
-->
</style>
<hr color="#99CCFF" width="100%" />
<table border="0" align="center" cellpadding="4">
<tr>
    <td colspan="5"><div align="Left" class="style2">Babure schedule search&nbsp;&nbsp; :<ul>
          <span class="style3"><?php echo $row_GetstationNamefrom['name']; ?></span> - <span class="style3"><?php echo $row_GetstationName['name']; ?></span>
    </ul></div></td>
  </tr>
<tr>
    <td colspan="5"><div align="Left"><b><font color="#0000CC"><?php echo "For :  ".$date_right;?></font></b></div></td>
  </tr>
  
  <tr>
    <td colspan="5"><div align="center" class="style1">
      <div align="left"><strong>Timetables</strong></div>
    </div></td>
  </tr>
  
  <tr>  
    <td ><div align="left"><strong>Departure</strong></div></td>   
	<td ><div align="left"><strong>Arrival</strong></div></td>
    <td ><div align="left"><strong>Train Id</strong></div></td>
	<td ><div align="left"><strong>Destination</strong></div></td>
	<td ><div align="left"><strong>Buy Ticket</strong></div></td>
  
  </tr>
  <?php do { ?>
    <tr>
      <td><span class="style5"><?php echo $row_spec_Schedule['departure_time']."  ";?></span> <strong>
        <?php  echo $row_spec_Schedule['name']; ?>
      </strong></td>
	  <td><strong><?php echo $row_GetstationName['name']?></strong></td>  
	  <td>Train No. <?php echo $row_spec_Schedule['train_id']; ?></td>
      <td><?php echo $row_Getdestination['name']; ?></td>
	  <td><a href="tickets.php">Tickets</a></td>
    </tr>
	<tr>
    <td colspan="5">Journey Duration : <?php $d=$row_Getduration['duration'];  echo $d;  ?></td>
  </tr>
    <?php } while ($row_spec_Schedule = mysql_fetch_assoc($spec_Schedule)); ?>
</table>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
