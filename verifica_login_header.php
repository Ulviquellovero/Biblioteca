<?php
    require_once("var_conn.php");
    $userName = null;
    if(isset($_SESSION['idUtente']))
    {
        $autenticato = true;
        $userName    = $_SESSION['userName'];
    }
    else
        $autenticato = false;
    $row = array(
        "autenticato" => $autenticato,
        "userName" => $userName,
    );
    echo json_encode($row);
	require_once("var_connclose.php");
?>