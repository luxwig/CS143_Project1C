<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function selectMid()
	{
		window.open("selMid.php", "_blank", "width=500,height=300,left=150,top=200,toolbar=0,status=0");
	}
	function selectDid()
	{
		window.open("selDid.php", "_blank", "width=500,height=300,left=150,top=200,toolbar=0,status=0");
	}
</script>
</head>
<body>
<div class="container">
  <h2>Add new director in a movie</h2>
  <form action="addMDRelation.php" method="GET" name="form1">
  <table width="50%"  cellpadding="0" cellspacing="0">
    <tr>
      <td width="30%" valign="top"><h4>Movie</h4></td>
      <td width="*" valign="top"><input name="movie" type="text" readonly="readonly"  value="<?php print $_GET['movie'];?>"/><span style="padding-left:10px"/><a href="javascript:void(0);" name="frmSelectMovie" title="Select Movie" onclick="selectMid();">Select Movie</a></td>
    </tr>
    <tr>
      <td width="30%" valign="top"><h4>Director</h4></td>
      <td valign="top"><input type="text" name="director" readonly="readonly"/ value="<?php print $_GET['director'];?>"><span style="padding-left:10px"/><a href="javascript:void(0);" name="frmSelectDirector" title="Select Director" onclick="selectDid();">Select Diretcor</a></td>
    </tr>
  </table>
  <input name="did" type="hidden" value="<?php print $_GET['did'];?>"/>
  <input name="mid" type="hidden" value="<?php print $_GET['mid'];?>"/>
  <p><input name="submit" type="submit" value="Submit"/></p>
  </form>
  <p>
<?php
	if (($_GET['did'] == 0 || $_GET['mid'] == 0)) 
	{
		echo "Please select Director and Movie.";
		return;
	}
	$did = $_GET['did']; $mid = $_GET['mid'];
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$role = mysql_real_escape_string($_GET["role"]);
	$query = "INSERT INTO MovieDirector VALUES ($mid, $did);";
	$result = mysql_query($query, $db_connection);
	$errmsg = mysql_error($db_connection);
	if (!$result)
    { 
		print "Failed : $errmsg";
	}
	else
	{
		print "Movie Diretcor Relation added.<br/>";
	}
	mysql_close($db_connection);
?>
</p>
</div>
</body>
</html>