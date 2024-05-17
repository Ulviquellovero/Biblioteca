<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['id']))
    {
        $id = $_REQUEST['id'];
        $sql = "SELECT trl.data, tp.nomeUtente, tu.nome, tu.cognome FROM trestituzionecarta trl JOIN tpersonale tp ON trl.idPersonale = tp.idPersonale JOIN tutente tu ON trl.idUtente = tu.idUtente WHERE trl.idCarta = $id ORDER BY data DESC";
        $res = mysqli_query($con, $sql);
        $i = 0;
        $resArr = null;
        while($array = mysqli_fetch_array($res))
        {
            $nomeUtente = $array['nome'] . " " . $array['cognome'];
            $row = array(
                "data" => $array['data'],
                "nomePersonale" => $array['nomeUtente'],
                "nomeUtente" => $nomeUtente
            );
            $resArr[$i] = $row;
            $i++;
        }
        $risFin = array(
                    "Result" => $resArr,
                    );
        echo json_encode($risFin);
    }
    require_once("var_connclose.php");
?>