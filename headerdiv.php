<?php
session_start();
echo '<div style="text-align: right;">';
// Získání aktuální URL
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$decodedUrl = urldecode($currentUrl);

// Tlačítko "Watch"
if(!isset($_GET["w"]) and preg_match("/universe.*\.php/", $decodedUrl))
{
	echo "<button onclick=\"window.open('watch.php?', '_self');\">Watch</button>";
}

// Podmínka pro tlačítko "Save Preference"
if (preg_match("/universe.*\.php/", $decodedUrl) and isset($_SESSION["user"]))
{
	echo "<button onclick=\"window.open('savepreference.php?url=" . urlencode($currentUrl) . "', '_self');\">Save Preference</button>";
}

// Tlačítko "Preferences List"
if (!preg_match("/preflist\.php/", $decodedUrl))
{
	echo "<button onclick=\"window.open('preflist.php', '_self');\">Preferences List</button>";
}
// Podmínka pro tlačítko "Logout"
if (isset($_SESSION["user"]))
{
	echo "<button onclick=\"window.open('logout.php', '_self');\">Logout</button>";
}


// Podmínka pro tlačítko "Main Page" - zobrazeno, pokud uživatel není na index.php
if (!preg_match("/index\.php/", $decodedUrl)) {
    echo "<button onclick=\"window.open('index.php', '_self');\">Main Page</button><br>";
}
echo '</div>';
//echo '<script src="savepreference.js" charset="utf-8"></script>';

?>



