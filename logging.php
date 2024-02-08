<?php
		session_start();
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
		$sql = "SELECT * FROM Users;";
		$id = 0;
		$found = false;
		$pwd = false;
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				// output data of each row
				while($row = $result->fetch_assoc())
				{
					if(isset($_POST["username"]) and $_POST["username"] == $row["Username"])
					{
						$id = $row["UserID"];
						$found = true;
						if(isset($_POST["pwd"]) and $found and $_POST["pwd"] == $row["Password"])
						{
							$pwd = true;
						}
						break;
					}
				}
				if($pwd)
				{
					//echo "Succesfully logged in";
					$_SESSION['user'] = $id;
					//echo "id = $id a Session User = " . $_SESSION['user'];
					//$_SESSION["time"] = time();
					echo "<script>window.open('preflist.php', '_self');</script>";
				}
				else
				{
					echo "Wrong username of password";
				}
			}
			else
			{
				echo "Connection Error";
			}
		
		
		$conn->close();
?>
