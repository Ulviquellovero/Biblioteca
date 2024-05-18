<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/header_style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus:ital,wght@0,400;0,700;1,400;1,700&family=Goudy+Bookletter+1911&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id="body_header">
            <div id="parte_sinistra_header">
                <a href="index.php"><img id="logo" src="img/Sapienza.png" alt="Logo Sapienza"></a>
                <a href="index.php"><h1 id="nome_software">Biblioteca Sapienza</h1></a>
                
            </div>
            <div id="parte_destra_header">
                
            </div>
        </div>
    </body>
    
    <script>
            verificaLogin();
            
            function verificaLogin()
            {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    var res = xhttp.responseText;
                    var j = JSON.parse(res);
                    creaHtmlLogin(j);
                }
                xhttp.open("POST", "verifica_login_header.php", true);
                xhttp.send();
            }

            function creaHtmlLogin(j)
            {
                var htmlElement;
                    if(!j.autenticato)
                    {
                        htmlElement = document.createElement("a");
                        htmlElement.id = "link_login";
                        htmlElement.href = "login.php";
                        
                        var imgElement = document.createElement("img");
                        imgElement.id = "img_login";
                        imgElement.src = "img/login_icon.png";
                        imgElement.alt = "Login";
                        
                        htmlElement.appendChild(imgElement);
                    }
                    else
                    {
                        if(j.permessi == "false")
                            costruisciLinkLeMiePrenotazioni();
                        else
                            modificaHeaderPersonale();

                        htmlElement = document.createElement("div");
                        htmlElement.id = "logoutRow";

                        benvenuto = document.createElement("span");
                        benvenuto.id = "benvenuto_utente";
                        benvenuto.textContent = "Benvenuto/a " + j.userName;
                        
                        logoutLink = document.createElement("a");
                        logoutLink.id = "link_login";
                        logoutLink.href = "logout.php";
                        
                        var imgElement = document.createElement("img");
                        imgElement.id = "img_logout";
                        imgElement.src = "img/logout_icon.png";
                        imgElement.alt = "Login";
                        
                        logoutLink.appendChild(imgElement);

                        htmlElement.appendChild(benvenuto);
                        htmlElement.appendChild(logoutLink);
                    }
                    var parteDestraPagina = document.getElementById("parte_destra_header");
                    parteDestraPagina.innerHTML = "";
                    parteDestraPagina.appendChild(htmlElement);
            }

            scegliPagineLink();
            
            function scegliPagineLink()
            {
                var currentPage = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
                if(currentPage == "index.php" || currentPage == "")
                    costruisciLinkIndex(); 
                if(currentPage == "catalogo.php" || currentPage == "nuovoLibro.php" || currentPage == "nuovaCarta.php" || currentPage == "nuovaEnciclopedia.php")
                    costruisciLinkCatalogo();
                if(currentPage == "login.php" || currentPage == "registrati.php")
                    costruisciLinkLogin();
                if(currentPage == "le_mie_prenotazioni.php")
                    costruisciAltriLinkLeMiePrenotazioni();
            }

            function costruisciLinkIndex()
            {
                var selectedLink = document.createElement("span");
                selectedLink.className = "selectedLink";
                selectedLink.textContent = "Home";
                var catalogLink = document.createElement("a");
                catalogLink.className = "link";
                catalogLink.href = "catalogo.php";
                catalogLink.id = "catalogoLink";
                catalogLink.textContent = "Catalogo";
                var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                parteSinistraPagina.appendChild(selectedLink);
                parteSinistraPagina.appendChild(catalogLink);
            }

            function costruisciAltriLinkLeMiePrenotazioni()
            {
                console.log("passato");
                var homeLink = document.createElement("a");
                homeLink.className = "link";
                homeLink.href = "index.php";
                homeLink.textContent = "Home";
                var catalogLink = document.createElement("a");
                catalogLink.className = "link";
                catalogLink.id = "catalogoLink";
                catalogLink.href = "catalogo.php";
                catalogLink.textContent = "Catalogo";
                var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                parteSinistraPagina.appendChild(homeLink);
                parteSinistraPagina.appendChild(catalogLink);
            }

            function costruisciLinkCatalogo()
            {
                var selectedLink = document.createElement("a");
                selectedLink.href = "index.php";
                selectedLink.className = "link";
                selectedLink.textContent = "Home";
                var catalogLink = document.createElement("span");
                catalogLink.id = "catalogoLink";
                catalogLink.className = "selectedLink";
                catalogLink.textContent = "Catalogo";
                var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                parteSinistraPagina.appendChild(selectedLink);
                parteSinistraPagina.appendChild(catalogLink);
            }

            function costruisciLinkLogin()
            {
                var selectedLink = document.createElement("a");
                selectedLink.href = "index.php";
                selectedLink.className = "link";
                selectedLink.textContent = "Home";
                var catalogLink = document.createElement("a");
                catalogLink.id = "catalogoLink";
                catalogLink.className = "link";
                catalogLink.href = "catalogo.php";
                catalogLink.textContent = "Catalogo";
                var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                parteSinistraPagina.appendChild(selectedLink);
                parteSinistraPagina.appendChild(catalogLink);
            }

            function costruisciLinkLeMiePrenotazioni()
            {
                var currentPage = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
                if(currentPage == "le_mie_prenotazioni.php")
                {
                    var selectedLink = document.createElement("span");
                    selectedLink.className = "selectedLink";
                    selectedLink.textContent = "Le mie prenotazioni";
                    var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                    parteSinistraPagina.appendChild(selectedLink);
                }
                else
                {
                    var selectedLink = document.createElement("a");
                    selectedLink.href = "le_mie_prenotazioni.php";
                    selectedLink.className = "link";
                    selectedLink.textContent = "Le mie prenotazioni";
                    var parteSinistraPagina = document.getElementById("parte_sinistra_header");
                    parteSinistraPagina.appendChild(selectedLink);
                }
            }

            function modificaHeaderPersonale()
            {
                var catalogLink = document.getElementById("catalogoLink");
                catalogLink.textContent = "Catalogo, Prenotazioni e Prestiti";
            }
        </script>
</html>