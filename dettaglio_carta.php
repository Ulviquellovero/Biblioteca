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

                $idLibro = $array['idCarta'];
                $sqlPrenotazione = "SELECT tpl.idUtente AS idUtente, tpl.data AS data, tu.nome AS nome, tu.cognome AS cognome, tu.codiceFiscale AS codiceFiscale, tpl.idPersonaleErogatore AS idPersonaleErogatore, tpl.idPersonaleConsegna AS idPersonaleConsegna FROM tprestitocarta tpl JOIN tutente tu ON tpl.idUtente = tu.idUtente WHERE tpl.idCarta = $idLibro";
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

                    $idUtente = $arrayPrenotazione['idUtente'];
                    $sqlNumeriTel = "SELECT numero FROM ttelefono WHERE idUtente = $idUtente";
                    $resNumeriTel = mysqli_query($con, $sqlNumeriTel);
                    $counterNumeri = 0;
                    while($rowNumeriTel = mysqli_fetch_array($resNumeriTel))
                    {
                        if($counterNumeri == 0)
                            $row["primoNumero"] = $rowNumeriTel['numero'];
                        if($counterNumeri == 1)
                            $row["secondoNumero"] = $rowNumeriTel['numero'];
                        if($counterNumeri == 2)
                            $row["terzoNumero"] = $rowNumeriTel['numero'];
                        ++$counterNumeri;
                    }

                    $idPersonaleConsegna = $arrayPrenotazione['idPersonaleConsegna'];
                    if($idPersonaleConsegna != null)
                    {
                        $sqlPersonaleConsegna = "SELECT nomeUtente FROM tpersonale WHERE idPersonale = $idPersonaleConsegna";
                        $resPersonaleConsegna = mysqli_query($con, $sqlPersonaleConsegna);
                        $arrayPersonaleConsegna = mysqli_fetch_array($resPersonaleConsegna);
                        $row["nomeUtentePersonaleConsegna"] = $arrayPersonaleConsegna['nomeUtente'];
                    }
                    else
                        $row["nomeUtentePersonaleConsegna"] = "La carta non è ancora stata consegnata";
                    $row["idUtente"] = $arrayPrenotazione['idUtente'];
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