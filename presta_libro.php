<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['idLibro']))
    {
        $idLibro = $_REQUEST['idLibro'];
        if(isset($_REQUEST['idUtente']))
        {
            $idUtente = $_REQUEST['idUtente'];
            $idPersonale = $_SESSION['idUtente'];
            $sql = "CALL PrestaLibro($idLibro, $idUtente, $idPersonale);";
            mysqli_query($con, $sql);
        }
    }
    echo "";
    require_once("var_connclose.php");
?>