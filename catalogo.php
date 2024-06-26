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
                    btnAggiungiLibro.onclick = function() {
                        if(tipoSelezionato == "Libri")
                            nuovoLibro();
                        if(tipoSelezionato == "Carte")
                            nuovaCarta();
                        if(tipoSelezionato == "Enciclopedie")
                            nuovaEnciclopedia();
                    };
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

                                if(j.Result[i].primoNumero != undefined)
                                {
                                    var numeroTelefono = j.Result[i].primoNumero.toString();
                                    var numeroFormattato = numeroTelefono.slice(0, 3) + ' ' + numeroTelefono.slice(3, 6) + ' ' + numeroTelefono.slice(6);
                                    var primoNumero = document.createElement("h2");
                                    primoNumero.className = "elementoDettagli";
                                    primoNumero.textContent = "Numero del destinatario: " + numeroFormattato;
                                    divDettagliPrestito.appendChild(primoNumero);
                                }

                                if(j.Result[i].secondoNumero != undefined)
                                {
                                    var numeroTelefono = j.Result[i].secondoNumero.toString();
                                    var numeroFormattato = numeroTelefono.slice(0, 3) + ' ' + numeroTelefono.slice(3, 6) + ' ' + numeroTelefono.slice(6);
                                    var secondoNumero = document.createElement("h2");
                                    secondoNumero.className = "elementoDettagli";
                                    secondoNumero.textContent = "Secondo numero del destinatario: " + numeroFormattato;
                                    divDettagliPrestito.appendChild(secondoNumero);
                                }

                                if(j.Result[i].terzoNumero != undefined)
                                {
                                    var numeroTelefono = j.Result[i].terzoNumero.toString();
                                    var numeroFormattato = numeroTelefono.slice(0, 3) + ' ' + numeroTelefono.slice(3, 6) + ' ' + numeroTelefono.slice(6);
                                    var terzoNumero = document.createElement("h2");
                                    terzoNumero.className = "elementoDettagli";
                                    terzoNumero.textContent = "Terzo numero del destinatario: " + numeroFormattato;
                                    divDettagliPrestito.appendChild(terzoNumero);
                                }

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

                                if(j.Result[i].nomeUtentePersonaleConsegna == "Il volume non è ancora stato consegnato")
                                {
                                    var btnConsegna = document.createElement("button");
                                    btnConsegna.id = "btnConsegna";
                                    btnConsegna.textContent = "Contrassegna come consegnato";
                                    btnConsegna.setAttribute("libro-id", j.Result[i].id);
                                    btnConsegna.setAttribute("utente-id", j.Result[i].idUtente);
                                    btnConsegna.onclick = function() {
                                        var idLibro = this.getAttribute("libro-id");
                                        var idUtente = this.getAttribute("utente-id");
                                        consegnaVolume(idLibro, idUtente);
                                    };
                                    divDettagliPrestito.appendChild(btnConsegna);
                                }
                                else
                                {
                                    if(j.Result[i].nomeUtentePersonaleConsegna == "Il libro non è ancora stato consegnato")
                                    {
                                        var btnConsegna = document.createElement("button");
                                        btnConsegna.id = "btnConsegna";
                                        btnConsegna.textContent = "Contrassegna come consegnato";
                                        btnConsegna.setAttribute("libro-id", j.Result[i].id);
                                        btnConsegna.setAttribute("utente-id", j.Result[i].idUtente);
                                        btnConsegna.onclick = function() {
                                            var idLibro = this.getAttribute("libro-id");
                                            var idUtente = this.getAttribute("utente-id");
                                            consegnaLibro(idLibro, idUtente);
                                        };
                                        divDettagliPrestito.appendChild(btnConsegna);
                                    }
                                    else
                                    {
                                        if(j.Result[i].nomeUtentePersonaleConsegna == "La carta non è ancora stata consegnata")
                                        {
                                            var btnConsegna = document.createElement("button");
                                            btnConsegna.id = "btnConsegna";
                                            btnConsegna.textContent = "Contrassegna come consegnata";
                                            btnConsegna.setAttribute("libro-id", j.Result[i].id);
                                            btnConsegna.setAttribute("utente-id", j.Result[i].idUtente);
                                            btnConsegna.onclick = function() {
                                                var idLibro = this.getAttribute("libro-id");
                                                var idUtente = this.getAttribute("utente-id");
                                                consegnaCarta(idLibro, idUtente);
                                            };
                                            divDettagliPrestito.appendChild(btnConsegna);
                                        }
                                        else
                                        {
                                            var btnRevoca = document.createElement("button");
                                            btnRevoca.id = "btnRevoca";
                                            btnRevoca.textContent = "Contrassegna come restituito";
                                            btnRevoca.setAttribute("libro-id", j.Result[i].id);
                                            btnRevoca.setAttribute("utente-id", j.Result[i].idUtente);
                                            if( j.Result[i].tipo == "volumi")
                                            {
                                                btnRevoca.onclick = function() {
                                                    var idLibro = this.getAttribute("libro-id");
                                                    var idUtente = this.getAttribute("utente-id");
                                                    revocaPrestitoVolume(idLibro, idUtente);
                                                };
                                            }
                                            else
                                            {
                                                if( j.Result[i].tipo == "libri")
                                                {
                                                    btnRevoca.onclick = function() {
                                                        var idLibro = this.getAttribute("libro-id");
                                                        var idUtente = this.getAttribute("utente-id");
                                                        revocaPrestitoLibro(idLibro, idUtente);
                                                    };
                                                }
                                                else
                                                {
                                                    btnRevoca.onclick = function() {
                                                        var idLibro = this.getAttribute("libro-id");
                                                        var idUtente = this.getAttribute("utente-id");
                                                        revocaPrestitoCarta(idLibro, idUtente);
                                                    };
                                                }
                                            }
                                            divDettagliPrestito.appendChild(btnRevoca);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                var nomeUtente = document.createElement("h2");
                                nomeUtente.className = "elementoDettagli";
                                if( j.Result[i].tipo == "volumi")
                                    nomeUtente.textContent = "Il volume non è in prestito";
                                else
                                {
                                    if( j.Result[i].tipo == "libri")
                                    nomeUtente.textContent = "Il libro non è in prestito";
                                    else
                                        nomeUtente.textContent = "La carta non è in prestito";
                                }
                                divDettagliPrestito.appendChild(nomeUtente);
                            }
                            
                            visualizzazione.appendChild(divDettagliPrestito);

                            $inPrestito = false;
                            if(j.Result[i].nomeUtentePersonaleErogatore != undefined)   
                                $inPrestito = true;
                            if( j.Result[i].tipo == "volumi")
                            {
                                creaListaPrenotazioniVolume(j.Result[i].id, $inPrestito);
                                creaListaStoricoRestituzioniVolumi(j.Result[i].id);
                            }
                            else
                            {
                                if( j.Result[i].tipo == "libri")
                                {
                                    creaListaPrenotazioniLibro(j.Result[i].id, $inPrestito);
                                    creaListaStoricoRestituzioniLibri(j.Result[i].id);
                                }
                                else
                                {
                                    creaListaPrenotazioniCarta(j.Result[i].id, $inPrestito);
                                    creaListaStoricoRestituzioniCarte(j.Result[i].id);
                                }
                            }
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
        
        function revocaPrestitoLibro(idLibro, idUtente)
        {
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
                        revocaPrestitoLibroQuery(idLibro, idUtente);
                        Swal.fire({
                        title: "Prestito contrassegnato come restituito!",
                        text: "Il prestito è appena stato contrassegnato come restituito",
                        icon: "success"
                    });
                }
            });
        }

        function revocaPrestitoLibroQuery(idLibro, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraLibro(idLibro);
            }
            xhttp.open("POST", "revoca_prestito_libro.php?idLibro="+idLibro+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function revocaPrestitoCarta(idLibro, idUtente)
        {
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
                        revocaPrestitoCartaQuery(idLibro, idUtente);
                        Swal.fire({
                        title: "Prestito contrassegnato come restituito!",
                        text: "Il prestito è appena stato contrassegnato come restituito",
                        icon: "success"
                    });
                }
            });
        }

        function revocaPrestitoCartaQuery(idCarta, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraCarta(idCarta);
            }
            xhttp.open("POST", "revoca_prestito_carta.php?idCarta="+idCarta+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function revocaPrestitoVolume(idLibro, idUtente)
        {
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
                        revocaPrestitoVolumeQuery(idLibro, idUtente);
                        Swal.fire({
                        title: "Prestito contrassegnato come restituito!",
                        text: "Il prestito è appena stato contrassegnato come restituito",
                        icon: "success"
                    });
                }
            });
        }

        function revocaPrestitoVolumeQuery(idVolume, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraVolumi(idVolume);
            }
            xhttp.open("POST", "revoca_prestito_volume.php?idVolume="+idVolume+"&idUtente="+idUtente, true);
            xhttp.send();
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
                    btnAggiungiLibro.onclick = function() {
                        nuovaEnciclopedia();
                    };
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

        function creaListaPrenotazioniLibro(id, inPrestito)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaPrenotazioniLibro(j, visualizzazione, inPrestito);
            }
            xhttp.open("POST", "crea_lista_prenotazioni_libro_noUser.php?id="+id, true);
            xhttp.send();
        }

        function creaListaPrenotazioniCarta(id, inPrestito)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaPrenotazioniLibro(j, visualizzazione, inPrestito);
            }
            xhttp.open("POST", "crea_lista_prenotazioni_carta_noUser.php?id="+id, true);
            xhttp.send();
        }

        function creaListaPrenotazioniVolume(id, inPrestito)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaPrenotazioniLibro(j, visualizzazione, inPrestito);
            }
            xhttp.open("POST", "crea_lista_prenotazioni_volume_noUser.php?id="+id, true);
            xhttp.send();
        }

        function creaHtmlListaPrenotazioniLibro(j, visualizzazione, inPrestito)
        {
            var divPrenotazioni = document.createElement("div");
            divPrenotazioni.id = "divPrenotazioni";

            var titoloSezione = document.createElement("h1");
            titoloSezione.textContent = "Prenotazioni Attive";
            divPrenotazioni.appendChild(titoloSezione);
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    var divLista = document.createElement("div");
                    divLista.id = "divPrenotazioniLista";
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var containerLibro = document.createElement("div");
                        containerLibro.className = "containerElementoPrenotazioni";

                            var titolo = document.createElement("h1");
                            titolo.className = "titoloLibroPrenotazioni";
                            titolo.textContent = "Prenotazione effettuata da " + j.Result[i].nomeUtente;
                            containerLibro.appendChild(titolo);

                            var containerDati = document.createElement("div");
                            containerDati.className = "containerDati";
                            containerLibro.appendChild(containerDati);
                            
                                var containerDate = document.createElement("div");
                                containerDate.className = "containerDate";
                                containerDati.appendChild(containerDate);

                                    var dataPrenotazione = document.createElement("span");
                                    dataPrenotazione.className = "datoLibro";
                                    dataPrenotazione.textContent = "Data di prenotazione: " + formatData(j.Result[i].dataPrenotazione);
                                    containerDate.appendChild(dataPrenotazione);

                            if(inPrestito == false && i == 0)
                            {
                                var btnPresta = document.createElement("btn");
                                btnPresta.id = "btnPresta";
                                if(j.Result[i].tipo == "volumi")
                                    btnPresta.textContent = "Presta il volume";
                                else
                                {
                                    if(j.Result[i].tipo == "libri")
                                        btnPresta.textContent = "Presta il libro";
                                    else
                                        btnPresta.textContent = "Presta la carta";
                                }
                                btnPresta.setAttribute("libro-id", j.Result[i].id);
                                btnPresta.setAttribute("utente-id", j.Result[i].idUtente);
                                if( j.Result[i].tipo == "volumi")
                                {
                                    btnPresta.onclick = function() {
                                        var idLibro = this.getAttribute("libro-id");
                                        var idUtente = this.getAttribute("utente-id");
                                        prestaVolume(idLibro, idUtente);
                                    };
                                }
                                else
                                {
                                    if(j.Result[i].tipo == "libri")
                                    {
                                        btnPresta.onclick = function() {
                                            var idLibro = this.getAttribute("libro-id");
                                            var idUtente = this.getAttribute("utente-id");
                                            prestaLibro(idLibro, idUtente);
                                        };
                                    }
                                    else
                                    {
                                        btnPresta.onclick = function() {
                                            var idLibro = this.getAttribute("libro-id");
                                            var idUtente = this.getAttribute("utente-id");
                                            prestaCarta(idLibro, idUtente);
                                        };
                                    }
                                }
                                containerDate.appendChild(btnPresta);
                            }
                        divLista.appendChild(containerLibro);
                    }
                    divPrenotazioni.appendChild(divLista);
                }
                else
                {
                    var nessunRisultato = document.createElement("h2");
                    nessunRisultato.className = "elementoDettagli";
                    nessunRisultato.textContent = "Nessuna prenotazione trovata";
                    divPrenotazioni.appendChild(nessunRisultato);
                }
            }
            else
            {
                var nessunRisultato = document.createElement("h2");
                nessunRisultato.className = "elementoDettagli";
                nessunRisultato.textContent = "Nessuna prenotazione trovata";
                divPrenotazioni.appendChild(nessunRisultato);
            }
            visualizzazione.appendChild(divPrenotazioni);
        }

        function prestaVolume(idVolume, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler prestare il volume?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, presta"
                }).then((result) => {
                    if (result.isConfirmed) {
                        prestaVolumeQuery(idVolume, idUtente);
                        Swal.fire({
                        title: "Volume prestato!",
                        text: "L'utente selezionato è appena stato avvisato della conferma della prenotazione. Per ufficializzare il prestito, lo stesso si dovrà presentare in biblioteca per ritirare il volume e un addetto dovrà contrassegnare il volume come consegnato.",
                        icon: "success"
                    });
                }
            });
        }

        function prestaVolumeQuery(idVolume, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraVolumi(idVolume);
            }
            xhttp.open("POST", "presta_volume.php?idVolume="+idVolume+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function prestaCarta(idCarta, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler prestare la carta?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, presta"
                }).then((result) => {
                    if (result.isConfirmed) {
                        prestaCartaQuery(idCarta, idUtente);
                        Swal.fire({
                        title: "Carta prestata!",
                        text: "L'utente selezionato è appena stato avvisato della conferma della prenotazione. Per ufficializzare il prestito, lo stesso si dovrà presentare in biblioteca per ritirare la carta e un addetto dovrà contrassegnare la carta come consegnata.",
                        icon: "success"
                    });
                }
            });
        }

        function prestaCartaQuery(idCarta, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraCarta(idCarta);
            }
            xhttp.open("POST", "presta_carta.php?idCarta="+idCarta+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function prestaLibro(idLibro, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler prestare il libro?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, presta"
                }).then((result) => {
                    if (result.isConfirmed) {
                        prestaLibroQuery(idLibro, idUtente);
                        Swal.fire({
                        title: "Libro prestato!",
                        text: "L'utente selezionato è appena stato avvisato della conferma della prenotazione. Per ufficializzare il prestito, lo stesso si dovrà presentare in biblioteca per ritirare il libro e un addetto dovrà contrassegnare il libro come consegnato.",
                        icon: "success"
                    });
                }
            });
        }

        function prestaLibroQuery(idLibro, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraLibro(idLibro);
            }
            xhttp.open("POST", "presta_libro.php?idLibro="+idLibro+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function consegnaCarta(idCarta, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler contrassegnare la carta come consegnata?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, contrassegna"
                }).then((result) => {
                    if (result.isConfirmed) {
                        consegnaCartaQuery(idCarta, idUtente);
                        Swal.fire({
                        title: "Carta consegnata!",
                        text: "La carta è stata consegnata! Sei stato registrato come responsabile della consegna di questo prestito.",
                        icon: "success"
                    });
                }
            });
        }

        function consegnaCartaQuery(idCarta, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraCarta(idCarta);
            }
            xhttp.open("POST", "consegna_carta.php?idCarta="+idCarta+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function consegnaLibro(idLibro, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler contrassegnare il libro come consegnato?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, contrassegna"
                }).then((result) => {
                    if (result.isConfirmed) {
                        consegnaLibroQuery(idLibro, idUtente);
                        Swal.fire({
                        title: "Libro consegnato!",
                        text: "Il libro è stata consegnato! Sei stato registrato come responsabile della consegna di questo prestito.",
                        icon: "success"
                    });
                }
            });
        }

        function consegnaLibroQuery(idLibro, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraLibro(idLibro);
            }
            xhttp.open("POST", "consegna_libro.php?idLibro="+idLibro+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function consegnaVolume(idVolume, idUtente)
        {
            Swal.fire({
                title: "Sei sicuro di voler contrassegnare il volume come consegnato?",
                text: "L'azione non può essere annullata!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sì, contrassegna"
                }).then((result) => {
                    if (result.isConfirmed) {
                        consegnaVolumeQuery(idVolume, idUtente);
                        Swal.fire({
                        title: "Volume consegnato!",
                        text: "Il volume è stata consegnato! Sei stato registrato come responsabile della consegna di questo prestito.",
                        icon: "success"
                    });
                }
            });
        }

        function consegnaVolumeQuery(idVolume, idUtente)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                mostraVolumi(idVolume);
            }
            xhttp.open("POST", "consegna_volume.php?idVolume="+idVolume+"&idUtente="+idUtente, true);
            xhttp.send();
        }

        function creaListaStoricoRestituzioniVolumi(id)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaStoricoRestituzioniLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_storico_prenotazioni_volumi.php?id="+id, true);
            xhttp.send();
        }

        function creaListaStoricoRestituzioniCarte(id)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaStoricoRestituzioniLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_storico_prenotazioni_carte.php?id="+id, true);
            xhttp.send();
        }

        function creaListaStoricoRestituzioniLibri(id)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res = xhttp.responseText;
                var j = JSON.parse(res);
                var visualizzazione = document.getElementById("visualizzazione");
                creaHtmlListaStoricoRestituzioniLibri(j, visualizzazione);
            }
            xhttp.open("POST", "crea_lista_storico_prenotazioni_libri.php?id="+id, true);
            xhttp.send();
        }

        function creaHtmlListaStoricoRestituzioniLibri(j, visualizzazione)
        {
            var divPrenotazioni = document.createElement("div");
            divPrenotazioni.id = "divPrenotazioni";

            var titoloSezione = document.createElement("h1");
            titoloSezione.textContent = "Storico Restituzioni";
            divPrenotazioni.appendChild(titoloSezione);
            if(j.Result != null)
            {
                if(j.Result.length != 0)
                {
                    var divLista = document.createElement("div");
                    divLista.id = "divPrenotazioniLista";
                    for(var i=0; i < j.Result.length; i++)
                    {
                        var containerLibro = document.createElement("div");
                        containerLibro.className = "containerElementoPrenotazioni";

                            var titolo = document.createElement("h1");
                            titolo.className = "titoloLibroPrenotazioni";
                            titolo.textContent = "Restituzione effettuata da " + j.Result[i].nomeUtente;
                            containerLibro.appendChild(titolo);

                            var containerDati = document.createElement("div");
                            containerDati.className = "containerDati";
                            containerLibro.appendChild(containerDati);
                            
                                var containerDate = document.createElement("div");
                                containerDate.className = "containerDate";
                                containerDati.appendChild(containerDate);

                                    var dataPrenotazione = document.createElement("span");
                                    dataPrenotazione.className = "datoLibro";
                                    dataPrenotazione.textContent = "Data di restituzione: " + formatData(j.Result[i].data);
                                    containerDate.appendChild(dataPrenotazione);

                                    var dataPrenotazione = document.createElement("br");
                                    containerDate.appendChild(dataPrenotazione);

                                    var dataPrenotazione = document.createElement("span");
                                    dataPrenotazione.className = "datoLibro";
                                    dataPrenotazione.textContent = "Addetto responsabile del ritiro: " + j.Result[i].nomePersonale;
                                    containerDate.appendChild(dataPrenotazione);

                        divLista.appendChild(containerLibro);
                    }
                    divPrenotazioni.appendChild(divLista);
                }
                else
                {
                    var nessunRisultato = document.createElement("h2");
                    nessunRisultato.className = "elementoDettagli";
                    nessunRisultato.textContent = "Nessuna dato trovato riguardante le restituzioni";
                    divPrenotazioni.appendChild(nessunRisultato);
                }
            }
            else
            {
                var nessunRisultato = document.createElement("h2");
                nessunRisultato.className = "elementoDettagli";
                nessunRisultato.textContent = "Nessuna dato trovato riguardante le restituzioni";
                divPrenotazioni.appendChild(nessunRisultato);
            }
            visualizzazione.appendChild(divPrenotazioni);
        }

        function nuovoLibro()
        {
            window.location.href = "nuovoLibro.php";
        }

        function nuovaCarta()
        {
            window.location.href = "nuovaCarta.php";
        }

        function nuovaEnciclopedia()
        {
            window.location.href = "nuovaEnciclopedia.php";
        }
    </script>
</html>