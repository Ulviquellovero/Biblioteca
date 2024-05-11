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
        $sql = "SELECT idVolume, tc.titolo, numero, ISBN, tc.annoPubblicazione, tc.nVolumi, tc.nomeCasaEditrice, disponibile, tv.idEnciclopedia 
                FROM tvolume tv JOIN tenciclopedia tc ON tv.idEnciclopedia = tc.idEnciclopedia WHERE tv.idVolume = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        $idEnc = $array['idEnciclopedia'];
        $sqlAutore = "SELECT nome, cognome FROM tautoreenciclopedia WHERE idEnciclopedia = $idEnc";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore))
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        if($userId != null && $permessi != null)
        {
            $row = array(
                "id" => $array['idVolume'],
                "titolo" => $array['titolo'],
                "numero" => $array['numero'],
                "annoPub" => $array['annoPubblicazione'],
                "nVolumi" => $array['nVolumi'],
                "autore" => ltrim($autori, ', '),
                "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                "disponibile" => $array['disponibile'],
                "ISBN" => $array['ISBN'],
                "userId" => $userId,
                "permessi" => $permessi,
                "tipo" => "volumi"
                );
        }
        else
        {
            $row = array(
                "id" => $array['idVolume'],
                "titolo" => $array['titolo'],
                "numero" => $array['numero'],
                "annoPub" => $array['annoPubblicazione'],
                "nVolumi" => $array['nVolumi'],
                "autore" => ltrim($autori, ', '),
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