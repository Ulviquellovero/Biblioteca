<?php
    require_once("var_conn.php");
    $userName = null;
    $permessi = null;
    if(isset($_SESSION['idUtente']))
    {
        $autenticato = true;
        $userName    = $_SESSION['userName'];
        $permessi    = $_SESSION['permessi'];
    }
    else
        $autenticato = false;
    $row = array(
        "autenticato" => $autenticato,
        "userName" => $userName,
        "permessi" => $permessi,
    );
    echo json_encode($row);
	require_once("var_connclose.php");
?>