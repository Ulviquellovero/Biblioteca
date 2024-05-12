<?php
    require_once("var_conn.php");
    $userId = $_SESSION['idUtente'];
	$sql = "SELECT idLibro, data, titolo FROM prenotazioniLibri WHERE idUtente = $userId ORDER BY titolo ASC";
    $res = mysqli_query($con, $sql);
    $i = 0;
    $resArr = null;
    while($array = mysqli_fetch_array($res)) 
    {
        $idLibro = $array['idLibro'];
        $sqlPrestiti = "SELECT data AS dataPrestito FROM tprestitolibro WHERE idUtente = $userId AND idLibro = $idLibro"; 
        $resPrestiti = mysqli_query($con, $sqlPrestiti);
        if(mysqli_num_rows($resPrestiti) != 0)
        {
            $arrayPrestiti = mysqli_fetch_array($resPrestiti);
            $row = array(
                "dataPrenotazione" => $array['data'],
                "titolo" => $array['titolo'],
                "dataPrestito" => $arrayPrestiti['dataPrestito']
            );
        }
        else
        {
            $row = array(
                "dataPrenotazione" => $array['data'],
                "titolo" => $array['titolo']
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