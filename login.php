<html>
    <head>
        <link rel="stylesheet" href="css/login_style.css">
    </head>

    <body>
        <?php require_once("header.php"); ?>
        <div id="container">
            <span id='testoGuida'>Inserisci username e password per accedere</span>
            <form id='loginForm' method="POST">
                <input id="username" type="text" name="username">
                <input id="password" type="password" name="password">
                <input id="submit" type="submit">
            </form>
            <span id='erroreCredenziali'></span>
        </div>
        <?php require_once("footer.html"); ?>

        <script>
            document.getElementById("loginForm").addEventListener("submit", function(event)
            {
                event.preventDefault();
                var formData = new FormData(this);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "auth.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.err) {
                            var errText = document.getElementById("erroreCredenziali");
                            errText.innerHTML= "Credenziali errate";
                        } else {
                            window.location = "index.html";
                        }
                    }
            };
            xhr.send(new URLSearchParams(formData).toString());
        });
        </script>
        
    </body>
</html>