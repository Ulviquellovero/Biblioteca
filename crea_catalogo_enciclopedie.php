<?php
    require_once("var_conn.php");
    $sql = "SELECT idEnciclopedia, titolo, annoPubblicazione, nomeCasaEditrice, nVolumi FROM tenciclopedia ORDER BY titolo ASC";
    $res = mysqli_query($con, $sql);
    $resArr = array();
    while ($array = mysqli_fetch_array($res)) {
        $idLibro = $array['idEnciclopedia'];
        $sqlAutore = "SELECT nome, cognome FROM tautoreenciclopedia WHERE idEnciclopedia = $idLibro";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore)) {
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        }
        $row = array(
            "id" => $array['idEnciclopedia'],
            "titolo" => $array['titolo'],
            "annoPub" => $array['annoPubblicazione'],
            "autore" => ltrim($autori, ', '),
            "nomeCasaEditrice" => $array['nomeCasaEditrice'],
            "volumi" => $array['nVolumi']
        );
        $resArr[] = $row;
    }
    $risFin = array(
        "Result" => $resArr
    );
    echo json_encode($risFin);
    require_once("var_connclose.php");
?>