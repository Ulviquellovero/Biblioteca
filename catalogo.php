<html>
    <head>
        <title>Catalogo</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
        <link rel="stylesheet" href="css/catalogo_style.css">
    </head>

    <body>
        <div id='header'>
            <?php
                require_once("header.php");
            ?>
        </div>
        <div id='visualizzazione'>
            
        </div>
    </body>

    <script>
        creaTabellaLibri();
        function creaTabellaLibri()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                visualizzazione.innerHTML = "";

                for(var i=0; i < j.Result.length; i++)
                {
                    var titolo = document.createElement("h1");
                    titolo.className = "titoloLibro";
                    titolo.textContent = j.Result[i].titolo;
                    visualizzazione.appendChild(titolo);
                }
            }
            xhttp.open("POST", "crea_catalogo_libri.php", true);
            xhttp.send();
        }
    </script>
</html>