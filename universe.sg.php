
<!DOCTYPE html>
<html>
	<head>
		<title>Stargate Universe Chronology</title>
		<style>
		body
		{
			background: white;
			color: black;
		}
		table
		{
			background: black;
			text-align: center;
		}
		.none
		{
			background: white;
		}
		.special
		{
			background-color: rgb(93, 138, 168);
		}
		.longerstory
		{
			background-color: rgb(154, 129, 148);
		}
		.crossover
		{
			background-color: rgb(239, 206, 87);
		}
		.speclong
		{
			background-color: rgb(124, 134, 158);
		}
		.speccross
		{
			background-color: rgb(166, 172, 128);
		}
		.longcross
		{
			background-color: rgb(196, 168, 118);
		}
		.speclongcross
		{
			background-color: rgb(162, 158, 134);
		}
		table
		{
			margin: auto;
		}
		</style>
	</head>
	<body>
<?php
	include("headerdiv.php");
?>
		<h1>Stargate Universe Chronology</h1>

		<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <label for='cannon'>Cannon:</label>
                                <input type='checkbox' id='cannon' name='cannon' value='true'><br>

                        <label for='essential'>Non-Filler:</label>
                                <input type='checkbox' id='essential' name='essential' value='true'><br>

			<label for='medium'>Medium:</label>
				<input type='checkbox' id='episode' name='episode' value='true'>
				<label for='episode'>TV Shows</label>
				<input type='checkbox' id='movie' name='movie' value='true'>
				<label for='movie'>Movies</label>
				<input type='checkbox' id='book' name='book' value='true'>
				<label for='book'>Books</label>
				<input type='checkbox' id='audiobook' name='audiobook' value='true'>
				<label for='audiobook'>Audiobooks</label>
				<input type='checkbox' id='comics' name='comics' value='true'>
				<label for='comics'>Comics</label>
				<input type='checkbox' id='smss' name='smss' value='true'>
				<label for='smss'>Stargate Magazine Short Stories</label><br>

			<label for='origins'>Stargate Origins:</label>
				<input type='radio' id='origins' name='origins' value='show'>
				<label for='show'>TV Show</label>
				<input type='radio' id='origins' name='origins' value='movie'>
				<label for='movie'>Movie</label><br>


				<label for='score'>Episode Score over:</label>
					<input type='text' id='score' name='score' value='10'><br>

			<label for='highlight'>Highlight:</label>
				<input type='checkbox' id='special' name='hlspecial' value='true'>
				<label for='special'>Specials</label>
				<input type='checkbox' id='longer' name='hllonger' value='true'>
				<label for='longer'>Longer Stories</label>
				<input type='checkbox' id='crossover' name='hlcrossover' value='true'>
				<label for='crossover'>Crossovers</label><br>

                        <label for="SGA6">Stargate Atlantis "Season 6":</label>
                                <input type='checkbox' id='sga6comics' name='sga6comics' value='true'>
                                <label for='sga6comics'>Comics</label>
                                <input type='checkbox' id='sga6books' name='sga6books' value='true'>
                                <label for='sga6books'>Books</label><br>

			<input type='submit' value='Zobraz tabulku'>
		</form>
		<p>Highlight colors look like this: <span class="special">Special</span> <span class="longerstory">Longer Stories</span> <span class="crossover">Crossover.</span> Combinated colors look like this <span class="speclong">Longer Special Story</span> <span class="speccross">Special Crossover</span> <span class="longcross">Longer Crossover Story</span> <span class="speclongcross">Longer Special Crossover Story</span></p>		
<?php
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
		$query = "";
		if($_GET["cannon"])
		{
			$query = "SELECT TVShows.TVShow_Name AS TVShow, SG_Episodes.NumInUniverse,  SG_Episodes.NumInShow, SG_Episodes.NumOfSeason, SG_Episodes.NumInSeason, SG_Episodes.EpisodeName, SG_Episodes.ReleaseDate, SG_Episodes.Episodescore, SG_Episodes.Medium, SG_Episodes.Special, SG_Episodes.StoryLength, SG_Episodes.CrossoverID, SG_Episodes.Essential
FROM SG_Episodes
INNER JOIN TVShows ON SG_Episodes.TVShowID = TVShows.TVShowID";
                       if($_GET["episode"] AND $_GET["movie"])
                       {
                       	$query .= " WHERE (Medium = 'Episode' OR Medium = 'Movie')";
                       }
			elseif($_GET["episode"])
                       {
                               $query .= " WHERE Medium ='Episode'";
                       }
                       elseif($_GET["movie"])
                       {
                               $query .= " WHERE Medium ='Movie'";
                       }
			if(!$_GET["episode"] AND !$_GET["movie"])
                       {
                               $query .= " WHERE (Medium = 'Episode' OR Medium = 'Movie')";
                       }
			if($_GET["essential"])
			{
				$query .= " AND (Essential=1 OR Episodescore > " . $_GET["score"] . ") AND NOT EpisodeID=365";
			}
			else
			{
				$query .= " AND NOT EpisodeID=369";
			}
                       if($_GET["origins"] == "show")
                       {
                               $query .= " AND NOT EpisodeID=368";
                       }
			else
			{
				$query .= " AND NOT EpisodeID=355 AND NOT EpisodeID=356 AND NOT EpisodeID=357 AND NOT EpisodeID=358 AND NOT EpisodeID=359 AND NOT EpisodeID=360 AND NOT EpisodeID=361 AND NOT EpisodeID=362 AND NOT EpisodeID=363 AND NOT EpisodeID=364";
			}

		}
		else //Non-Cannon
		{
			$query1 = "SELECT TVShows.TVShow_Name AS `TVShow`, SG_Episodes.NumInUniverse AS `NumInUniverse`, SG_Episodes.NumInShow AS `NumInShow`, SG_Episodes.NumOfSeason AS `NumOfSeason`, CAST(SG_Episodes.NumInSeason AS CHAR) AS `NumInSeason`, SG_Episodes.EpisodeName AS `EpisodeName`, CAST(SG_Episodes.ReleaseDate AS CHAR) AS `ReleaseDate`, SG_Episodes.Medium AS `Medium`, SG_Episodes.Episodescore AS `Episodescore`, SG_Episodes.Special AS `Special`, SG_Episodes.StoryLength AS `StoryLength`, SG_Episodes.CrossoverID AS `CrossoverID`
FROM SG_Episodes
INNER JOIN TVShows ON SG_Episodes.TVShowID = TVShows.TVShowID
WHERE NOT (SG_Episodes.EpisodeName = 'Stargate' AND TVShows.TVShow_Name = 'Stargate SG-1')";
			$query2 = "SELECT TVShows.TVShow_Name AS `TVShow`, SG_OtherStories.NumInUniverse AS `NumInUniverse`, NULL AS `NumInShow`, SG_OtherStories.SeriesName AS `NumOfSeason`, SG_OtherStories.`NumInSeries#` AS `NumInSeason`, SG_OtherStories.StoryName AS `EpisodeName`, CONCAT(CONVERT(CAST(SG_OtherStories.ReleaseMonth AS BINARY) USING utf8), ' ', CONVERT(CAST(SG_OtherStories.ReleaseYear AS BINARY) USING utf8)) AS `ReleaseDate`, SG_OtherStories.Medium AS `Medium`, NULL AS `Episodescore`, SG_OtherStories.Special AS `Special`, SG_OtherStories.StoryLength AS `StoryLength`, SG_OtherStories.CrossoverID AS `CrossoverID`
FROM SG_OtherStories
INNER JOIN TVShows ON SG_OtherStories.TVShowID = TVShows.TVShowID";
			$query3 = "SELECT TVShows.TVShow_Name AS `TVShow`, SG_StargateMagazineShortStories.NumInUniverse AS `NumInUniverse`, SG_StargateMagazineShortStories.Issue AS `NumInShow`, SG_StargateMagazineShortStories.SeriesName AS `NumOfSeason`, SG_StargateMagazineShortStories.NumInSeries AS `NumInSeason`, SG_StargateMagazineShortStories.StoryName AS `EpisodeName`, CONCAT(SG_StargateMagazineShortStories.ReleaseMonth1, ' ', SG_StargateMagazineShortStories.ReleaseYear1, '/', SG_StargateMagazineShortStories.ReleaseMonth2, ' ', SG_StargateMagazineShortStories.ReleaseYear2) AS `ReleaseDate`, CONVERT(CAST(SG_StargateMagazineShortStories.Medium AS BINARY) USING utf8) AS `Medium`, NULL AS `Episodescore`, NULL AS `Special`, SG_StargateMagazineShortStories.StoryLength AS `StoryLength`, NULL AS `CrossoverID`
FROM SG_StargateMagazineShortStories
INNER JOIN TVShows ON SG_StargateMagazineShortStories.TVShowID = TVShows.TVShowID";

			$mediumtext = "";
			if($_GET["movie"])
			{
				$mediumtext .= " OR Medium = 'Movie'";
			}
			if($_GET["book"])
			{
				$mediumtext .= " OR Medium = 'Book' OR Medium = 'Short Story'";
			}
			if($_GET["audiobook"])
			{
				$mediumtext .= " OR Medium = 'Audio Book'";
			}
			if($_GET["comics"])
			{
				$mediumtext .= " OR Medium = 'Comics'";
			}
			if($_GET["smss"])
			{
				$mediumtext .= " OR Medium = 'Stargate Magazine Short Story'";
			}
			if($_GET["episode"])
			{
				$mediumtext = "Medium = 'Episode'" . $mediumtext;
			}
			else
			{
				$mediumtext = substr($mediumtext, 4);
			}
			if($mediumtext)
			{
				$mediumtext = " AND ($mediumtext)";
			}
			

			$query1 .= "$mediumtext";
			$query2 .= "$mediumtext";
			$query3 .= "$mediumtext";

			if($_GET["origins"] == "show")
                       {
                               $query1 .= " AND NOT NumInUniverse=3";
                       }
			else
			{
				$query1 .= " AND NOT NumInUniverse=4 AND NOT NumInUniverse=5 AND NOT NumInUniverse=6 AND NOT NumInUniverse=7 AND NOT NumInUniverse=8 AND NOT NumInUniverse=9 AND NOT NumInUniverse=10 AND NOT NumInUniverse=11 AND NOT NumInUniverse=12 AND NOT NumInUniverse=13";
			}
			if($_GET["sga6comics"] and $_GET["sga6books"])
			{}
			else
			{
				if($_GET["sga6comics"])
				{
					$sga6 = " AND NOT SeriesName = 'Legacy'";
				}
				if($_GET["sga6books"])
				{
					$sga6 = " AND NOT SeriesName = 'Back to Pegasus' AND NOT SeriesName = 'Gateways' AND NOT SeriesName = 'Hearts & Minds' AND NOT SeriesName = 'Singularity'";
				}
				if(!$_GET["sga6comics"] and !$_GET["sga6books"])
				{
					$sga6 = " AND NOT SeriesName = 'Legacy' AND NOT SeriesName = 'Back to Pegasus' AND NOT SeriesName = 'Gateways' AND NOT SeriesName = 'Hearts & Minds'";
		                        $query2 .= $sga6;
				}
			}

			$query = $query1 . " UNION " . $query2 . " UNION " . $query3;
			
		}
		$sql = $query .= " ORDER BY NumInUniverse ASC;";
               	//echo $sql;
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				// output data of each row
				echo "<form><table> <tr>	<td class = none>TV <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Show</td>
							<td class = none>Num In <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Universe</td>
							<td class = none>Num In <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Show</td>
							<td class = none>Num of <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Season</td>
							<td class = none>Num In <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Season</td>
							<td class = none>Episode <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Name</td>
							<td class = none>Release <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Date</td>
							<td class = none>Episode <script>if (window.innerWidth < 800) { document.write('<br>'); }</script> Score</td>
							<td class = none>Medium</td>
							<td class = none>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>\n";
				$hlcells = [ "special"=>false, "longerstory"=>false, "crossover"=>false];
				$hltext = "class =";
				$max = mysqli_num_rows($result);


				while($row = $result->fetch_assoc())
				{
					$hltext = "class =";	
					if($_GET["hlspecial"])
					{
						if ($row["Special"])
						{
							$hltext .= " 'special'";
						}
					}
					if($_GET["hllonger"])
					{
						if ($row["StoryLength"] > 1)
						{
							$hltext .= " 'longerstory'";
						}
					}
					if($_GET["hlcrossover"])
					{
						if ($row["CrossoverID"] > 0)
						{
							$hltext .= " 'crossover'";
						}
					}
				
					if ($hltext == "class =")
					{
						$hltext .= " 'none'";
					}
							
					if($_GET["hlspecial"] AND $_GET["hllonger"])
					{
						if($hltext == "class = 'special' 'longerstory'")
						{
							$hltext = "class = 'speclong'";
						}
					}
					if($_GET["hlspecial"] AND $_GET["hllonger"])
					{
						if($hltext == "class = 'special' 'crossover'")
						{
							$hltext = "class = 'speccross'";
						}
					}
					if($_GET["hllonger"] AND $_GET["hlcrossover"])
					{
						if($hltext == "class = 'longerstory' 'crossover'")
						{
							$hltext = "class = 'longcross'";
						}
					}
					
					if($_GET["hlspecial"] AND $_GET["hllonger"] AND $_GET["hlcrossover"])
					{
						if($hltext == "class = 'special' 'longerstory' 'crossover'")
						{
							$hltext = "class = 'speclongcross'";
						}
					}
							
					echo
						" <tr><td $hltext>" . $row["TVShow"] .
						"</td><td $hltext>" . $row["NumInUniverse"] .
						"</td><td $hltext>" . $row["NumInShow"] .
						"</td><td $hltext>" . $row["NumOfSeason"] .
						"</td><td $hltext>" . $row["NumInSeason"] .
						"</td><td $hltext>" . $row["EpisodeName"] .
						"</td><td $hltext>" . $row["ReleaseDate"] .
						"</td><td $hltext>" . $row["Episodescore"] .
						"</td><td $hltext>" . $row["Medium"] .
						"</td><td class='none'><input type=\"checkbox\" onclick=\"change(" . $row["NumInUniverse"] . ", '" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "', " . $max . ")\" id='NUMiU" . $row["NumInUniverse"] . "'>" . "</td></tr>\n";



				}
				echo "</table></form>";
			}
			else
			{
				print_r($result);
			}
		
		
		$conn->close();
?>
		<script src="watching.js" charset="utf-8"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	</body>
</html> 
