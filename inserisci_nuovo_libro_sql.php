<?php
    require_once("var_conn.php");
    if(isset($_POST["submit"]))
    {
        $titolo = $_POST["titolo"];
        $anno = $_POST["anno"];
        $isbn = $_POST["isbn"];
        $casaEditrice = $_POST["casaEditrice"];
        $scaffale = $_POST['scaffale'];
        $nomeAutore = $_POST['nomeAutore'];
        $cognomeAutore = $_POST['cognomeAutore'];
        $sql = "INSERT INTO tlibro (titolo, annoPubblicazione, ISBN, disponibile, nomeCasaEditrice, nomeAutore, cognomeAutore, codiceScaffale) 
                VALUES ('$titolo', '$anno', '$isbn', 1, '$casaEditrice', '$nomeAutore', '$cognomeAutore', $scaffale)";
        mysqli_query($con, $sql);
    }
    require_once("catalogo.php");
    header("Location: index.php");
?>