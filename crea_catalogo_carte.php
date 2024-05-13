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
	$sql = "SELECT idCarta, titolo, annoPubblicazione, nomeCasaEditrice, disponibile FROM tcarta ";
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
    $resArr = array();
    while ($array = mysqli_fetch_array($res)) {
        $idCarta = $array['idCarta'];
		$sqlPrestiti = "SELECT idPrestitoCarta FROM tprestitocarta WHERE idCarta = $idCarta";
		$resPrestiti = mysqli_query($con, $sqlPrestiti);
		$notifica = "false";
		if(mysqli_num_rows($resPrestiti) == 0)
		{
			$sqlPrenotazioni = "SELECT idPrenotazioneCarta FROM tprenotazionecarta WHERE idCarta = $idCarta";
			$resPrenotazioni = mysqli_query($con, $sqlPrenotazioni);
			if(mysqli_num_rows($resPrenotazioni) != 0)
				$notifica = "true";
		}
        $sqlAutore = "SELECT nome, cognome FROM tautorecarta WHERE idCarta = $idCarta";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore)) {
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        }
        if($permessi != null)
		{
			if($permessi == true)
			{
                $row = array(
                    "id" => $array['idCarta'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "autore" => ltrim($autori, ', '),
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
					"permessi" => $permessi,
					"notifica" => $notifica
                );
			}
			else
			{
				$row = array(
                    "id" => $array['idCarta'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "autore" => ltrim($autori, ', '),
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
					"permessi" => $permessi
                );
			}
		}
		else
		{
			$row = array(
                "id" => $array['idCarta'],
                "titolo" => $array['titolo'],
                "annoPub" => $array['annoPubblicazione'],
                "autore" => ltrim($autori, ', '),
                "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                "disponibile" => $array['disponibile']
            );
		}
        $resArr[] = $row;
    }
    $risFin = array(
        "Result" => $resArr
    );
    echo json_encode($risFin);
    require_once("var_connclose.php");
?>