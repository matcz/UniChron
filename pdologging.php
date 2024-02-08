<?php
include("headerdiv.php");
// Nastavení připojení
$servername = 'localhost';
$username = 'mazzaf';
$password = 'KraKEN-28.12.1998';
$dbname = "mazzaf";

try
{
	// Vytvoření PDO připojení
	$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Kontrola, zda byly odeslány formulářové data
	if(isset($_POST["username"]) && isset($_POST["pwd"]))
	{
		$username = $_POST["username"];
		$password = $_POST["pwd"];

		// Příprava a spuštění SQL dotazu
		$stmt = $pdo->prepare("SELECT UserID, Password FROM Users WHERE Username = :username");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0)
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// Ověření hesla
			if(password_verify($password, $row["Password"]))
			{
				// Heslo je správné, uživatel je úspěšně ověřen
				$_SESSION['user'] = $row["UserID"];
				echo "<script>window.open('preflist.php', '_self');</script>";
			}
			else
			{
				// Heslo je nesprávné
				echo "Wrong username or password";
			}
		}
		else
		{
			// Uživatelské jméno není v databázi
			echo "Wrong username or password";
		}
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

// Zavření připojení
$pdo = null;
?>
