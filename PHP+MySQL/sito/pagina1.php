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
        <?php
            $_GET['current']=1;
            include('header.php');
        ?>
        <div align=center class="container">
            <h1> Benvenuto nella pagina 1 </h1><br>
            <img src="./images/pagina1.jpg" class="figure-img img-fluid rounded"> <br>
            <div class='box'>
                <?php
                    echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                    echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                    echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
                    if ($_SESSION['selectedUser']['Livello'] == 9) {    //se l'utente non è stato ancora verificato
                        echo "La tua utenza è in fase di verifica, in questo momento sei al pari di un utente ospite. <br><br>";
                    }
                ?>
            </div>
            <br>
            <?php
                $_GET['previous']=null;
                $_GET['next']="./pagina2.php";
                include('footer.php');
            ?>
        </div>
    </body>
</html>
