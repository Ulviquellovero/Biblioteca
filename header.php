<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/header_style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus:ital,wght@0,400;0,700;1,400;1,700&family=Goudy+Bookletter+1911&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id="parte_sinistra_header">
            <a href="index.php"><img id="logo" src="img/sapienza.png" alt="Logo Sapienza"></a>
            <a href="index.php"><h1 id="nome_software">Biblioteca Sapienza</h1></a>
            <?php require_once("decidi_link.php"); ?>
        </div>
        <div id="parte_destra_header">
            <?php
                if(!isset($_SESSION['idUtente']))
                {
                    echo "<a id='link_login' href='login.php'>";
                    echo "<img id='img_login' src='img/login_icon.png' alt='Login'>";
                    echo "</a>";
                }
                else
                    echo "<span id='benvenuto_utente'>Benvenuto ".$_SESSION['username']."</span>";
            ?>
        </div>
    </body>
</html>