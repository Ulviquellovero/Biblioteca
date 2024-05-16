<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['id']))
    {
        $id = $_REQUEST['id'];
        $sql = "SELECT idCarta, tutente.idUtente, nome, cognome, data FROM vprenotazionicarte JOIN tutente ON vprenotazionicarte.idUtente = tutente.idUtente WHERE idCarta = $id ORDER BY data ASC";
        $res = mysqli_query($con, $sql);
        $i = 0;
        $resArr = null;
        while($array = mysqli_fetch_array($res)) 
        {
            $idLibro = $array['idCarta'];
            $userId = $array['idUtente'];
            $sqlPrestiti = "SELECT data AS dataPrestito FROM tprestitocarta WHERE idUtente = $userId AND idCarta = $idLibro"; 
            $resPrestiti = mysqli_query($con, $sqlPrestiti);
            if(mysqli_num_rows($resPrestiti) == 0)
            {
                $nomeUtente = $array['nome'] . " " . $array['cognome'];
                $arrayPrestiti = mysqli_fetch_array($resPrestiti);
                $row = array(
                    "dataPrenotazione" => $array['data'],
                    "nomeUtente" => $nomeUtente
                );
                $resArr[$i] = $row;
                $i++;
            }
        }
        $risFin = array(
                    "Result" => $resArr,
                    );
        echo json_encode($risFin);
    }
    require_once("var_connclose.php");
?>