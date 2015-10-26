<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
	<h2>Add new actor / director</h2>
    <form action="addActorDirector.php" method="GET">
      <table width="50%"  cellpadding="0" cellspacing="0">
        <tr>
          <td width="30%" valign="top"><h4>Identity</h4></td>
          <td width="*" valign="top">
            <label>
              <input type="checkbox" name="actor" value="1" id="identity_0" />
              Actor</label>
              <span style="padding-left:40px"/>
            <label>
              <input type="checkbox" name="director" value="1" id="identity_1" />
              Director</label>
            <br />
          </td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>First Name</h4></td>
        <td valign="top"><input type="text" name="first"></td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Last Name</h4></td>
        <td  valign="top"><input type="text" name="last"></td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Sex</h4></td>
        <td valign="top">
          <label>
            <input type="radio" name="sex" value="male" id="sex_0" />
            male</label>
          <span style="padding-left:40px"/>
          <label>
            <input type="radio" name="sex" value="female" id="sex_1" />
            female</label>
          
        </td>
        </tr>
        <tr>
        <td width="30%" valign="top"><h4>Date of Birth</h4></td>
        <td  valign="top"><input type="text" name="dob"></td>
        </tr>
        <tr>
        	<td width="30%" valign="top"><h4>Date of Death</h4></td>
        	<td><input type="text" name="dod"><span style="padding-left:40px"/>
            <br/>
            (Leave it blank if it is not applicatble)</td>
            
        </tr>
      </table>
      <p><input name="submit" type="submit" value="Submit" /></p>
    </form>
    <p style="color:#F00; font:bolder; font-style:italic;">
    <?php
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br>";
		mysql_close($db_connection);
    	exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$identity = ($_GET["actor"] << 1) + $_GET["director"];
	$first = mysql_real_escape_string($_GET["first"]);
	$last = mysql_real_escape_string($_GET["last"]);
	$dob = mysql_real_escape_string($_GET["dob"]);
	$dod = mysql_real_escape_string($_GET["dod"]);
	$sex = mysql_real_escape_string($_GET["sex"]);
		$query = "";
		$id = 0;
		if ($identity & 0x1)
		{
			$id = mysql_query("SELECT * FROM MaxPersonID;", $db_connection);
        	$errmsg = mysql_error($db_connection);
        	if (!$id)
                print "Failed : $errmsg";
        	else {
				$id = mysql_fetch_row($id); $id = $id[0] + 1;
				$query="INSERT INTO Director VALUES (".$id.",\"".
													$first."\",\"".
													$last."\",\"".
													$dob."\",\"".
													$dod."\")";
				$result = mysql_query($query, $db_connection);
				$errmsg = mysql_error($db_connection);
				if (!$result)
                { 
					print "Failed : $errmsg";
				}
				else
				{
					print "Director added.<br/>";
				}
			};
		};
		
		if ($identity & 0x2)
		{
			if ($identity != 3) 
			{
				$id = mysql_query("SELECT * FROM MaxPersonID;", $db_connection);
        		$numField = mysql_num_fields($id);
        		$errmsg = mysql_error($db_connection);
        		if (!$id)
				{
            	    print "Failed : $errmsg"; mysql_close($db_connection); return;
				}
				$id = mysql_fetch_row($id); $id = $id[0] + 1;
			}
				$query="INSERT INTO Actor VALUES (".$id.",\"".
													$first."\",\"".
													$last."\",\"".
													$sex."\",\"".
													$dob."\",\"".
													$dod."\")";
				$result = mysql_query($query, $db_connection);
				$errmsg = mysql_error($db_connection);
				if (!$result)
                { 
					print "Failed : $errmsg";
				}
				else
				{
					print "Actor added.<br/>";
				}
		};
		if ($identity == 0x3){
			$result = mysql_query("UPDATE MaxPersonID SET id = id - 1", $db_connection);
		}
	mysql_close($db_connection);
?>
</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
</div>



</body>
</html>
