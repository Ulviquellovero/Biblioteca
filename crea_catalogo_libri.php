<?php
    require_once("var_conn.php");
	$anno = null;
	$casa = null;
	$testoInserito = null;
	if(isset($_GET['annoSelez']) && $_GET['annoSelez'] != "null")
		$anno = $_GET['annoSelez'];
	if(isset($_GET['casaSelez']) && $_GET['casaSelez'] != "null")
		$casa = $_GET['casaSelez'];
	if(isset($_GET['testoInserito']) && $_GET['testoInserito'] != "null")
		$testoInserito = $_GET['testoInserito'];
	$sql = "SELECT idLibro, titolo, annoPubblicazione, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile
		FROM tlibro ";
	$sqlWhere = "";
	if($anno != null)
		$sqlWhere = $sqlWhere . "WHERE annoPubblicazione = $anno ";
	if($casa != null)
	{
		if($sqlWhere != "")
			$sqlWhere = $sqlWhere . "AND nomeCasaEditrice = '$casa' ";
		else
			$sqlWhere = $sqlWhere . "WHERE nomeCasaEditrice = '$casa' ";
	}
	if($testoInserito != null)
	{
		if($sqlWhere != "")
			$sqlWhere = $sqlWhere . "AND titolo LIKE '%$testoInserito%' ";
		else
			$sqlWhere = $sqlWhere . "WHERE titolo LIKE '%$testoInserito%' ";
	}
	$sql = $sql . $sqlWhere . "ORDER BY titolo ASC";

	$permessi = null;
	if(isset($_SESSION['permessi']))
        $permessi = $_SESSION['permessi'];
    $res = mysqli_query($con, $sql);
    $numRigheReali = mysqli_num_rows($res);
    $i = 0;
    $resArr = null;
    while($array = mysqli_fetch_array($res)) 
    {
		$idLibro = $array['idLibro'];
		$sqlPrestiti = "SELECT idPrestitoLibro FROM tprestitolibro WHERE idLibro = $idLibro";
		$resPrestiti = mysqli_query($con, $sqlPrestiti);
		$notifica = false;
		if(mysqli_num_rows($resPrestiti) == 0)
		{
			$sqlPrenotazioni = "SELECT idPrenotazioneLibro FROM tprenotazionelibro WHERE idLibro = $idLibro";
			$resPrenotazioni = mysqli_query($con, $sqlPrenotazioni);
			if(mysqli_num_rows($resPrenotazioni) != 0)
				$notifica = true;
		}
		$autore = $array['nomeAutore'] . " " . $array['cognomeAutore'];
		if($permessi != null)
		{
			$row = array(
				"id" => $array['idLibro'],
				"titolo" => $array['titolo'],
				"annoPub" => $array['annoPubblicazione'],
				"autore" => $autore,
				"nomeCasaEditrice" => $array['nomeCasaEditrice'],
				"disponibile" => $array['disponibile'],
				"permessi" => $permessi
				);
		}
		else
		{
			$row = array(
				"id" => $array['idLibro'],
				"titolo" => $array['titolo'],
				"annoPub" => $array['annoPubblicazione'],
				"autore" => $autore,
				"nomeCasaEditrice" => $array['nomeCasaEditrice'],
				"disponibile" => $array['disponibile']
				);
		}
		$resArr[$i] = $row;
		$i++;
	}
	$risFin = array(
				"Result" => $resArr,
				);
	echo json_encode($risFin);
    require_once("var_connclose.php");
?>