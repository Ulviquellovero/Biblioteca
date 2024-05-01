<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/registrati_style.css">
        <title>Registrazione</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">

        <script>
            function uppercaseInput() {
                var input = document.getElementById("codiceFiscale");
                input.value = input.value.toUpperCase();
            }

            function validateForm() {
                var password = document.getElementById("password").value;
                var confermaPassword = document.getElementById("confermaPassword").value;
                if (password !== confermaPassword) {
                    alert("Le password non corrispondono!");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>

        <?php require_once("header.php"); ?>

        <h1>Registrazione</h1>

        <div id = "input">

            <form onsubmit="return validateForm()" action="inserimentoDati.php" method="POST" class = "loginForm">
            <div class="riga">
                <label class="elemento" for="nomePersona">Inserisci il tuo nome:</label>
                <label class="elemento" for="cognomePersona">Inserisci il tuo cognome:</label>
            </div>
            <div class="riga">
                
                <input type="text" class="elemento" maxlength="30" id='nomePersona' name="nome" placeholder="Es. Mario" required>
                <input type="text" class="elemento" maxlength="30" id='cognomePersona' name="cognome" placeholder="Es. Rossi" required>
            </div>
            <div class="riga">
                <label class="elemento" for="codiceFiscale">Inserisci il tuo codice fiscale:</label>
                <label class="elemento" for="emailPersona">Inserisci la tua email:</label>
            </div>
            <div class="riga">
                <input type="text" class="elemento" id="codiceFiscale" name="codiceFiscale" maxlength="16" placeholder="Es. BTDDXD72E63M298N" oninput="uppercaseInput()" required>
                <input type="email" maxlength="50" class="elemento" id='emailPersona' name="email" placeholder="example@gmail.com" required>
            </div>
            <div class="riga">
                <label class="elemento" for="primoNumero">Inserisci il tuo/i tuoi numeri di telefono (opzionali):</label>
            </div>
            <div class="riga">
                <input type="tel" class="elemento" id='primoNumero' name="numTelefoni[]" pattern="[0-9]{10}" maxlength="10"  placeholder="+39 (numero principale)">
                <input type="tel" class="elemento" name="numTelefoni[]" pattern="[0-9]{10}" maxlength="10"  placeholder="+39 (numero secondario)">
            </div>

            <div class="riga">
                <input type="tel" id='terzoNumero' class="elemento" name="numTelefoni[]" pattern="[0-9]{10}" maxlength="10"  placeholder="+39 (terzo numero)">
            </div>

            <div class="riga">
                <label class="elemento" for="password">Inserisci una password a tua scelta per l'account (minimo 8 caratteri):</label>
                <label class="elemento" for="confermaPassword">Conferma password:</label>
            </div>

            <div class="riga">
                <input class="elemento" maxlength="30" type="password" id="password" name="password" placeholder="Es. Jx#9pYq2" minlength="8" required>
                <input class="elemento" maxlength="30" type="password" id="confermaPassword" placeholder="Es. Jx#9pYq2" name="confermaPassword" minlength="8" required>
            </div>

            <input id="submit" type="submit" name="submit" value="Registrati">
            </form>

        </div>

        <?php require_once("footer.html"); ?>
    </body>


</html>