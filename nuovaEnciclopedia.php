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
        <link rel="stylesheet" type="text/css" href="css/nuova_enciclopedia_style.css">
        <title>Nuova Enciclopedia</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>

        <?php require_once("header.php"); ?>

        <button id='btnIndietro' onclick="btnIndietroCliccato()">Indietro</button>
        <h1 id='titoloPagina'>Nuova Enciclopedia</h1>

        <div id = "input">

            <form action="inserisci_nuova_enciclopedia_sql.php" method="POST" class = "loginForm" onsubmit="return validateAuthors()">
            <div class="riga">
                <label class="elemento" for="titoloElemento">Inserisci il titolo:</label>
                <label class="elemento" for="annoPubblicazione">Inserisci l'anno di pubblicazione:</label>
            </div>
            <div class="riga">
                
                <input type="text" minlength="4" class="elemento" id='titoloElemento' name="titolo" placeholder="Es. Enciclopedia Universale" required>
                <input type="number" class="elemento" min="1901" max="2024" id='annoPubblicazione' name="anno" placeholder="Es. 1989" required>
            </div>
            <div class="riga">
                <label class="elemento" for="isbn">Inserisci l'ISBN generale dei volumi (L'identificatore del titolo verrà inserito in automatico in base al numero del volume):</label>
                <label class="elemento" for="casaEditrice">Inserisci il nome della casa editrice:</label>
            </div>
            <div class="riga">
                <input type="text" class="elemento" id="isbn" name="isbn" minlength="14" maxlength="14" placeholder="Es. 985-53-54636-5 (Omettere 985-53-54636-nn-5)" required>
                <input type="text" minlength="4" class="elemento" id='casaEditrice' name="casaEditrice" placeholder="Es. Rizzoli" required>
            </div>
            <div class="riga">
                <label class="elemento" for="scaffale">Seleziona il codice dello scaffale dove verrà posizionata l'enciclopedia:</label>
                <label class="elemento" for="nVolumi">Inserisci il numero di volumi da cui è composta l'enciclopedia:</label>
            </div>
            <div class="riga">
                <select class="elemento" id="scaffale" name="scaffale" required>
                    <option value="" disabled selected>Nessun scaffale selezionato</option>
                </select>
                <input type="number" class="elemento" min="2" max="30" id='nVolumi' name="nVolumi" placeholder="Es. 26" required>
            </div>

            <div id="authorsContainer">
                <div class="riga author-row">
                    <label class="elemento" for="nomeAutore">Inserisci il nome dell'autore:</label>
                    <label class="elemento" for="cognomeAutore">Inserisci il cognome dell'autore:</label>
                    <div id="space"></div>
                </div>
                <div class="riga author-row">
                    <input class="elemento" id="nomeAutore" type="text" name="nomeAutore[]" placeholder="Es. Oliver" minlength="4" required>
                    <input class="elemento" id="cognomeAutore" type="text" name="cognomeAutore[]" placeholder="Es. Smith" minlength="4" required>
                    <div id="space"></div>
                </div>
            </div>

            <button id='aggiungiAutore' type="button" onclick="addAuthor()">Aggiungi Autore</button>

            <input id="submit" type="submit" name="submit" value="Aggiungi Enciclopedia">
            </form>

        </div>

        <?php require_once("footer.html"); ?>

        <script>

        function addAuthor() {
            const authorsContainer = document.getElementById('authorsContainer');
            const authorRow = document.createElement('div');
            authorRow.className = 'riga author-row';

            const inputNome = document.createElement('input');
            inputNome.className = 'elemento';
            inputNome.type = 'text';
            inputNome.name = 'nomeAutore[]';
            inputNome.placeholder = 'Es. Oliver';
            inputNome.minLength = 4;
            inputNome.required = true;

            const inputCognome = document.createElement('input');
            inputCognome.className = 'elemento';
            inputCognome.type = 'text';
            inputCognome.name = 'cognomeAutore[]';
            inputCognome.placeholder = 'Es. Smith';
            inputCognome.minLength = 4;
            inputCognome.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'removeAuthor';
            removeButton.innerText = '-';
            removeButton.onclick = function() {
                removeAuthor(this);
            };

            authorRow.appendChild(inputNome);
            authorRow.appendChild(inputCognome);
            authorRow.appendChild(removeButton);

            authorsContainer.appendChild(authorRow);
        }

        function removeAuthor(button) {
            const authorRow = button.parentElement;
            authorRow.remove();
        }

            creaSelectScaffale();

            function creaSelectScaffale()
            {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    var res = xhttp.responseText;
                    var j = JSON.parse(res);
                    creaHtmlSelectScaffale(j);
                }
                xhttp.open("POST", "crea_select_scaffale_enciclopedia.php", true);
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

            function validateAuthors() {
                const authorRows = document.querySelectorAll('.author-row');
                const authors = [];

                for (let i = 0; i < authorRows.length; i++) {
                    const row = authorRows[i];
                    const nome = row.querySelector('input[name="nomeAutore[]"]');
                    const cognome = row.querySelector('input[name="cognomeAutore[]"]');
                    if (nome && cognome) {
                        const fullName = `${nome.value.trim()} ${cognome.value.trim()}`;
                        if (authors.includes(fullName)) {
                            Swal.fire({
                                icon: "error",
                                title: "Impossibile aggiungere l'enciclopedia!",
                                text: "Impossibile aggiungere l'enciclopedia! Ci sono degli autori con lo stesso nome e cognome."
                            });
                            return false;
                        }
                        authors.push(fullName);
                    }
                }

                return true;
            }

        </script>
    </body>
</html>