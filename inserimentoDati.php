<?php
    require_once("var_conn.php");
    if(isset($_POST["submit"]))
    {
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $codiceFiscale = $_POST["codiceFiscale"];
        $email = $_POST["email"];
        $numTelefoni = $_POST['numTelefoni'];
        $arrayNumeriTelefono = array();
        foreach ($numTelefoni as $telefono)
            $arrayNumeriTelefono[] = $telefono;
        $password = $_POST["password"];
        $sql = "INSERT INTO tutente (codiceFiscale, nome, cognome, email, password) VALUES ('$codiceFiscale', '$nome', '$cognome', '$email', '$password')";
        mysqli_query($con, $sql);

        $sql = "SELECT idUtente, nome FROM tutente WHERE email = '$email' AND passWord = '$password'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) == 1)
        {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['idUtente'] = $row['idUtente'];
            $_SESSION['userName'] = $row['nome']; 
            $_SESSION['permessi'] = false; 
        }

        $dimensioneArray = count($arrayNumeriTelefono);
        $idUtente = $_SESSION['idUtente'];
        for($idx = 0; $idx < $dimensioneArray; $idx++)
        {
            $numero = $arrayNumeriTelefono[$idx];
            $sql = "INSERT INTO ttelefono (numero, idUtente) VALUES ('$numero', $idUtente)";
            mysqli_query($con, $sql);
        }
    }
    require_once("var_connclose.php");
    header("Location: index.php");
?>