<?php
    session_start();

    $_SESSION['utente'] = json_decode(file_get_contents('./users.json'), true);

    if (isset($_POST['logout']))
    {
        session_destroy();
        header('Location: ./login.php');
        exit;
    }

    if (isset($_POST['GoToP1']))
    {
        header('Location: ./pagina1.php');
    }
?>

<!doctype html>
<html>
    <head>
        <title> Accesso Negato </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> OPS... <br> Non hai i permessi necessari per accedere a questa pagina </h2>
            <img src="./accesso_negato.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, oppure tornare alla pagina 1.</p>
            <form action = "pagina1.php" method = "post">
                <input type = "submit" name = "logout" value = "Effetua il logout" class = "btn btn-primary">
                <input type = "submit" name = "GoToP1" value = "Vai a Pagina 1" class = "btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>