<?php
    require_once("var_conn.php");
    if(isset($_REQUEST['username']))
    {
        $username = $_REQUEST['username'];
        if(isset($_REQUEST['password']))
        {
            $password = $_REQUEST['password'];
            $sql = "SELECT idUtente, nome FROM tutente WHERE email = '$username' AND passWord = '$password'";
            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) == 1)
            {
                $row = mysqli_fetch_assoc($res);
                $_SESSION['idUtente'] = $row['idUtente'];
                $_SESSION['userName'] = $row['nome']; 
                $_SESSION['permessi'] = "false"; 
                $autenticato = true;
            }
            else 
            {
                $sql = "SELECT idPersonale, nomeUtente FROM tpersonale WHERE nomeUtente = '$username' AND passWord = '$password'";
                $res = mysqli_query($con, $sql);
                if(mysqli_num_rows($res) == 1)
                {
                    $row = mysqli_fetch_assoc($res);
                    $_SESSION['idUtente'] = $row['idPersonale'];
                    $_SESSION['userName'] = $row['nomeUtente']; 
                    $_SESSION['permessi'] = "true"; 
                    $autenticato = true;
                }
                else
                    $autenticato = false;
            }
        }
        else
            $autenticato = false;
    }
    else
        $autenticato = false;
    $rowJSON = array(
        "autenticato" => $autenticato,
    );
    echo json_encode($rowJSON);
    require_once("var_connclose.php");
?>