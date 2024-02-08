<?php
$servername = 'localhost';
$username = 'mazzaf';
$password = 'KraKEN-28.12.1998';
$dbname = "mazzaf";

try
{
	// Vytvoření PDO připojení
	$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

?>
