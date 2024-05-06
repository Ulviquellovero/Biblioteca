<?php
    require_once("var_conn.php");
    $id = null;
	if(isset($_GET['id']))
        $id = $_GET['id'];
	$sql = "SELECT idVolume, tc.titolo, numero, disponibile FROM tvolume tv JOIN tenciclopedia tc ON tv.idEnciclopedia = tc.idEnciclopedia WHERE tv.idEnciclopedia = $id ORDER BY numero ASC";
    $res = mysqli_query($con, $sql);
    $resArr = array();
    while ($array = mysqli_fetch_array($res)) {
        $row = array(
            "id" => $array['idVolume'],
            "numero" => $array['numero'],
            "disponibile" => $array['disponibile'],
            "titolo" => $array['titolo'],
        );
        $resArr[] = $row;
    }
    $risFin = array(
        "Result" => $resArr
    );
    echo json_encode($risFin);
    require_once("var_connclose.php");
?>