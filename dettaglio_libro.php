<?php
    require_once("var_conn.php");
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "SELECT idLibro, titolo, annoPubblicazione, ISBN, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile 
                FROM tlibro WHERE idLibro = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        $autore = $array['nomeAutore'] . " " . $array['cognomeAutore'];
        $row = array(
                    "id" => $array['idLibro'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "autore" => $autore,
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