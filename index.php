<html>
    <head>
        <link rel="stylesheet" href="css/index_style.css">
        <title>Home</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2eB0uH1_PcUqvpsoWzrCBCr0fXuRuF2U"></script>
    </head>

    <body>

        <div id='header'>
            <?php
                require_once("header.php");
            ?>
        </div>
        <div id='contenuto'>
            <h1>Biblioteca Sapienza</h1>
            <p id='descrizioneBiblioteca'>La Biblioteca Sapienza è il tuo rifugio per l'apprendimento, l'ispirazione e la scoperta. Con una vasta collezione di opere, siamo qui per nutrire la tua mente e arricchire il tuo spirito. Esplora i nostri corridoi di conoscenza e lasciati trasportare dalle meraviglie dei libri. Benvenuto nel cuore pulsante del sapere.</p>
            <h1>Dove Trovarci</h1>
        </div>
        <div id="dvMap">
        </div>
        <div id='footer'>
            <?php require_once("footer.html"); ?>
        </div>
    </body>

    <script>
        var map;
        $(document).ready(function() {
            latitudine   = 45.65203019412905;
            longitudine  = 13.780441813836367;
            mapOptions = {
                center: new google.maps.LatLng(latitudine, longitudine),
                zoom: 17,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DEFAULT,
                    position: google.maps.ControlPosition.TOP_RIGHT
                }
            }
            map = new google.maps.Map($("#dvMap")[0], mapOptions);
            marker = new google.maps.Marker({position: new google.maps.LatLng(latitudine,longitudine), map: map});
            $.ajax({url: "leggi_punti.php", success: function(result){
            var imp = JSON.parse(result);
            for(i=0;i<imp.ElencoPunti.length;i++) {
                pLatLng = new google.maps.LatLng(imp.ElencoPunti[i].lat,imp.ElencoPunti[i].lon);
                marker = new google.maps.Marker({
                    position: pLatLng,
                    map: map
                });
                google.maps.event.addListener(marker, 'click', function() {
                    window.location.href = this.url;
                });
            }
            }});
        });
    </script>
</html>