<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
<h3>Select Director</h3>
<form action="selDid.php" method="GET">
<p>Name:&nbsp;<input name="s_name" type="text" /> &nbsp; <input name="submit" type="submit" value="Simple Search" />
</form>
<?php
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$m_name = mysql_real_escape_string($_GET["s_name"]);
	if ($m_name == "") {
		echo "<p>Type diretcor's name to start search</p>";
		mysql_close($db_connection);
		return;
	}
	echo "<h3>Result</h3>";
	$query = "SELECT id, first, last, dob FROM Director";
	if ($m_name != "") $query .= " WHERE (first LIKE '%$m_name%' OR last LIKE '%$m_name%')";
	$query.= " ORDER BY last ASC, first ASC;";
	$result = mysql_query($query, $db_connection);
	//echo $result
	$result = mysql_query($query, $db_connection);
	$errmsg = mysql_error($db_connection);
	if (!$result) echo "<span style=\"padding-left:20px\">$errmsg <br/>";
	else {
		if (mysql_num_rows($result) == 0) echo "<span style=\"padding-left:20px\">No search result returned.</br>";
		else while ($row = mysql_fetch_row($result))
			{
				$did = $row[0];
				$first = $row[1];
				$last = $row[2];
				$dob = $row[3];
				echo "<span style=\"padding-left:20px\"><a href='javascript:void(0);' onclick='window.opener.document.form1.director.value=\"$last, $first ($dob)\";window.opener.document.form1.did.value=\"$did\";self.close();'>$last, $first ($dob)</a> </br>";
			}
	}
	mysql_close($db_connection);
?>
</div>
</body>
</html>