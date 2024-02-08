 <?php
session_start();
$servername = "localhost";
$username = "mazzaf";
$password = "KraKEN-28.12.1998";
$dbname = "mazzaf";

try
{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("INSERT INTO Preferences (UserID, Link) VALUES (:userid, :link)");
	$stmt->bindParam(':userid', $userid);
	$stmt->bindParam(':link', $link);

	// insert a row
	$userid = $_SESSION["user"];
	$link = $_GET["url"];
	$stmt->execute();

	echo "<script>window.open('$_GET[url]', '_self');</script>";
}
catch(PDOException $e)
{
  echo "Error: " . $e->getMessage();
}
$conn = null;
?> 
