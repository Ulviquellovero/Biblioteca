<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idVolume']))
    {
        $idVolume = $_REQUEST['idVolume'];
        $idUtente = $_SESSION['idUtente'];
        $sql = "SELECT idPrenotazioneVolume FROM tprenotazionevolume WHERE idUtente = $idUtente AND idVolume = $idVolume";
        $res = mysqli_query($con, $sql);
        $prenotato = null;
        if(mysqli_num_rows($res) != 0)
            $prenotato = "false";
        else
        {
            $sqlIns = "CALL InsertPrenotazioneVolume($idUtente, $idVolume)";
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