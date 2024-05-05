<?php
    require_once("var_conn.php");
	$anno = null;
	$casa = null;
	if(isset($_GET['annoSelez']) && $_GET['annoSelez'] != "null")
		$anno = $_GET['annoSelez'];
	if(isset($_GET['casaSelez']) && $_GET['casaSelez'] != "null")
		$casa = $_GET['casaSelez'];
	$sql = "SELECT idLibro, titolo, annoPubblicazione, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile
		FROM tlibro ";
	if($anno != null && $casa != null)
		$sql = $sql . "WHERE annoPubblicazione = $anno AND nomeCasaEditrice = '$casa' ";
	else
	{
		if($anno != null && $casa == null)
			$sql = $sql . "WHERE annoPubblicazione = $anno ";
		else
		{
			if($anno == null && $casa != null)
			$sql = $sql . "WHERE nomeCasaEditrice = '$casa' ";
		}
	}
	$sql = $sql . "ORDER BY titolo ASC";

    $res = mysqli_query($con, $sql);
    $numRigheReali = mysqli_num_rows($res);
    $i = 0;
    $resArr = null;
    while($array = mysqli_fetch_array($res)) 
    {
		$autore = $array['nomeAutore'] . " " . $array['cognomeAutore'];
		$row = array(
					"id" => $array['idLibro'],
					"titolo" => $array['titolo'],
					"annoPub" => $array['annoPubblicazione'],
					"autore" => $autore,
					"nomeCasaEditrice" => $array['nomeCasaEditrice'],
					"disponibile" => $array['disponibile']
					);
		$resArr[$i] = $row;
		$i++;
	}
	$risFin = array(
				"Result" => $resArr,
				);
	echo json_encode($risFin);
    require_once("var_connclose.php");
?>