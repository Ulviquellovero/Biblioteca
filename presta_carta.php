<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idCarta']))
    {
        $idCarta = $_REQUEST['idCarta'];
        if(isset($_REQUEST['idUtente']))
        {
            $idUtente = $_REQUEST['idUtente'];
            $idPersonale = $_SESSION['idUtente'];
            $sql = "CALL PrestaCarta($idCarta, $idUtente, $idPersonale);";
            mysqli_query($con, $sql);
        }
    }
    echo "";
    require_once("var_connclose.php");
?>