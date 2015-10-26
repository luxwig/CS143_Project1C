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
	function selectAid()
	{
		window.open("selAid.php", "_blank", "width=500,height=300,left=150,top=200,toolbar=0,status=0");
	}
</script>
</head>
<body>
<div class="container">
  <h2>Add new actor in a movie</h2>
  <form action="addMARelation.php" method="GET" name="form1">
  <table width="50%"  cellpadding="0" cellspacing="0">
    <tr>
      <td width="30%" valign="top"><h4>Movie</h4></td>
      <td width="*" valign="top"><input name="movie" type="text" readonly="readonly"  value="<?php print $_GET['movie'];?>"/><span style="padding-left:10px"/><a href="javascript:void(0);" name="frmSelectMovie" title="Select Movie" onclick="selectMid();">Select Movie</a></td>
    </tr>
    <tr>
      <td width="30%" valign="top"><h4>Actor</h4></td>
      <td valign="top"><input type="text" name="actor" readonly="readonly"/ value="<?php print $_GET['actor'];?>"><span style="padding-left:10px"/><a href="javascript:void(0);" name="frmSelectActor" title="Select Actor" onclick="selectAid();">Select Actor</a></td>
    </tr>
    <tr>
      <td width="30%" valign="top"><h4>Role</h4></td>
      <td  valign="top"><input type="text" name="role" value="<?php print $_GET['role'];?>"/></td>
    </tr>
  </table>
  <input name="aid" type="hidden" value="<?php print $_GET['aid'];?>"/>
  <input name="mid" type="hidden" value="<?php print $_GET['mid'];?>"/>
  <p><input name="submit" type="submit" value="Submit"/></p>
  </form>
  <p>
<?php
	if (($_GET['aid'] == 0 || $_GET['mid'] == 0 || $_GET['role'] == "")) 
	{
		echo "Please select Actor, Movie and Role.";
		return;
	}
	$aid = $_GET['aid']; $mid = $_GET['mid'];
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$role = mysql_real_escape_string($_GET["role"]);
	$query = "INSERT INTO MovieActor VALUES ($mid, $aid, \"$role\");";
	$result = mysql_query($query, $db_connection);
	$errmsg = mysql_error($db_connection);
	if (!$result)
    { 
		print "Failed : $errmsg";
	}
	else
	{
		print "Movie Actor Relation added.<br/>";
	}
	mysql_close($db_connection);
?>
</p>
</div>
</body>
</html>