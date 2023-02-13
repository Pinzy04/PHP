<?php
    session_start();

    if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout ("Effetua il logout")
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['GoToP2'])) {  //se viene cliccato il tasto della pagina 2 ("Vai a Pagina 2")
        header('Location: ./pagina2.php');  //va alla pagina 2
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Pagina 1 </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container">
            <h1> Benvenuto nella pagina 1 </h1><br>
            <img src="./images/pagina1.jpg" class="figure-img img-fluid rounded"> <br>
            <?php
                echo "<div class='box'>";
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
                if ($_SESSION['selectedUser']['Livello'] == 9) {    //se l'utente non è stato ancora verificato
                    echo "La tua utenza è in fase di verifica, in questo momento sei al pari di un utente ospite. <br><br>";
                }
                echo "</div><br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, oppure andare alla pagina 2.</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="submit" name="logout" value="Effetua il logout" class="btn btn-primary">
                <input type="submit" name="GoToP2" value="Vai a Pagina 2" class="btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>
