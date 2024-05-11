<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idLibro']))
    {
        $idLibro = $_REQUEST['idLibro'];
        $idUtente = $_SESSION['idUtente'];
        $sql = "SELECT idPrenotazioneLibro FROM tprenotazionelibro WHERE idUtente = $idUtente AND idLibro = $idLibro";
        $res = mysqli_query($con, $sql);
        $prenotato = null;
        if(mysqli_num_rows($res) != 0)
            $prenotato = "false";
        else
        {
            $sqlIns = "CALL InsertPrenotazioneLibro($idUtente, $idLibro)";
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