<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idVolume']))
    {
        $idVolume = $_REQUEST['idVolume'];
        if(isset($_REQUEST['idUtente']))
        {
            $idUtente = $_REQUEST['idUtente'];
            $idPersonale = $_SESSION['idUtente'];
            $sql = "CALL RevocaPrestitoVolume($idVolume, $idUtente, $idPersonale);";
            mysqli_query($con, $sql);
        }
    }
    echo "";
    require_once("var_connclose.php");
?>