<?php
    require_once("var_conn.php");
    $userId = $_SESSION['idUtente'];
	$sql = "SELECT idVolume, numero, data, titolo FROM vprenotazionivolumi WHERE idUtente = $userId ORDER BY titolo ASC";
    $res = mysqli_query($con, $sql);
    $i = 0;
    $resArr = null;
    while($array = mysqli_fetch_array($res)) 
    {
        $idVolume = $array['idVolume'];
        $sqlPrestiti = "SELECT data AS dataPrestito FROM tprestitovolume WHERE idUtente = $userId AND idVolume = $idVolume"; 
        $resPrestiti = mysqli_query($con, $sqlPrestiti);
        $arrayPrestiti = mysqli_fetch_array($resPrestiti);
        $titolo = $array['titolo'] . " Volume " . $array['numero'];
        if(mysqli_num_rows($resPrestiti) != 0)
        {
            $row = array(
                "dataPrenotazione" => $array['data'],
                "titolo" => $titolo,
                "dataPrestito" => $arrayPrestiti['dataPrestito']
            );
        }
        else
        {
            $row = array(
                "dataPrenotazione" => $array['data'],
                "titolo" => $titolo
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