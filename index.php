<?php
session_start();
echo "<h2>List of Universes</h2>";
if(isset($_SESSION["user"]))
{
	echo "<button onclick=\"window.open('preflist.php', '_self');\">Preference List</button><br><br>";
	echo "<button onclick=\"window.open('universe.sg.php', '_self');\">Stargate</button><br><br>";
	echo "<button onclick=\"window.open('logout.php', '_self');\">Logout</button>";
}
else
{
	echo "<button onclick=\"window.open('universe.sg.php', '_self');\">Stargate</button><br><br>";
	echo "<button onclick=\"window.open('login.html', '_self');\">Login</button>";
}
?>
