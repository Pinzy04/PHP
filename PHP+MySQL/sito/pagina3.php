<?php
    session_start();

    if (!isset($_SESSION['selectedUser']))  //se l'utente non è loggato
    {
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if(!$_SESSION['selectedUser']['Livello'] >= 1 and $_SESSION['selectedUser']['Livello'] != 9)   //controlla se l'utente ha il livello necessario per accedere alla pagina
    {
        header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
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
    
    if (isset($_POST['GoToP2']))    //se viene cliccato il tasto della pagina 2 ("Vai a Pagina 2")
    {
        header('Location: ./pagina2.php');  //va alla pagina 2
    }
    
    if (isset($_POST['GoToP4']))    //se viene cliccato il tasto della pagina 4 ("Vai a Pagina 4")
    {
        if($_SESSION['selectedUser']['Livello'] >= 2 and $_SESSION['selectedUser']['Livello'] != 9)   //controlla se l'utente ha il livello necessario per accedere alla pagina
        {
            header('Location: ./pagina4.php');  //va alla pagina 4
        }
        else
        {
            header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title> Pagina 3 </title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align="center" class="box">
            <h2> Benvenuto nella pagina 3 </h2>
            <img src="./pagina3.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1, alla pagina 2 oppure alla pagina 4.</p>
            
            <form action="pagina3.php" method="post">
                <input type="submit" name="logout" value="Effetua il logout" class="btn btn-primary">
                <input type="submit" name="GoToP1" value="Vai a Pagina 1" class="btn btn-primary">
                <input type="submit" name="GoToP2" value="Vai a Pagina 2" class="btn btn-primary">
                <input type="submit" name="GoToP4" value="Vai a Pagina 4" class="btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>