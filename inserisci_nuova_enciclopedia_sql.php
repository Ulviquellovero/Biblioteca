<?php
    require_once("var_conn.php");
    if(isset($_POST["submit"]))
    {
        $titolo = $_POST["titolo"];
        $anno = $_POST["anno"];
        $isbn = $_POST["isbn"];
        $casaEditrice = $_POST["casaEditrice"];
        $scaffale = $_POST['scaffale'];
        $nVolumi = $_POST['nVolumi'];
        $nomiAutori = $_POST['nomeAutore'];
        $cognomiAutori = $_POST['cognomeAutore'];
        $sql = "INSERT INTO tenciclopedia (titolo, annoPubblicazione, nomeCasaEditrice, codiceScaffale, nVolumi) 
                VALUES ('$titolo', '$anno', '$casaEditrice', $scaffale, $nVolumi); ";
        mysqli_query($con, $sql);
        $idEnciclopedia = mysqli_insert_id($con);

        $sqlVolumi = "INSERT INTO tvolume (numero, ISBN, disponibile, idEnciclopedia) 
                VALUES ";
        for($idx = 1; $idx < $nVolumi + 1; ++$idx)
        {
            $parts = explode("-", $isbn);
            $prefix = $parts[0] . '-' . $parts[1] . '-' . $parts[2];
            $suffix = '-' . $parts[3];
            $idxFormatted = str_pad($idx, 2, '0', STR_PAD_LEFT);
            $isbnVolume = $prefix . '-' . $idxFormatted . $suffix;
            $sqlVolumi = $sqlVolumi . "($idx, '$isbnVolume', 1, $idEnciclopedia),";
        }
        $sqlVolumi = rtrim($sqlVolumi, ',');
        mysqli_query($con, $sqlVolumi);

        $queryAutori = "INSERT INTO tautoreenciclopedia (nome, cognome, idEnciclopedia) VALUES ";
        foreach ($nomiAutori as $index => $nomeAutore) 
        {
            $cognomeAutore = $cognomiAutori[$index];
            $queryAutori .= "('$nomeAutore', '$cognomeAutore', $idEnciclopedia),";
        }
        $queryAutori = rtrim($queryAutori, ',');
        mysqli_query($con, $queryAutori);
    }
    require_once("var_connclose.php");
    header("Location: catalogo.php");
?>