<?php
    require_once("var_conn.php");
    if (isset($_SESSION['permessi'])) 
    {
        if ($_SESSION['permessi'] == "false") 
        {
            header('Location: index.php');
            exit();
        }
    }
    else
    {
        header('Location: index.php');
        exit();
    }
    require_once("var_connclose.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/nuovo_libro_style.css">
        <title>Nuovo Libro</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
    </head>
    <body>

        <?php require_once("header.php"); ?>

        <button id='btnIndietro' onclick="btnIndietroCliccato()">Indietro</button>
        <h1 id='titoloPagina'>Nuovo Libro</h1>

        <div id = "input">

            <form action="inserisci_nuovo_libro_sql.php" method="POST" class = "loginForm">
            <div class="riga">
                <label class="elemento" for="titoloElemento">Inserisci il titolo:</label>
                <label class="elemento" for="annoPubblicazione">Inserisci l'anno di pubblicazione:</label>
            </div>
            <div class="riga">
                
                <input type="text" minlength="4" class="elemento" id='titoloElemento' name="titolo" placeholder="Es. Harry Potter e la Pietra Filosofale" required>
                <input type="number" class="elemento" min="1000" max="2024" id='annoPubblicazione' name="anno" placeholder="Es. 1997" required>
            </div>
            <div class="riga">
                <label class="elemento" for="isbn">Inserisci l'ISBN:</label>
                <label class="elemento" for="casaEditrice">Inserisci il nome della casa editrice:</label>
            </div>
            <div class="riga">
                <input type="text" class="elemento" id="isbn" name="isbn" minlength="17" maxlength="17" placeholder="Es. 978-88-77827-02-9" required>
                <input type="text" minlength="4" class="elemento" id='casaEditrice' name="casaEditrice" placeholder="Es. Bloomsbury" required>
            </div>
            <div class="riga">
                <label class="elemento" for="scaffale">Seleziona il codice dello scaffale dove verrà posizionato il libro:</label>
            </div>
            <div class="riga">
                <select class="elementoSelect" id="scaffale" name="scaffale" required>
                    <option value="" disabled selected>Nessun scaffale selezionato</option>
                </select>
            </div>

            <div class="riga">
                <label class="elemento" for="nomeAutore">Inserisci il nome dell'autore:</label>
                <label class="elemento" for="cognomeAutore">Inserisci il cognome dell'autore:</label>
            </div>

            <div class="riga">
                <input class="elemento" type="text" id="nomeAutore" name="nomeAutore" placeholder="Es. Joanne" minlength="4" required>
                <input class="elemento" type="text" id="cognomeAutore" placeholder="Es. Rowling" name="cognomeAutore" minlength="4" required>
            </div>

            <input id="submit" type="submit" name="submit" value="Aggiungi Libro">
            </form>

        </div>

        <?php require_once("footer.html"); ?>

        <script>

            creaSelectScaffale();

            function creaSelectScaffale()
            {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    var res = xhttp.responseText;
                    var j = JSON.parse(res);
                    creaHtmlSelectScaffale(j);
                }
                xhttp.open("POST", "crea_select_scaffale_libro.php", true);
                xhttp.send();
            }

            function creaHtmlSelectScaffale(j)
            {
                var filtroAnno = document.getElementById("scaffale");
                filtroAnno.innerHTML = "";
                for(var i=0; i < j.Result.length; i++)
                {
                    var codiceScaffale = j.Result[i].codiceScaffale;
                    var opzione = document.createElement("option");
                    opzione.value = codiceScaffale;
                    opzione.textContent = "Scaffale numero " + codiceScaffale;
                    filtroAnno.appendChild(opzione);
                }
            }

            function btnIndietroCliccato()
            {
                window.location.href = "catalogo.php";
            }
        </script>
    </body>
</html>