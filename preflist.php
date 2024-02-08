<?php
	include("headerdiv.php");
	$servername = 'localhost';
	$username = 'mazzaf';
	$password = 'KraKEN-28.12.1998';
	$dbname = "mazzaf";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn -> query("set names utf8");
	// Check connection
	if ($conn->connect_error)
	{
		die('Connection failed: ' . $conn->connect_error);
	}
	$sql = "SELECT * FROM Preferences;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		// output data of each row
		while($row = $result->fetch_assoc())
		{
			if($_SESSION["user"] == $row["UserID"])
			{
				//echo "<a href='" . $row['Link'] . "'>" . $row['Link'] . "</a>";
				echo "<button onclick=\"window.open('" . $row['Link'] . "', '_self');\">" . $row["PreferenceName"] . "</button>";
				//echo $row['Link'];
			}
		}
	}
	else
	{
		echo "<script>window.open('index.php', '_self');</script>";
	}
	//echo $_SESSION["user"];
	$conn->close();
?>
