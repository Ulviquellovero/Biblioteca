<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idCarta']))
    {
        $idCarta = $_REQUEST['idCarta'];
        $idUtente = $_SESSION['idUtente'];
        $sql = "SELECT idPrenotazioneCarta FROM tprenotazionecarta WHERE idUtente = $idUtente AND idCarta = $idCarta";
        $res = mysqli_query($con, $sql);
        $prenotato = null;
        if(mysqli_num_rows($res) != 0)
            $prenotato = "false";
        else
        {
            $sqlIns = "CALL InsertPrenotazioneCarta($idUtente, $idCarta)";
            $resIns = mysqli_query($con, $sqlIns);
            $prenotato = "true";
        }
    }
    $rowJSON = array(
        "prenotato" => $prenotato,
    );
    echo json_encode($rowJSON);
    require_once("var_connclose.php");
?>