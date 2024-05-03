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
                creaHtmlLibri(j, visualizzazione, "libro");
            }
            xhttp.open("POST", "crea_catalogo_libri.php", true);
            xhttp.send();
        }

        function creaHtmlLibri(j, visualizzazione, tipo)
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
                            nomeAutore.textContent = "Autore: " + j.Result[i].nomeAutore + " " + j.Result[i].cognomeAutore;
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
                            annoPub.textContent = "Anno: " + j.Result[i].annoPub;
                            containerAutoreDisponibile.appendChild(annoPub);
                            
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

                visualizzazione.appendChild(containerLibro);
            }
        }

        function mostraLibro(tipo, id)
        {
            window.location.href = "dettaglio_elemento.php?tipo="+ tipo +"&id=" + id;
        }
    </script>
</html>