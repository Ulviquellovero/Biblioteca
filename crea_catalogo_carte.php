<?php
    require_once("var_conn.php");
    $sql = "SELECT idCarta, titolo, annoPubblicazione, nomeCasaEditrice, disponibile FROM tcarta ORDER BY titolo ASC";
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