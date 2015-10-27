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
  <h2>Add new comment</h2>
  <form action="addComments.php" method="GET" name="form1">
  <table width="50%"  cellpadding="0" cellspacing="0">
    <tr>
      <td width="30%" valign="top"><h4>Movie</h4></td>
      <td width="*" valign="top"><input name="movie" type="text" readonly="readonly"  value="<?php print $_GET['movie'];?>"/><span style="padding-left:10px"/><a href="javascript:void(0);" name="frmSelectMovie" title="Select Movie" onclick="selectMid();">Select Movie</a></td>
    </tr>
    <tr>
      <td width="30%" valign="top"><h4>Your Name</h4></td>
      <td valign="top"><input type="text" name="name" value="<?php print $_GET['name'];?>"></td>
    </tr>
    <tr>
      <td width="30%" valign="top"><h4>Rating</h4></td>
      <td  valign="top"><select name="rate" id="rate" >
        <option value="5" <?php if ($_GET["rate"] == 5) echo "selected=\"selected\""?> >5 - Excellent</option>
        <option value="4" <?php if ($_GET["rate"] == 4) echo "selected=\"selected\""?>>4 - Good</option>
        <option value="3" <?php if ($_GET["rate"] == 3) echo "selected=\"selected\""?>>3 - Fair</option>
        <option value="2" <?php if ($_GET["rate"] == 2) echo "selected=\"selected\""?>>2 - Poor</option>
        <option value="1" <?php if ($_GET["rate"] == 1) echo "selected=\"selected\""?>>1 - Bad</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">
        <h4>Comment</h4>
      </td>
    </tr>
        <tr>
      <td colspan="2">
        <p><textarea name="comment" cols="100" rows="" max></textarea></p>
      </td>
    </tr>
    </table>
  <input name="mid" type="hidden" value="<?php print $_GET['mid'];?>"/>
  <p><input name="submit" type="submit" value="Submit"/></p>
  </form>
  <p>
<?php
	if (($_GET['mid'] == 0 || $_GET['comment'] == "")) 
	{
		echo "Please select Movie and fill up the comments.";
		return;
	}
	$mid = $_GET['mid'];
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$rate = $_GET["rate"];
	$name = mysql_real_escape_string($_GET["name"]);
	$comment = mysql_real_escape_string($_GET["comment"]);
	$query = "INSERT INTO Review VALUES (\"$name\", NULL, $mid, $rate, \"$comment\");";
	$result = mysql_query($query, $db_connection);
	$errmsg = mysql_error($db_connection);
	if (!$result)
    { 
		print "Failed : $errmsg";
	}
	else
	{
		print "Comment added.<br/>";
	}
	mysql_close($db_connection);
?>
</p>
</div>
</body>
</html>