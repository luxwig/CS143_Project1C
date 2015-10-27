<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
<h3>Select Movie</h3>
<form action="selMid.php" method="GET">
<p>Title:&nbsp;
  <input name="s_name" type="text" /> &nbsp; <input name="submit" type="submit" value="Simple Search" />
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
		echo "<p>Type movie's name to start search</p>";
		mysql_close($db_connection);
		return;
	}
	echo "<h3>Result</h3>";
	$query = "SELECT id, title, year FROM Movie";
	if ($m_name != "") $query .= " WHERE title LIKE '%$m_name%'";
	$query.=" ORDER BY title;";
	$result = mysql_query($query, $db_connection);
	$result = mysql_query($query, $db_connection);
	$errmsg = mysql_error($db_connection);
	if (!$result) echo "<span style=\"padding-left:20px\">$errmsg <br/>";
	else {
		if (mysql_num_rows($result) == 0) echo "<span style=\"padding-left:20px\">No search result returned.</br>";
		else while ($row = mysql_fetch_row($result))
			{
				$mid = $row[0];
				$title = $row[1];
				$year = $row[2];
				echo "<span style=\"padding-left:20px\"><a href='javascript:void(0);' onclick='window.opener.document.form1.movie.value=\"$title\";window.opener.document.form1.mid.value=\"$mid\";self.close();'>$title ($year)</a><br/>";
			}
	}
	mysql_close($db_connection);
?>
</div>
</body>
</html>