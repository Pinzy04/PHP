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

    if (isset($_POST['GoToP1']))    //se viene cliccato il tasto della pagina 1 ("Vai a Pagina 1")
    {
        header('Location: ./pagina1.php');  //va alla pagina 1
    }
?>

<!doctype html>
<html>
    <head>
        <title> Accesso Negato </title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align="center" class="box">
            <h2> OPS... <br> Non hai i privilegi necessari per accedere a questa pagina! </h2>
            <img src="./accesso_negato.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, oppure tornare alla pagina 1.</p>
            <form action="pagina1.php" method="post">
                <input type="submit" name="logout" value="Effetua il logout" class="btn btn-primary">
                <input type="submit" name="GoToP1" value="Vai a Pagina 1" class="btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>