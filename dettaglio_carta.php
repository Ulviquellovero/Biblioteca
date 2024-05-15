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
        $sqlAutore = "SELECT nome, cognome FROM tautorecarta WHERE idCarta = $id";
        $resAutore = mysqli_query($con, $sqlAutore);
        $autori = "";
        while ($rowAutore = mysqli_fetch_assoc($resAutore))
            $autori .= ", " . $rowAutore['nome'] . " " . $rowAutore['cognome'];
        $sql = "SELECT idCarta, codiceScaffale, titolo, annoPubblicazione, annoRiferimento, nomeCasaEditrice, ISBN, disponibile FROM tcarta
                WHERE idCarta = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        if($userId != null && $permessi != null)
        {
            if($permessi == true)
            {
                $codiceScaffale = $array['codiceScaffale'];
                $sqlPosizione = "SELECT codiceScaffale, identificativoArmadio, identificativoStanza
                FROM tposizione WHERE codiceScaffale = $codiceScaffale";
                $resPosizione = mysqli_query($con, $sqlPosizione);
                $arrayPosizione = mysqli_fetch_array($resPosizione);
                $row = array(
                    "id" => $array['idCarta'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "annoRif" => $array['annoRiferimento'],
                    "autore" => ltrim($autori, ', '),
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
                    "ISBN" => $array['ISBN'],
                    "userId" => $userId,
                    "permessi" => $permessi,
                    "tipo" => "carte",
                    "codiceScaffale" => $arrayPosizione['codiceScaffale'],
                    "identificativoArmadio" => $arrayPosizione['identificativoArmadio'],
                    "identificativoStanza" => $arrayPosizione['identificativoStanza']
                    );
            }
            else
            {
                $row = array(
                    "id" => $array['idCarta'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "annoRif" => $array['annoRiferimento'],
                    "autore" => ltrim($autori, ', '),
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
                    "ISBN" => $array['ISBN'],
                    "userId" => $userId,
                    "permessi" => $permessi,
                    "tipo" => "carte"
                    );
            }
        }
        else
        {
            $row = array(
                "id" => $array['idCarta'],
                "titolo" => $array['titolo'],
                "annoPub" => $array['annoPubblicazione'],
                "annoRif" => $array['annoRiferimento'],
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