<?php

require(db_connect.php);

// Získání dat poslaných AJAXem
$data = json_decode($_POST['data']);
pirnt_r $data;

// Zajištění, že dostanete požadovaná data
if ($data)
{
	$numInUniverse = $data->numInUniverse;
	$action = $data->action;
	$link = $data->url;
	try
	{
		$pdo->beginTransaction();

		// První dotaz: Získání PreferenceID
		$stmt = $pdo->prepare('SELECT PreferenceID FROM Preferences WHERE Link = :link');
		$stmt->execute(['link' => $link]);
		$row = $stmt->fetch();

		if (!$row)
		{
		    throw new Exception("Preference nebyla nalezena.");
		}
	$preferenceID = $row['PreferenceID'];

	// Druhý dotaz: Vložení záznamu do tabulky Watched
	$stmt = $pdo->prepare('INSERT INTO Watched (PreferenceID, NumInUniverse, Watched) VALUES (:preferenceID, :numInUniverse, :watched)');
	$stmt->execute(['preferenceID' => $preferenceID, 'numInUniverse' => $numInUniverse, 'watched' => $action]);

	// Uzavření transakce
	$pdo->commit();
	}
	catch (\Exception $e)
	{
		$pdo->rollBack();
		throw $e;
		echo json_encode(array('error' => $e->getMessage()));
	}

		

	// Odeslání odpovědi zpět do JavaScriptu
	echo json_encode(array('message' => 'Úspěšná aktualizace pro epizodu ' . $numInUniverse));
}
else
{
	// Odpověď v případě chyby
	echo json_encode(array('error' => 'Chybí data'));
}
?>

