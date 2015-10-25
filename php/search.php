<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">

<h4>Search for actors/movies</h4>
<form action="search.php" method="POST">	
<p>
Search: <span style="padding-left: 10px"/> 
		<input type="text" name="name"></input>
		 <span style="padding-left: 10px"/> 
		<input type="submit" name = "submit" value="search" style="position: absolute; width: 60px; height: 1px;"/>
</p>
</form>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db_connection);

if (isset($_POST["submit"]))				
{
	$name = $_POST['name'];
	if (empty($name))
	{
		echo "Please enter a actor/movie's name. <br/>";
	}
	else
	{
		echo "<h4> You are searching [ \"$name\" ]results... </h4>";

		$words = preg_split('/\s+/', trim($name));	// Splits words by spaces
		$length = count($words);

		$nospace = preg_replace('/\s+/', '', $name);
		/* Actor Query */
		echo "<b> Searching match records in Actor database... </b> <br/>";
		if ($length == 1)
		{
			$actor_query = "SELECT id, first, last FROM Actor WHERE first LIKE 
							'%$words[0]%' OR last LIKE '%$words[0]%'";
			$actor_result = mysql_query($actor_query, $db_connection);

			if (!$actor_result)
				echo "Not found. Please try again. <br/>";
			else
			{
				while ($actor_row = mysql_fetch_row($actor_result))
				{
					$aid = $actor_row[0];
					$name = "$actor_row[1] $actor_row[2]";
					echo "<a href='actorInfo.php?aid=$aid'>$name</a> <br/>";	
				}
			}
		}
		else if ($length == 2)
		{
			$actor_query = "SELECT id, first, last FROM Actor WHERE (first LIKE 
							'%$words[0]%' AND last LIKE '%$words[1]%') OR 
							(first LIKE '%$words[1]%' AND last LIKE '%$words[0]%')";
			$actor_result = mysql_query($actor_query, $db_connection);

			if (!$actor_result)
				echo "Not found.Please try again! <br/>";
			else
			{
				while ($actor_row = mysql_fetch_row($actor_result))
				{
					$aid = $actor_row[0];
					$name = "$actor_row[1] $actor_row[2]";
					echo "<a href='actorInfo.php?aid=$aid'>$name</a> <br/>";					
				}
			}
		}
		else
			echo "No names found! <br/>"; 

		/* Movie Query */
		echo "<b> Searching match records in Movie database... </b> <br/>";

		// [[:<:]] - word boundary marker, so it matches on words in different order
		$where = "";
		for ($i = 0; $i < $length; $i++)
		{
			if ($i == 0)
				$where .= "title REGEXP '[[:<:]]$words[$i][[:>:]]'";
			else
				$where .= "AND title REGEXP '[[:<:]]$words[$i][[:>:]]'";
		}

		$where .= "OR title='$nospace'";
		$movie_query = "SELECT id, title, year FROM Movie WHERE $where";
		$movie_result = mysql_query($movie_query, $db_connection);

		if (!$movie_result)
				echo "Nothing found...Please try again! <br/>";
		else
		{
			while ($row = mysql_fetch_row($movie_result))
			{
				$mid = $row[0];
				$title = $row[1];
				$year = $row[2];

				echo "<a href='movieInfo.php?mid=$mid'>" .
				 "$title ($year)</a> <br/>";
			}

		}
	}
}

mysql_close($db_connection);
?>
</div>
</body>
</html><!DOCTYPE html>
