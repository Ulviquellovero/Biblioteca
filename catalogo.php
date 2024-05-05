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
        <h1 id='titoloPagina'>Catalogo</h1>
        <div id="sceltaCategoria">
            <button id='btnEnc'onclick="azzeraFiltri(); creaTabellaEnciclopedie();">Enciclopedie</button>
            <button id='btnLib' onclick="azzeraFiltri(); creaFiltroAnnoLibri(); creaFiltroCaseLibri(); creaTabellaLibri();">Libri</button>
            <button id='btnCart' onclick="azzeraFiltri(); creaTabellaCarte();">Carte Geo-Politiche</button>
        </div>
        <div id="lineaFiltri">
            <div id='rigaTestiGuida'>
                <label for="filtroAnno">Cerca per anno: </label>
                <label for="filtroTitolo">Cerca per titolo: </label>
                <label for="filtroCasaEditrice">Cerca per casa editrice: </label>
            </div>
            <div id='contBoxFiltri'>
                <select id='filtroAnno' onchange="filtroAnnoSelezionato()">
                </select>
                <div id="divFiltroTitolo">
                    <input id='filtroTitolo' type="text">
                    <button onclick="btnCercaCliccato()">Cerca</button>
                </div>
                <select id='filtroCasaEditrice' onchange="filtroCasaSelezionato()">
                </select>
            </div>
        </div>
        <div id='visualizzazione'>
            
        </div>

        <div id='footerLogin'>
            <?php require_once("footer.html"); ?>
        </div>
    </body>

    <script>

        var tipoSelezionato = "Libri";
        var annoSelez = null;
        var casaSelez = null;
        var testoInserito = null;

        function btnCercaCliccato()
        {
            var filtroTitolo = document.getElementById("filtroTitolo");
            testoInserito = filtroTitolo.value;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
        }

        function azzeraFiltri()
        {
            annoSelez = null;
            casaSelez = null;
            testoInserito = null;
        }

        function filtroAnnoSelezionato()
        {
            var select = document.getElementById("filtroAnno");
            var selezionato = select.options[select.selectedIndex].value;
            annoSelez = selezionato;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
        }

        function filtroCasaSelezionato()
        {
            var select = document.getElementById("filtroCasaEditrice");
            var selezionato = select.options[select.selectedIndex].value;
            casaSelez = selezionato;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
        }

        function creaFiltroAnnoLibri()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroAnnoLibri(j);
            }
            xhttp.open("POST", "crea_filtro_anno_libri.php?tipo=libro", true);
            xhttp.send();
        }

        function creaFiltroAnnoEnciclopedie()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroAnnoLibri(j);
            }
            xhttp.open("POST", "crea_filtro_anno_libri.php?tipo=enciclopedia", true);
            xhttp.send();
        }

        function creaFiltroAnnoCarte()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroAnnoLibri(j);
            }
            xhttp.open("POST", "crea_filtro_anno_libri.php?tipo=carta", true);
            xhttp.send();
        }

        function creaHtmlFiltroAnnoLibri(j)
        {
            var filtroAnno = document.getElementById("filtroAnno");
            filtroAnno.innerHTML = "";
            var opzioneDef = document.createElement("option");
            opzioneDef.value = "null";
            opzioneDef.textContent = "Nessun anno selezionato";
            filtroAnno.appendChild(opzioneDef);
            for(var i=0; i < j.Result.length; i++)
            {
                var anno = j.Result[i].annoPub;
                var opzione = document.createElement("option");
                opzione.value = anno;
                opzione.textContent = anno;
                filtroAnno.appendChild(opzione);
            }
        }

        function creaFiltroCaseLibri()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroCaseLibri(j);
            }
            xhttp.open("POST", "crea_filtro_case_libri.php?tipo=libro", true);
            xhttp.send();
        }

        function creaFiltroCaseEnciclopedie()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroCaseLibri(j);
            }
            xhttp.open("POST", "crea_filtro_case_libri.php?tipo=enciclopedia", true);
            xhttp.send();
        }

        function creaFiltroCaseCarte()
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                creaHtmlFiltroCaseLibri(j);
            }
            xhttp.open("POST", "crea_filtro_case_libri.php?tipo=carta", true);
            xhttp.send();
        }

        function creaHtmlFiltroCaseLibri(j)
        {
            var filtroCasaEditrice = document.getElementById("filtroCasaEditrice");
            filtroCasaEditrice.innerHTML = "";
            var opzioneDef = document.createElement("option");
            opzioneDef.value = "null";
            opzioneDef.textContent = "Nessuna casa editrice selezionata";
            filtroCasaEditrice.appendChild(opzioneDef);
            for(var i=0; i < j.Result.length; i++)
            {
                var casa = j.Result[i].nomeCasaEditrice;
                var opzione = document.createElement("option");
                opzione.value = casa;
                opzione.textContent = casa;
                filtroCasaEditrice.appendChild(opzione);
            }
        }

        creaFiltroAnnoLibri();
        creaFiltroCaseLibri();
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
                creaHtmlLibri(j, visualizzazione, "libro");
            }
            xhttp.open("POST", "crea_catalogo_libri.php?annoSelez="+annoSelez+"&casaSelez="+casaSelez+"&testoInserito="+testoInserito, true);
            xhttp.send();
        }

        function creaTabellaCarte()
        {
            tipoSelezionato = "Carte";
            creaFiltroAnnoCarte();
            creaFiltroCaseCarte();
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
                creaHtmlLibri(j, visualizzazione, "carte");
            }
            xhttp.open("POST", "crea_catalogo_carte.php", true);
            xhttp.send();
        
        }

        function creaTabellaEnciclopedie()
        {
            tipoSelezionato = "Enciclopedie";
            creaFiltroAnnoEnciclopedie();
            creaFiltroCaseEnciclopedie();
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
                creaHtmlLibri(j, visualizzazione, "enciclopedie");
            }
            xhttp.open("POST", "crea_catalogo_enciclopedie.php", true);
            xhttp.send();
        }

        function creaHtmlLibri(j, visualizzazione, tipo)
        {
            if(j.Result != null)
            {
                for(var i=0; i < j.Result.length; i++)
                {
                    var containerLibro = document.createElement("div");
                    containerLibro.className = "containerElemento";
                    containerLibro.setAttribute("data-id", j.Result[i].id);
                    containerLibro.onclick = function() {
                        var id = this.getAttribute("data-id");
                        mostraLibro(tipo, id);
                    };

                        var titolo = document.createElement("h1");
                        titolo.className = "titoloLibro";
                        titolo.textContent = j.Result[i].titolo;
                        containerLibro.appendChild(titolo);

                        var containerDati = document.createElement("div");
                        containerDati.className = "containerDati";
                        containerLibro.appendChild(containerDati);
                        
                            var containerDataCasa = document.createElement("div");
                            containerDataCasa.className = "containerDataCasa";
                            containerDati.appendChild(containerDataCasa);

                                var nomeAutore = document.createElement("span");
                                nomeAutore.className = "datoLibro";
                                nomeAutore.textContent = "Autori: " + j.Result[i].autore;
                                containerDataCasa.appendChild(nomeAutore);

                                var nomeCasaEditrice = document.createElement("span");
                                nomeCasaEditrice.className = "datoLibro";
                                nomeCasaEditrice.textContent = "Casa editrice: " + j.Result[i].nomeCasaEditrice;
                                containerDataCasa.appendChild(nomeCasaEditrice);

                            var containerAutoreDisponibile = document.createElement("div");
                            containerAutoreDisponibile.className = "containerAutoreDisponibile";
                            containerDati.appendChild(containerAutoreDisponibile);

                                var annoPub = document.createElement("span");
                                annoPub.className = "datoLibro";
                                annoPub.textContent = "Anno di pubblicazione: " + j.Result[i].annoPub;
                                containerAutoreDisponibile.appendChild(annoPub);
                                if (j.Result[i].volumi !== undefined)
                                {
                                    var nVolumi = document.createElement("span");
                                    nVolumi.className = "datoLibro";
                                    nVolumi.textContent = "Numero di volumi: " + j.Result[i].volumi;
                                    containerAutoreDisponibile.appendChild(nVolumi);
                                }
                                else
                                {
                                    var disponibile = document.createElement("span");
                                    if(j.Result[i].disponibile == 1)
                                    {
                                        disponibile.className = "datoLibro disponibile";
                                        disponibile.textContent = "Disponibile";
                                    }
                                    else
                                    {
                                        disponibile.className = "datoLibro nonDisponibile";
                                        disponibile.textContent = "Non disponibile";
                                    }
                                    containerAutoreDisponibile.appendChild(disponibile);
                                }

                    visualizzazione.appendChild(containerLibro);
                }
            }
            else
            {
                var nessunRisultato = document.createElement("h1");
                nessunRisultato.id = "noResult";
                nessunRisultato.textContent = "Nessun risultato trovato corrispondente alla ricerca";
                visualizzazione.appendChild(nessunRisultato);
            }
        }

        function mostraLibro(tipo, id)
        {
            window.location.href = "dettaglio_elemento.php?tipo="+ tipo +"&id=" + id;
        }
    </script>
</html>