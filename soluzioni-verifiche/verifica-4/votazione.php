<?php
    session_start();

    $database=new mysqli("localhost", "root", "", "sondaggio");  //connessione al database
    if ($database -> connect_errno) {
        echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
    }

    if (!isset($_SESSION['selectedUser'])) {    //controlla se l'utente non è loggato
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if($_SESSION['selectedUser']['votato'] == 1) {  //controlla se l'utente ha già votato
        header('Location: ./risultati.php');  //va alla pagina dei risultati
    }

    if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['main'])) {  //se viene cliccato il tasto della main page
        header('Location: ./pagina1.php');  //va alla pagina 1
    }

    if (isset($_POST['vote'])) {  //se viene cliccato il tasto per votare
        $id_giocatore = $_POST['votagiocatore'];
        $risultato = $database -> query("SELECT voti FROM giocatori WHERE ID_giocatori=$id_giocatore;");
        $voti = $risultato->fetch_row()[$id_giocatore];
        $voti++;
        $update="UPDATE giocatori
                 SET voti='$voti'
                 WHERE ID_giocatori=$id_giocatore;";
        $database -> query($update);   //update, aumenta il numero di voti del giocatore
        $updateuser="UPDATE utenti
                     SET votato='1'
                     WHERE ID_utenti=".$_SESSION['selectedUser']['ID_utenti'].";";
        $database -> query($updateuser);   //update, il giocatore ha votato
        $_SESSION['selectedUser']['votato']='1';
        header('Location: ./risultati.php');  //va alla pagina dei risultati
    }

    if (isset($_POST['results'])) {  //se viene cliccato il tasto per andare alla pagina dei risultati
        header('Location: ./risultati.php');  //va alla pagina dei risultati
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Votazione </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container">
            <div class='box'>
                <?php
                    echo "<h1> Benvenuto ".$_SESSION['selectedUser']['username']."! </h1><br>";
                ?>
                <h2> Votazione </h2>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <label for="votagiocatore"> Giocatore: </label>
                    <select name="votagiocatore">
                        <option value=-1 selected> Seleziona il giocatore </option>
                        <?php
                            $query="SELECT ID_giocatori,nome,cognome 
                                    FROM giocatori";

                            foreach($database -> query($query) as $player) {   // esegue la query e produce un recordset
                                echo "<option value=".$player['ID_giocatori']."> ".$player['nome']."&nbsp".$player['cognome']." </option>";
                            }
                        ?>
                    </select>
                    <br><br>
                    <input type="submit" class="btn btn-outline-success me-2" name="vote" value="Vota">
                    <input type="submit" class="btn btn-outline-primary me-2" name="main" value="Main page">
                </form>
            </div>
        </div>
    </body>
</html>
