<?php
    require_once("var_conn.php");
    $id = null;
	if(isset($_GET['id']))
        $id = $_GET['id'];
	$sql = "SELECT idVolume, tc.titolo, numero, disponibile FROM tvolume tv JOIN tenciclopedia tc ON tv.idEnciclopedia = tc.idEnciclopedia WHERE tv.idEnciclopedia = $id ORDER BY numero ASC";
    $permessi = null;
	if(isset($_SESSION['permessi']))
        $permessi = $_SESSION['permessi'];
    $res = mysqli_query($con, $sql);
    $resArr = array();
    while ($array = mysqli_fetch_array($res)) {
        $idVolume = $array['idVolume'];
		$sqlPrestiti = "SELECT idPrestitoVolume FROM tprestitovolume WHERE idVolume = $idVolume";
		$resPrestiti = mysqli_query($con, $sqlPrestiti);
		$notifica = "false";
		if(mysqli_num_rows($resPrestiti) == 0)
		{
			$sqlPrenotazioni = "SELECT idPrenotazioneVolume FROM tprenotazionevolume WHERE idVolume = $idVolume";
			$resPrenotazioni = mysqli_query($con, $sqlPrenotazioni);
			if(mysqli_num_rows($resPrenotazioni) != 0)
				$notifica = "true";
		}
        if($permessi != null)
		{
			if($permessi == true)
			{
                $row = array(
                    "id" => $array['idVolume'],
                    "numero" => $array['numero'],
                    "disponibile" => $array['disponibile'],
                    "titolo" => $array['titolo'],
                    "permessi" => $permessi,
					"notifica" => $notifica
                );
			}
			else
			{
				$row = array(
                    "id" => $array['idVolume'],
                    "numero" => $array['numero'],
                    "disponibile" => $array['disponibile'],
                    "titolo" => $array['titolo'],
                    "permessi" => $permessi
                );
			}
		}
		else
		{
			$row = array(
                "id" => $array['idVolume'],
                "numero" => $array['numero'],
                "disponibile" => $array['disponibile'],
                "titolo" => $array['titolo'],
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