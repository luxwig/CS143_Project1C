<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db_connection);

/* Max possible Actor ID */
$lookup_query = "SELECT id FROM MaxPersonID";
$lookup_result = mysql_fetch_row(mysql_query($lookup_query, $db_connection));
$max = $lookup_result[0] - 1;

/* If a valid Actor ID was passed in from URL */
if (isset($_GET['aid']))
{
	$id = $_GET['aid'];
	//echo "ID: $id <br/>"; 			
	$id_query = "SELECT * FROM Actor WHERE id=$id";
	$result = mysql_query($id_query, $db_connection);
}
else
{
	/* Generate a random valid Actor ID */
	do {
		$id = mt_rand(1, $max);
		// echo "ID: $id <br/>";						
		$id_query = "SELECT * FROM Actor WHERE id=$id";
		$result = mysql_query($id_query, $db_connection);
	} while (mysql_num_rows($result) == 0);
}

$nfield = mysql_num_fields($result);
$rows = mysql_fetch_row($result);

echo "<h4> --Show Actor Info-- </h4>";

echo "Name: $rows[2] $rows[1]<br/>";

for ($i = 3; $i < $nfield; $i++)
{
	if ($i == 5)
	{
		echo ucfirst(mysql_field_name($result, $i)) . ": --Still Alive-- <br/>";
	}
	else
	{
		echo ucfirst(mysql_field_name($result, $i)) . ": " . $rows[$i] . "<br/>";	
	}
}
echo "<br>-- Act in --<br/>";
$movie_query = "SELECT * FROM MovieActor WHERE aid=$id";
$movie_result = mysql_query($film_query, $db_connection);

if (mysql_num_rows($film_result) == 0)
{
	if ($rows[3] == "Male")
		echo "Aspiring Actor<br/>"; 
	else
		echo "Aspiring Actress<br/>";
}
else
{
	while ($row = mysql_fetch_row($film_result))
	{
		$mid = $row[0];
		$role = $row[2];

		$movie_query = "SELECT title FROM Movie WHERE id=$mid";
		$movie_result = mysql_fetch_row(mysql_query($title_query, $db_connection));
		$movie = $movie_result[0];

		echo "Act \"$role\" in ";
		echo "<a href='movieInfo.php?mid=$mid'>" .
			 "$movie</a> <br/>";
	}
}

mysql_close($db_connection);
echo "<br/>";
include 'search.php';

?>

<a href='index.php'>Go Home</a></br>
</div>
</body>
</html>