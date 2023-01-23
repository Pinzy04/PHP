<?php
    session_start();

    if (!isset($_SESSION['selectedUser']))  //se l'utente non è loggato
    {
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if (isset($_POST['logout']))    //se viene cliccato il tasto di logout ("Effetua il logout")
    {
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['GoToP2']))    //se viene cliccato il tasto della pagina 2 ("Vai a Pagina 2")
    {
        header('Location: ./pagina2.php');  //va alla pagina 2
    }
?>

<!doctype html>
<html>
    <head>
        <title> Pagina 1 </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Benvenuto nella pagina 1 </h2>
            <img src="./pagina1.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, oppure andare alla pagina 2.</p>
            <form action = "pagina1.php" method = "post">
                <input type = "submit" name = "logout" value = "Effetua il logout" class = "btn btn-primary">
                <input type = "submit" name = "GoToP2" value = "Vai a Pagina 2" class = "btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>