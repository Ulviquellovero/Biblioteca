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
        $sql = "SELECT idVolume, tc.codiceScaffale, tc.titolo, numero, ISBN, tc.annoPubblicazione, tc.nVolumi, tc.nomeCasaEditrice, disponibile, tv.idEnciclopedia 
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
            if($permessi == true)
            {
                $codiceScaffale = $array['codiceScaffale'];
                $sqlPosizione = "SELECT codiceScaffale, identificativoArmadio, identificativoStanza
                FROM tposizione WHERE codiceScaffale = $codiceScaffale";
                $resPosizione = mysqli_query($con, $sqlPosizione);
                $arrayPosizione = mysqli_fetch_array($resPosizione);
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
                    "tipo" => "volumi",
                    "codiceScaffale" => $arrayPosizione['codiceScaffale'],
                    "identificativoArmadio" => $arrayPosizione['identificativoArmadio'],
                    "identificativoStanza" => $arrayPosizione['identificativoStanza']
                    );

                $idLibro = $array['idVolume'];
                $sqlPrenotazione = "SELECT tpl.idUtente AS idUtente, tpl.data AS data, tu.nome AS nome, tu.cognome AS cognome, tu.codiceFiscale AS codiceFiscale, tpl.idPersonaleErogatore AS idPersonaleErogatore, tpl.idPersonaleConsegna AS idPersonaleConsegna FROM tprestitovolume tpl JOIN tutente tu ON tpl.idUtente = tu.idUtente WHERE tpl.idVolume = $idLibro";
                $resPrenotazione = mysqli_query($con, $sqlPrenotazione);
                if(mysqli_num_rows($resPrenotazione) != 0) 
                {
                    $arrayPrenotazione = mysqli_fetch_array($resPrenotazione);
                    $nomeUtente = $arrayPrenotazione['nome'] . " " . $arrayPrenotazione['cognome'];
                    $row["data"] = $arrayPrenotazione['data'];
                    $row["nomeUtente"] = $nomeUtente;
                    $row["codiceFiscale"] = $arrayPrenotazione['codiceFiscale'];
                    $idPersonaleErogatore = $arrayPrenotazione['idPersonaleErogatore'];
                    $sqlPersonaleErogatore = "SELECT nomeUtente FROM tpersonale WHERE idPersonale = $idPersonaleErogatore";
                    $resPersonaleErogatore = mysqli_query($con, $sqlPersonaleErogatore);
                    $arrayPersonaleErogatore = mysqli_fetch_array($resPersonaleErogatore);
                    $row["nomeUtentePersonaleErogatore"] = $arrayPersonaleErogatore['nomeUtente'];
                    $idPersonaleConsegna = $arrayPrenotazione['idPersonaleConsegna'];
                    $sqlPersonaleConsegna = "SELECT nomeUtente FROM tpersonale WHERE idPersonale = $idPersonaleConsegna";
                    $resPersonaleConsegna = mysqli_query($con, $sqlPersonaleConsegna);
                    $arrayPersonaleConsegna = mysqli_fetch_array($resPersonaleConsegna);
                    $row["nomeUtentePersonaleConsegna"] = $arrayPersonaleConsegna['nomeUtente'];
                    $row["idUtente"] = $arrayPrenotazione['idUtente'];
                }
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
                    "userId" => $userId,
                    "permessi" => $permessi,
                    "tipo" => "volumi"
                    );
            }
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