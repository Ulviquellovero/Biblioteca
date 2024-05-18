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
        $sql = "SELECT idLibro, codiceScaffale, titolo, annoPubblicazione, ISBN, nomeAutore, cognomeAutore, nomeCasaEditrice, disponibile 
                FROM tlibro WHERE idLibro = $id";
        $res = mysqli_query($con, $sql);
        $array = mysqli_fetch_array($res);
        $autore = $array['nomeAutore'] . " " . $array['cognomeAutore'];
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
                    "id" => $array['idLibro'],
                    "titolo" => $array['titolo'],
                    "annoPub" => $array['annoPubblicazione'],
                    "autore" => $autore,
                    "nomeCasaEditrice" => $array['nomeCasaEditrice'],
                    "disponibile" => $array['disponibile'],
                    "ISBN" => $array['ISBN'],
                    "userId" => $userId,
                    "permessi" => $permessi,
                    "tipo" => "libri",
                    "codiceScaffale" => $arrayPosizione['codiceScaffale'],
                    "identificativoArmadio" => $arrayPosizione['identificativoArmadio'],
                    "identificativoStanza" => $arrayPosizione['identificativoStanza']
                );

                $idLibro = $array['idLibro'];
                $sqlPrenotazione = "SELECT tpl.idUtente AS idUtente, tpl.data AS data, tu.nome AS nome, tu.cognome AS cognome, tu.codiceFiscale AS codiceFiscale, tpl.idPersonaleErogatore AS idPersonaleErogatore, tpl.idPersonaleConsegna AS idPersonaleConsegna FROM tprestitolibro tpl JOIN tutente tu ON tpl.idUtente = tu.idUtente WHERE tpl.idLibro = $idLibro";
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
                        $row["nomeUtentePersonaleConsegna"] = "Il libro non è ancora stato consegnato";
                    $row["idUtente"] = $arrayPrenotazione['idUtente'];
                }
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
                    "userId" => $userId,
                    "permessi" => $permessi,
                    "tipo" => "libri"
                );
            }
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