<?php
    require_once("var_conn.php");
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sqlAutore = "SELECT nome, cognome FROM tautorecarta WHERE idCarta = $id";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore))
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        $sql = "SELECT idCarta, titolo, annoPubblicazione, annoRiferimento, nomeCasaEditrice, ISBN, disponibile FROM tcarta
                WHERE idCarta = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        $row = array(
                    "id" => $array['idCarta'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "annoRif" => $array['annoRiferimento'],
                    "autore" => ltrim($autori, ', '),
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
                    "ISBN" => $array['ISBN'],
                    );
        $resArr[0] = $row;
        $risFin = array(
            "Result" => $resArr,
            );
        echo json_encode($risFin);
    }
    require_once("var_connclose.php");
?>