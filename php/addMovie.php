<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
	<h2>Add new movie</h2>
  <form action="addMovie.php" method="GET">
      <table width="50%"  cellpadding="0" >
        <tr>
          <td width="30%" valign="top"><h4>Title</h4></td>
          <td width="*" valign="top"><input type="text" name="title" value="<?php print $_GET['title']; ?>">
          </td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Company</h4></td>
        <td valign="top"><input type="text" name="company" value="<?php print $_GET['company']; ?>"></td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Year</h4></td>
        <td  valign="top"><input type="text" name="year"onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php print $_GET['year']; ?>"></td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>MPAA Rating</h4></td>
        <td valign="top"><select name="rating" style="width: 150px">
					<option value="G" <?php if ($_GET['rating'] == 'G') print 'selected = "selected"'; ?>>G</option>
<option value="NC-17" <?php if ($_GET['rating'] == 'NC-17') print 'selected = "selected"'; ?>>NC-17</option>
<option value="PG" <?php if ($_GET['rating'] == 'PG') print 'selected = "selected"'; ?>>PG</option>
<option value="PG-13" <?php if ($_GET['rating'] == 'PG-13') print 'selected = "selected"'; ?>>PG-13</option>
<option value="R" <?php if ($_GET['rating'] == 'R') print 'selected = "selected"'; ?>>R</option>
					</select></td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Genre</h4></td>
        <td  valign="top"><select name="genre[]" size="8" multiple="multiple" style="width:150px">
        <option   value="Adult">Adult</option>
<option   value="Adventure">Adventure</option>
<option   value="Animation">Animation</option>
<option   value="Comedy">Comedy</option>
<option   value="Crime">Crime</option>
<option   value="Documentary">Documentary</option>
<option   value="Drama">Drama</option>
<option   value="Family">Family</option>
<option   value="Fantasy">Fantasy</option>
<option   value="Horror">Horror</option>
<option   value="Musical">Musical</option>
<option   value="Mystery">Mystery</option>
<option   value="Romance">Romance</option>
<option   value="Sci-Fi">Sci-Fi</option>
<option   value="Short">Short</option>
<option   value="Thriller">Thriller</option>
<option   value="War">War</option>
<option   value="Western">Western</option>
        </select></td>
        </tr>
        <tr>

      </table>
      <p><input name="submit" type="submit" value="Submit" /></p>
      <br/>
    </form>
    <p style="color:#F00; font:bolder; font-style:italic;">
<?php
	$success = false;
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$query = "";
	$id = mysql_query("SELECT * FROM MaxMovieID;", $db_connection);
    if (!$id) {
		$errmsg = mysql_error($db_connection);
		print "Failed : $errmsg<br/>";
	}
	else { 
		$id = mysql_fetch_row($id); $id = $id[0] + 1;
		$title = mysql_real_escape_string($_GET["title"]);
		$year = $_GET["year"];
		$rating = mysql_real_escape_string($_GET["rating"]);
		$company = mysql_real_escape_string($_GET["company"]);
		if (($title || $year || $company) == 0) {mysql_close($db_connection); return;}
		$query="INSERT INTO Movie VALUES (\"$id\", \"$title\", \"$year\", \"$rating\", \"$company\");";
		if (!mysql_query($query, $db_connection)) {
			$errmsg = mysql_error($db_connection);
			echo "Failed : $errmsg<br/>";
		}
		else
		{
			echo "Movie Added<br/>";
			$success = true;
		}
	}
	
	if (count($_GET['genre']) != 0)
	foreach ($_GET['genre'] as $selectedOption)
	{
		$query = "INSERT INTO MovieGenre VALUES ($id, \"$selectedOption\");";
		if (!mysql_query($query, $db_connection)) {
			$errmsg = mysql_error($db_connection);
			echo "Failed : $errmsg<br/>";
			$success &= false;
		}
		else
		{
			$success &= true;
			echo "Genre $selectedOption Added<br/>";
		}
	}
	mysql_close($db_connection);
	if ($success)
	{
		echo "<p><a href = \"addMARelation.php?mid=$id&movie=$title\">Add Actor/Role Relation</a></p>";
	}
?>
</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
</body>
</html>