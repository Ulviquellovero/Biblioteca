<?php
    require_once("var_conn.php");
    if(isset($_POST["submit"]))
    {
        $titolo = $_POST["titolo"];
        $anno = $_POST["anno"];
        $isbn = $_POST["isbn"];
        $casaEditrice = $_POST["casaEditrice"];
        $scaffale = $_POST['scaffale'];
        $annoRiferimento = $_POST['annoRiferimento'];
        $nomiAutori = $_POST['nomeAutore'];
        $cognomiAutori = $_POST['cognomeAutore'];
        $sql = "INSERT INTO tcarta (titolo, annoPubblicazione, ISBN, disponibile, nomeCasaEditrice, codiceScaffale, annoRiferimento) 
                VALUES ('$titolo', '$anno', '$isbn', 1, '$casaEditrice', $scaffale, '$annoRiferimento'); ";
        mysqli_query($con, $sql);
        $idCarta = mysqli_insert_id($con);

        $queryAutori = "INSERT INTO tautorecarta (nome, cognome, idCarta) VALUES ";
        foreach ($nomiAutori as $index => $nomeAutore) 
        {
            $cognomeAutore = $cognomiAutori[$index];
            $queryAutori .= "('$nomeAutore', '$cognomeAutore', $idCarta),";
        }
        $queryAutori = rtrim($queryAutori, ',');
        mysqli_query($con, $queryAutori);
    }
    require_once("var_connclose.php");
    header("Location: catalogo.php");
?>