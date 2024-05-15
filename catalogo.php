<html>
    <head>
        <title>Catalogo</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
        <link rel="stylesheet" href="css/catalogo_style.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <div id='header'>
            <?php
                require_once("header.php");
            ?>
        </div>
        <h1 id='titoloPagina'>Catalogo</h1>
        <button id='btnIndietro' onclick="btnIndietroCliccato()">Indietro</button>
        <div id="sceltaCategoria">
            <button id='btnEnc'onclick="resettaCambiamentiVolumi(); azzeraFiltri(); creaFiltroAnnoEnciclopedie(); creaFiltroCaseEnciclopedie(); creaTabellaEnciclopedie();">Enciclopedie</button>
            <button id='btnLib' onclick="resettaCambiamentiVolumi(); azzeraFiltri(); creaFiltroAnnoLibri(); creaFiltroCaseLibri(); creaTabellaLibri();">Libri</button>
            <button id='btnCart' onclick="resettaCambiamentiVolumi(); azzeraFiltri(); creaFiltroAnnoCarte(); creaFiltroCaseCarte(); creaTabellaCarte();">Carte Geo-Politiche</button>
        </div>
        <div id="lineaFiltri">
            <div id='rigaTestiGuida'>
                <label for="filtroAnno">Cerca per anno: </label>
                <label id="labelForTitolo" for="filtroTitolo">Cerca per titolo: </label>
                <label id="labelForCasa" for="filtroCasaEditrice">Cerca per casa editrice: </label>
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
        var idVolumeIndietro = null;

        function btnIndietroCliccato()
        {
            if(tipoSelezionato == "Libri")
            {
                resettaCambiamentiVolumi();
                azzeraFiltri();
                creaFiltroAnnoLibri();
                creaFiltroCaseLibri();
                creaTabellaLibri();
            }
            if(tipoSelezionato == "Volumi")
            {
                resettaCambiamentiVolumi();
                azzeraFiltri();
                creaFiltroAnnoEnciclopedie();
                creaFiltroCaseEnciclopedie();
                creaTabellaEnciclopedie();
            }
            if(tipoSelezionato == "mostraVolumi")
            {
                creaCatalogoVolumi(idVolumeIndietro);
                console.log("Passato");
            }
            if(tipoSelezionato == "Carte")
            {
                resettaCambiamentiVolumi();
                azzeraFiltri();
                creaFiltroAnnoCarte();
                creaFiltroCaseCarte();
                creaTabellaCarte();
            }
        }

        function btnCercaCliccato()
        {
            var filtroTitolo = document.getElementById("filtroTitolo");
            testoInserito = filtroTitolo.value;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
            if(tipoSelezionato == "Enciclopedie")
                creaTabellaEnciclopedie();
            if(tipoSelezionato == "Carte")
                creaTabellaCarte();
        }

        function azzeraFiltri()
        {
            annoSelez = null;
            casaSelez = null;
            testoInserito = null;
            var filtroTitolo = document.getElementById("filtroTitolo");
            filtroTitolo.value = "";
        }

        function filtroAnnoSelezionato()
        {
            var select = document.getElementById("filtroAnno");
            var selezionato = select.options[select.selectedIndex].value;
            annoSelez = selezionato;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
            if(tipoSelezionato == "Enciclopedie")
                creaTabellaEnciclopedie();
            if(tipoSelezionato == "Carte")
                creaTabellaCarte();
        }

        function filtroCasaSelezionato()
        {
            var select = document.getElementById("filtroCasaEditrice");
            var selezionato = select.options[select.selectedIndex].value;
            casaSelez = selezionato;
            if(tipoSelezionato == "Libri")
                creaTabellaLibri();
            if(tipoSelezionato == "Enciclopedie")
                creaTabellaEnciclopedie();
            if(tipoSelezionato == "Carte")
                creaTabellaCarte();
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
            xhttp.open("POST", "crea_catalogo_carte.php?annoSelez="+annoSelez+"&casaSelez="+casaSelez+"&testoInserito="+testoInserito, true);
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
                creaHtmlLibri(j, visualizzazione, "enciclopedie");
            }
            xhttp.open("POST", "crea_catalogo_enciclopedie.php?annoSelez="+annoSelez+"&casaSelez="+casaSelez+"&testoInserito="+testoInserito, true);
            xhttp.send();
        }

        function creaHtmlLibri(j, visualizzazione, tipo)
        {
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var containerLibro = document.createElement("div");
                        containerLibro.className = "containerElemento";
                        containerLibro.setAttribute("data-id", j.Result[i].id);
                        containerLibro.onclick = function() {
                            var id = this.getAttribute("data-id");
                            if(tipoSelezionato == "Libri")
                                mostraLibro(id);
                            if(tipoSelezionato == "Carte")
                                mostraCarta(id);
                            if(tipoSelezionato == "Enciclopedie")
                                creaCatalogoVolumi(id);
                        };

                        if(j.Result[i].permessi != undefined)
                        {
                            if(j.Result[i].permessi == "true" && j.Result[i].notifica == "true")
                            {
                                var notifica = document.createElement("span");
                                notifica.className = "notificaLibro";
                                notifica.textContent = "Prenotazione in attesa di conferma!";
                                containerLibro.appendChild(notifica);
                            }
                        }

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
                                            disponibile.textContent = "Disponibile in biblioteca";
                                        }
                                        else
                                        {
                                            disponibile.className = "datoLibro nonDisponibile";
                                            disponibile.textContent = "In prestito";
                                        }
                                        containerAutoreDisponibile.appendChild(disponibile);
                                    }

                        visualizzazione.appendChild(containerLibro)
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
            else
            {
                var nessunRisultato = document.createElement("h1");
                nessunRisultato.id = "noResult";
                nessunRisultato.textContent = "Nessun risultato trovato corrispondente alla ricerca";
                visualizzazione.appendChild(nessunRisultato);
            }
            if(j.Result[0].permessi != undefined)
            {
                if(j.Result[0].permessi == "true")
                {
                    var btnAggiungiLibro = document.createElement("button");
                    btnAggiungiLibro.id = "btnAggiungiLibro";
                    btnAggiungiLibro.textContent = "+";
                    visualizzazione.appendChild(btnAggiungiLibro);
                    var titoloPagina = document.getElementById("titoloPagina");
                    titoloPagina.textContent = "Catalogo, Prenotazioni e Prestiti";
                }
            }
        }

        function mostraLibro(id)
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
                creaHtmlDettagli(j, visualizzazione);
            }
            xhttp.open("POST", "dettaglio_libro.php?id=" + id, true);
            xhttp.send();
        }

        function mostraCarta(id)
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
                creaHtmlDettagli(j, visualizzazione);
            }
            xhttp.open("POST", "dettaglio_carta.php?id=" + id, true);
            xhttp.send();
        }

        function mostraVolumi(id)
        {
            tipoSelezionato = "mostraVolumi";
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
                creaHtmlDettagli(j, visualizzazione);
            }
            xhttp.open("POST", "dettaglio_volume.php?id=" + id, true);
            xhttp.send();
        }
        
        function creaHtmlDettagli(j, visualizzazione)
        {
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    var titoloPagina = document.getElementById("titoloPagina");
                    titoloPagina.textContent = " ";
                    var lineaFiltri = document.getElementById("lineaFiltri");
                    lineaFiltri.style.display = "none";
                    var btnIndietro = document.getElementById("btnIndietro");
                    btnIndietro.style.display = "block";
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var divDettagli = document.createElement("div");
                        divDettagli.id = "divDettagli";

                        var titoloPagina = document.createElement("h1");
                        titoloPagina.id = "titoloPagina";
                        if(j.Result[i].numero != undefined)
                            titoloPagina.textContent = j.Result[i].titolo + " Volume " + j.Result[i].numero;
                        else
                            titoloPagina.textContent = j.Result[i].titolo;
                        divDettagli.appendChild(titoloPagina);
                        
                        var annoPub = document.createElement("h2");
                        annoPub.className = "elementoDettagli";
                        annoPub.textContent = "Anno di pubblicazione: "+j.Result[i].annoPub;
                        divDettagli.appendChild(annoPub);

                        if(j.Result[i].annoRif != undefined)
                        {
                            var annoRif = document.createElement("h2");
                            annoRif.className = "elementoDettagli";
                            annoRif.textContent = "Anno di riferimento: "+j.Result[i].annoRif;
                            divDettagli.appendChild(annoRif);
                        }

                        var autore = document.createElement("h2");
                        autore.className = "elementoDettagli";
                        autore.textContent = "Autori: "+j.Result[i].autore;
                        divDettagli.appendChild(autore);

                        var nomeCasaEditrice = document.createElement("h2");
                        nomeCasaEditrice.className = "elementoDettagli";
                        nomeCasaEditrice.textContent = "Casa editrice: "+j.Result[i].nomeCasaEditrice;
                        divDettagli.appendChild(nomeCasaEditrice);

                        if(j.Result[i].nVolumi != undefined)
                        {
                            var nVolumi = document.createElement("h2");
                            nVolumi.className = "elementoDettagli";
                            nVolumi.textContent = "Numero di volumi dell'enciclopedia: "+j.Result[i].nVolumi;
                            divDettagli.appendChild(nVolumi);
                        }

                        var isbn = document.createElement("h2");
                        isbn.className = "elementoDettagli";
                        isbn.textContent = "ISBN: "+j.Result[i].ISBN;
                        divDettagli.appendChild(isbn);

                        visualizzazione.appendChild(divDettagli);

                        if(j.Result[i].permessi == "true")
                        {
                            var divPosizione = document.createElement("div");
                            divPosizione.id = "divPosizione";

                            var titoloPagina = document.createElement("h1");
                            titoloPagina.textContent = "Posizione Fisica nella Biblioteca";
                            divPosizione.appendChild(titoloPagina);

                            var codiceScaffale = document.createElement("h2");
                            codiceScaffale.className = "elementoDettagli";
                            codiceScaffale.textContent = "Numero scaffale: "+j.Result[i].codiceScaffale;
                            divPosizione.appendChild(codiceScaffale);

                            var identificativoArmadio = document.createElement("h2");
                            identificativoArmadio.className = "elementoDettagli";
                            identificativoArmadio.textContent = "Armadio: "+j.Result[i].identificativoArmadio;
                            divPosizione.appendChild(identificativoArmadio);

                            var identificativoStanza = document.createElement("h2");
                            identificativoStanza.className = "elementoDettagli";
                            identificativoStanza.textContent = "Stanza: "+j.Result[i].identificativoStanza;
                            divPosizione.appendChild(identificativoStanza);

                            visualizzazione.appendChild(divPosizione);

                            var divDettagliPrestito = document.createElement("div");
                            divDettagliPrestito.id = "divPosizione";

                            var titoloSezione = document.createElement("h1");
                            titoloSezione.textContent = "Dettagli Riguardanti il Prestito";
                            divDettagliPrestito.appendChild(titoloSezione);

                            if(j.Result[i].nomeUtentePersonaleErogatore != undefined)
                            {
                                var nomeUtente = document.createElement("h2");
                                nomeUtente.className = "elementoDettagli";
                                nomeUtente.textContent = "Destinatario del prestito: "+j.Result[i].nomeUtente;
                                divDettagliPrestito.appendChild(nomeUtente);

                                var codiceFiscale = document.createElement("h2");
                                codiceFiscale.className = "elementoDettagli";
                                codiceFiscale.textContent = "Codice fiscale del destinatario: "+j.Result[i].codiceFiscale;
                                divDettagliPrestito.appendChild(codiceFiscale);

                                var data = document.createElement("h2");
                                data.className = "elementoDettagli";
                                data.textContent = "Data del prestito: " + formatData(j.Result[i].data);
                                divDettagliPrestito.appendChild(data);
                                
                                var nomeUtentePersonaleErogatore = document.createElement("h2");
                                nomeUtentePersonaleErogatore.className = "elementoDettagli";
                                nomeUtentePersonaleErogatore.textContent = "Erogatore del prestito: " + j.Result[i].nomeUtentePersonaleErogatore;
                                divDettagliPrestito.appendChild(nomeUtentePersonaleErogatore);

                                var nomeUtentePersonaleConsegna = document.createElement("h2");
                                nomeUtentePersonaleConsegna.className = "elementoDettagli";
                                nomeUtentePersonaleConsegna.textContent = "Addetto alla consegna: " + j.Result[i].nomeUtentePersonaleConsegna;
                                divDettagliPrestito.appendChild(nomeUtentePersonaleConsegna);

                                var btnRevoca = document.createElement("button");
                                btnRevoca.id = "btnRevoca";
                                btnRevoca.textContent = "Contrassegna come restituito";
                                btnRevoca.setAttribute("libro-id", j.Result[i].id);
                                btnRevoca.setAttribute("utente-id", j.Result[i].idUtente);
                                btnRevoca.onclick = function() {
                                    var idLibro = this.getAttribute("libro-id");
                                    var idUtente = this.getAttribute("utente-id");
                                    revocaPrestito(idLibro, idUtente);
                                };
                                divDettagliPrestito.appendChild(btnRevoca);
                            }
                            else
                            {
                                var nomeUtente = document.createElement("h2");
                                nomeUtente.className = "elementoDettagli";
                                nomeUtente.textContent = "L'elemento non è in prestito";
                                divDettagliPrestito.appendChild(nomeUtente);
                            }
                            visualizzazione.appendChild(divDettagliPrestito);
                        }

                        if(j.Result[i].permessi == "false")
                        {
                            var prenotaBtn = document.createElement("button");
                            prenotaBtn.id = "prenotaBtn";
                            prenotaBtn.textContent = "Prenota";
                            if(j.Result[i].userId != undefined)
                            {
                                if (j.Result[i].tipo == "volumi") {
                                    var idVolume = j.Result[i].id;
                                    function prenotaVolumeClick(id) {
                                        return function() {
                                            prenotaVolume(id);
                                        };
                                    }
                                    prenotaBtn.addEventListener("click", prenotaVolumeClick(idVolume));
                                }
                                if (j.Result[i].tipo == "libri") {
                                    var idLibro = j.Result[i].id;
                                    function prenotaLibroClick(id) {
                                        return function() {
                                            prenotaLibro(id);
                                        };
                                    }
                                    prenotaBtn.addEventListener("click", prenotaLibroClick(idLibro));
                                }
                                if (j.Result[i].tipo == "carte") {
                                    var idCarta = j.Result[i].id;
                                    function prenotaCartaClick(id) {
                                        return function() {
                                            prenotaCarta(id);
                                        };
                                    }
                                    prenotaBtn.addEventListener("click", prenotaCartaClick(idCarta));
                                }
                            }
                            else
                            {
                                prenotaBtn.addEventListener("click", function() {
                                    window.location.href = "login.php";
                                });
                            }
                            visualizzazione.appendChild(prenotaBtn);
                        }
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
            else
            {
                var nessunRisultato = document.createElement("h1");
                nessunRisultato.id = "noResult";
                nessunRisultato.textContent = "Nessun risultato trovato corrispondente alla ricerca";
                visualizzazione.appendChild(nessunRisultato);
            }
        }
        
        function revocaPrestito(idLibro, idUtente)
        {
            alert(idLibro);
            alert(idUtente);
            Swal.fire({
                title: "Sei sicuro di voler contrassegnare come restituito il prestito?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, contrassegna"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                        title: "Prestito contrassegnato come restituito!",
                        text: "Il prestito è appena stato contrassegnato come restituito",
                        icon: "success"
                    });
                }
            });
        }

        function formatData(data) {
            var parts = data.split('-');
            return parts[2] + '/' + parts[1] + '/' + parts[0];
        }
        
        function creaCatalogoVolumi(id)
        {
            idVolumeIndietro = id;
            tipoSelezionato = "Volumi";
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
                creaHtmlVolumi(j, visualizzazione);
            }
            xhttp.open("POST", "crea_catalogo_volumi.php?id="+id, true);
            xhttp.send();
        }

        function creaHtmlVolumi(j, visualizzazione)
        {
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    var titoloPagina = document.getElementById("titoloPagina");
                    titoloPagina.textContent = "Volumi per '"+j.Result[0].titolo+"'";
                    var lineaFiltri = document.getElementById("lineaFiltri");
                    lineaFiltri.style.display = "none";
                    var btnIndietro = document.getElementById("btnIndietro");
                    btnIndietro.style.display = "block";
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var containerLibro = document.createElement("div");
                        containerLibro.className = "containerElemento";
                        containerLibro.setAttribute("data-id", j.Result[i].id);
                        containerLibro.onclick = function() {
                            var id = this.getAttribute("data-id");
                            mostraVolumi(id);
                        };

                        if(j.Result[i].permessi != undefined)
                        {
                            if(j.Result[i].permessi == "true" && j.Result[i].notifica == "true")
                            {
                                var notifica = document.createElement("span");
                                notifica.className = "notificaLibro";
                                notifica.textContent = "Prenotazione in attesa di conferma!";
                                containerLibro.appendChild(notifica);
                            }
                        }

                        var titolo = document.createElement("h1");
                        titolo.className = "titoloLibro";
                        titolo.textContent = "Volume numero "+j.Result[i].numero;
                        containerLibro.appendChild(titolo);

                        var disponibile = document.createElement("span");
                        if(j.Result[i].disponibile == 1)
                        {
                            disponibile.className = "datoLibro disponibile";
                            disponibile.textContent = "Disponibile in biblioteca";
                        }
                        else
                        {
                            disponibile.className = "datoLibro nonDisponibile";
                            disponibile.textContent = "In prestito";
                        }
                        containerLibro.appendChild(disponibile);

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
            else
            {
                var nessunRisultato = document.createElement("h1");
                nessunRisultato.id = "noResult";
                nessunRisultato.textContent = "Nessun risultato trovato corrispondente alla ricerca";
                visualizzazione.appendChild(nessunRisultato);
            }
            if(j.Result[0].permessi != undefined)
            {
                if(j.Result[0].permessi == "true")
                {
                    var btnAggiungiLibro = document.createElement("button");
                    btnAggiungiLibro.id = "btnAggiungiLibro";
                    btnAggiungiLibro.textContent = "+";
                    visualizzazione.appendChild(btnAggiungiLibro);
                    var titoloPagina = document.getElementById("titoloPagina");
                    titoloPagina.textContent = "Catalogo, Prenotazioni e Prestiti";
                }
            }
        }

        function resettaCambiamentiVolumi()
        {
            var lineaFiltri = document.getElementById("lineaFiltri");
            lineaFiltri.style.display = "block";
            /*var sceltaCategoria = document.getElementById("sceltaCategoria");
            sceltaCategoria.style.display = "block";*/
            var btnIndietro = document.getElementById("btnIndietro");
            btnIndietro.style.display = "none";
            var titoloPagina = document.getElementById("titoloPagina");
            titoloPagina.textContent = "Catalogo";
        }

        function prenotaVolume(idVolume)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                if(j.prenotato == "true")
                {
                    Swal.fire({
                        title: "Volume prenotato!",
                        text: "Il volume è stato prenotato! Per maggiori informazioni consulta la sezione 'Le mie prenotazioni'",
                        icon: "success"
                    });
                }
                else
                {
                    Swal.fire({
                        title: "Hai già prenotato questo volume!",
                        text: "Hai già prenotato questo volume! Non puoi prenotare lo stesso volume più volte",
                        icon: "error"
                    });
                }
            }
            xhttp.open("POST", "prenota_volume.php?idVolume=" + idVolume, true);
            xhttp.send();
        }

        function prenotaLibro(idLibro)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                if(j.prenotato == "true")
                {
                    Swal.fire({
                        title: "Libro prenotato!",
                        text: "Il libro è stato prenotato! Per maggiori informazioni consulta la sezione 'Le mie prenotazioni'",
                        icon: "success"
                    });
                }
                else
                {
                    Swal.fire({
                        title: "Hai già prenotato questo libro!",
                        text: "Hai già prenotato questo libro! Non puoi prenotare lo stesso libro più volte",
                        icon: "error"
                    });
                }
            }
            xhttp.open("POST", "prenota_libro.php?idLibro=" + idLibro, true);
            xhttp.send();
        }

        function prenotaCarta(idCarta)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                if(j.prenotato == "true")
                {
                    Swal.fire({
                        title: "Carta prenotata!",
                        text: "La carta è stata prenotata! Per maggiori informazioni consulta la sezione 'Le mie prenotazioni'",
                        icon: "success"
                    });
                }
                else
                {
                    Swal.fire({
                        title: "Hai già prenotato questa carta!",
                        text: "Hai già prenotato questa carta! Non puoi prenotare la stessa carta più volte",
                        icon: "error"
                    });
                }
            }
            xhttp.open("POST", "prenota_carta.php?idCarta=" + idCarta, true);
            xhttp.send();
        }
    </script>
</html>