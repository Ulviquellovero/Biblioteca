<html>
    <head>
        <link rel="stylesheet" href="css/login_style.css">
        <title>Login</title>
        <link rel="icon" type="image/png" href="img/Sapienza.png">
    </head>

    <body>
        <?php require_once("header.php"); ?>
        <div id="container">
            <span id='testoGuida'>Inserisci username/email e password per accedere</span>
            <form id='loginForm' method="POST">
                <input id="username" type="text" name="username" required>
                <input id="password" type="password" name="password" required>
                <input id="submit" type="submit" value="Login">
            </form>
            <span id='erroreCredenziali'></span>
        </div>

        <div class = "nuovoAccountDiv">
            <p id = "registrati">  Non hai un account? 
            <a id='linkRegistrati' href="registrati.php"> Registrati </a>
            </p>
        </div>

        <div id='footerLogin'>
            <?php require_once("footer.html"); ?>
        </div>

        <script>
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                event.preventDefault();
                var formData = "username=" + encodeURIComponent(document.getElementById("username").value) +
                            "&password=" + encodeURIComponent(document.getElementById("password").value);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "auth.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var res = xhr.responseText;
                        var j = JSON.parse(res);
                        if (!j.autenticato) {
                            var errText = document.getElementById("erroreCredenziali");
                            errText.innerHTML = "Credenziali errate";
                        } else {
                            window.location = "index.php";
                        }
                    }
                };
                xhr.send(formData);
            });
        </script>
        
    </body>
</html>