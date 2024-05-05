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
    $res = mysqli_query($con, $sql);
    $resArr = array();
    while ($array = mysqli_fetch_array($res)) {
        $idLibro = $array['idCarta'];
        $sqlAutore = "SELECT nome, cognome FROM tautorecarta WHERE idCarta = $idLibro";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore)) {
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        }
        $row = array(
            "id" => $array['idCarta'],
            "titolo" => $array['titolo'],
            "annoPub" => $array['annoPubblicazione'],
            "autore" => ltrim($autori, ', '),
            "nomeCasaEditrice" => $array['nomeCasaEditrice'],
            "disponibile" => $array['disponibile']
        );
        $resArr[] = $row;
    }
    $risFin = array(
        "Result" => $resArr
    );
    echo json_encode($risFin);
    require_once("var_connclose.php");
?>