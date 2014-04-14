
<html>
<head>
<title>BABURE - administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../common/style2.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">
function getFocus() {
  // focuses the cursor on the username textbox
  var focusHere = document.getElementById("userid");
  focusHere = focusHere.focus();
}
</script>
<body onLoad="getFocus()">
<table width="80%" border="0" cellpadding="6" cellspacing="8" align="center"  >
  <!--DWLayoutTable-->
  <tr> 
    <td valign="top" bgcolor="#FFFFFF" class="vertical">

      <form action="adminpicker.php" method="post" name="Baburelogin" id="Baburelogin">
        <table width="50%" height="226" border="0" align="center" cellpadding="4" cellspacing="4" bordercolor="#CCCCCC" bgcolor="#CCCCCC">
          <tr bgcolor="#495e83"> 
            <td height="26" colspan="4"><font color="#FFFFFF">Babure Login </font></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="4"><hr color="#990033"></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td width="28%">User Name:</td>
            <td colspan="3"><input name="userid" type="text" id="userid"></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td height="32">Password:</td>
            <td colspan="3"><input name="password" type="password" id="password"></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td height="28" colspan="4"><hr align="center"></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td>&nbsp;</td>
            <td width="8%">&nbsp;</td>
            <td width="45%"><input type="submit" name="Submit" value="Log In"></td>
            <td width="19%">&nbsp;</td>
          </tr>
        </table>
        <hr>
        <table width="89%" border="0" align="center">
          <tr>
            <td height="23"><?php $ermsg=$_REQUEST['ermsg'];echo '<p><h5><font color="#FF0000" face="Arial Narrow"><center>'.$ermsg.'</centrer></font></h4> </font>';?>
&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </form>
    
      <p>&nbsp;</p>
      <p>&nbsp; </p>    
      <p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>      <p>&nbsp;</p></td>
  </tr>
</table>



