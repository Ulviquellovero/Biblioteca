<html>
    <head>
        <title>Le Mie Prenotazioni</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
        <link rel="stylesheet" href="css/le_mie_prenotazioni_style.css">
    </head>

    <body>
        <div id='header'>
            <?php
                require_once("header.php");
            ?>
        </div>
        <h1 id='titoloPagina'>Le Mie Prenotazioni</h1>
        <div id="sceltaCategoria">
            <button id='btnEnc'onclick="creaTabellaEnciclopedie();">Enciclopedie</button>
            <button id='btnLib' onclick="creaTabellaLibri();">Libri</button>
            <button id='btnCart' onclick="creaTabellaCarte();">Carte Geo-Politiche</button>
        </div>
        <div id='visualizzazione'>
            
        </div>

        <div id='footerLogin'>
            <?php require_once("footer.html"); ?>
        </div>
    </body>

    <script>
        creaTabellaLibri();
        function creaTabellaLibri()
        {
            tipoSelezionato = "Libri";
            var enc = document.getElementById("btnEnc");
            var lib = document.getElementById("btnLib");
            var car = document.getElementById("btnCart");
            enc.className = "catNonSelezionata";
            lib.className = "catSelezionata";
            car.className = "catNonSelezionata";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                visualizzazione.innerHTML = "";
                creaHtmlLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_prenotazione_libri.php", true);
            xhttp.send();
        }

        function creaTabellaCarte()
        {
            tipoSelezionato = "Carte";
            var enc = document.getElementById("btnEnc");
            var lib = document.getElementById("btnLib");
            var car = document.getElementById("btnCart");
            enc.className = "catNonSelezionata";
            lib.className = "catNonSelezionata";
            car.className = "catSelezionata";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                visualizzazione.innerHTML = "";
                creaHtmlLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_prenotazione_carte.php", true);
            xhttp.send();
        
        }

        function creaTabellaEnciclopedie()
        {
            tipoSelezionato = "Enciclopedie";
            var enc = document.getElementById("btnEnc");
            var lib = document.getElementById("btnLib");
            var car = document.getElementById("btnCart");
            enc.className = "catSelezionata";
            lib.className = "catNonSelezionata";
            car.className = "catNonSelezionata";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                visualizzazione.innerHTML = "";
                creaHtmlLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_prenotazione_volumi.php", true);
            xhttp.send();
        }
        
        function creaHtmlLibri(j, visualizzazione)
        {
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var containerLibro = document.createElement("div");
                        containerLibro.className = "containerElemento";

                            var titolo = document.createElement("h1");
                            titolo.className = "titoloLibro";
                            titolo.textContent = "Prenotazione per '"+j.Result[i].titolo+"'";
                            containerLibro.appendChild(titolo);

                            var containerDati = document.createElement("div");
                            containerDati.className = "containerDati";
                            containerLibro.appendChild(containerDati);
                            
                                var containerDate = document.createElement("div");
                                containerDate.className = "containerDate";
                                containerDati.appendChild(containerDate);

                                    var dataPrenotazione = document.createElement("span");
                                    dataPrenotazione.className = "datoLibro";
                                    dataPrenotazione.textContent = "Data di prenotazione: " + formattaData(j.Result[i].dataPrenotazione);
                                    containerDate.appendChild(dataPrenotazione);

                                    if(j.Result[i].dataPrestito != undefined)
                                    {
                                        var dataPrestito = document.createElement("span");
                                        dataPrestito.className = "datoLibro";
                                        dataPrestito.textContent = "Prestito concesso il giorno: " + formattaData(j.Result[i].dataPrestito);
                                        containerDate.appendChild(dataPrestito);
                                    }

                                var containerStato = document.createElement("div");
                                containerStato.className = "containerStato";
                                containerDati.appendChild(containerStato);

                                    var stato = document.createElement("span");
                                    if(j.Result[i].dataPrestito != undefined)
                                    {
                                        stato.className = "datoLibro concesso";
                                        stato.textContent = "Prestito concesso";
                                        containerStato.appendChild(stato);
                                        var commento = document.createElement("span");
                                        commento.className = "commentoGrigio";
                                        commento.textContent = "Se non lo si è già fatto, presentarsi in biblioteca per il ritiro. Alla restituzione la prenotazione verrà eliminata dalla lista in automatico.";
                                        containerStato.appendChild(commento);
                                    }
                                    else
                                    {
                                        stato.className = "datoLibro nonConcesso";
                                        stato.textContent = "In attesa di prestito";
                                        containerStato.appendChild(stato);
                                    }

                        visualizzazione.appendChild(containerLibro)
                    }
                }
                else
                {
                    var nessunRisultato = document.createElement("h1");
                    nessunRisultato.id = "noResult";
                    nessunRisultato.textContent = "Nessuna prenotazione trovata";
                    visualizzazione.appendChild(nessunRisultato);
                }
            }
            else
            {
                var nessunRisultato = document.createElement("h1");
                nessunRisultato.id = "noResult";
                nessunRisultato.textContent = "Nessuna prenotazione trovata";
                visualizzazione.appendChild(nessunRisultato);
            }
        }

        function formattaData(dataIniziale)
        {
            var partiData = dataIniziale.split("-");
            var nuovaData = new Date(partiData[0], partiData[1] - 1, partiData[2]);
            var giorno = nuovaData.getDate();
            var mese = nuovaData.getMonth() + 1;
            var anno = nuovaData.getFullYear();
            var dataFormattata = (giorno < 10 ? '0' : '') + giorno + '/' + (mese < 10 ? '0' : '') + mese + '/' + anno;
            return dataFormattata;
        }

    </script>
</html>