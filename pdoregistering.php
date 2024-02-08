<?php
session_start();
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
		$newUsername = $_POST["username"];
		$newPassword = $_POST["pwd"];

		// Hashování hesla
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

		// Kontrola existence uživatelského jména
		$stmt = $pdo->prepare("SELECT * FROM Users WHERE Username = :username");
		$stmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0)
		{
			// Uživatelské jméno již existuje
			echo "Username already exists. Please choose a different username.";
		}
		else
		{
			// Vložení nového uživatele
			$stmt = $pdo->prepare("INSERT INTO Users (Username, Password) VALUES (:username, :password)");
			$stmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
			$stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
			$stmt->execute();

			echo "<script>window.open('login.php', '_self');</script>";
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
