<?php
    require_once("var_conn.php");   
    unset($_SESSION['idUtente']);
    unset($_SESSION['userName']);
    unset($_SESSION['permessi']);
    header("Location: index.php");
    require_once("var_connclose.php");
?>