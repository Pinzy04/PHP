<?php
    session_start();

    if (!isset($_SESSION['selectedUser'])) {    //controlla se l'utente non è loggato
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['vote'])) {  //se viene cliccato il tasto per andare alla pagina di votazione
        if($user['votato'] == 1) {
            echo "<script language='javascript'>alert('Hai già votato!');window.location.href='risultati.php';</script>";
            header("location: ./risultati.php");  //va alla pagina dei risultati
        } else {
            header("location: ./votazione.php");  //va alla pagina di votazione
        }
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
            <div class='box'>
                <?php
                    echo "<h1> Benvenuto ".$_SESSION['selectedUser']['username']."</h1><br>";
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <input type='submit' class="btn btn-outline-primary me-2" name='vote' value='Vota il giocatore'>
                    <br><br>
                    <input type="submit" class="btn btn-outline-danger me-2" name="logout" value="Logout">
                </form>
            </div>
        </div>
    </body>
</html>
