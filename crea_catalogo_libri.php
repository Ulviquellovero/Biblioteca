<?php
    require_once("var_conn.php");
    $sql = "SELECT idLibro, titolo, annoPubblicazione, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile
			FROM tlibro ORDER BY titolo ASC";
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