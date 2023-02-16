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

    if (isset($_POST['GoToP1'])) {  //se viene cliccato il tasto della pagina 1 ("Vai a Pagina 1")
        header('Location: ./pagina1.php');  //va alla pagina 1
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Accesso Negato </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include('header.php');
        ?>   
        <div align=center class="container">
            <h1> OPS... <br> Non hai i privilegi necessari per accedere a questa pagina! </h1><br>
            <img src="./images/accesso_negato.jpg" class="figure-img img-fluid rounded"> <br>
            <?php
                echo "<div class='box'>";
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
                echo "</div><br>";
            ?>
        </div>
    </body>
</html>
