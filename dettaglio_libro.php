<?php
    require_once("var_conn.php");
    if(isset($_GET['id']))
    {
        $userId = null;
        $permessi = null;
        if(isset($_SESSION['idUtente']))
            $userId = $_SESSION['idUtente'];
        if(isset($_SESSION['permessi']))
            $permessi = $_SESSION['permessi'];
        $id = $_GET['id'];
        $sql = "SELECT idLibro, titolo, annoPubblicazione, ISBN, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile 
                FROM tlibro WHERE idLibro = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        $autore = $array['nomeAutore'] . " " . $array['cognomeAutore'];
        if($userId != null && $permessi != null)
        {
            $row = array(
                "id" => $array['idLibro'],
                "titolo" => $array['titolo'],
                "annoPub" => $array['annoPubblicazione'],
                "autore" => $autore,
                "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                "disponibile" => $array['disponibile'],
                "ISBN" => $array['ISBN'],
                "userId" => $userId,
                "permessi" => $permessi,
                "tipo" => "libri"
            );
        }
        else
        {
            $row = array(
                "id" => $array['idLibro'],
                "titolo" => $array['titolo'],
                "annoPub" => $array['annoPubblicazione'],
                "autore" => $autore,
                "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                "disponibile" => $array['disponibile'],
                "ISBN" => $array['ISBN'],
                "permessi" => "false",
            );
        }
        $resArr[0] = $row;
        $risFin = array(
            "Result" => $resArr,
            );
        echo json_encode($risFin);
    }
    require_once("var_connclose.php");
?>