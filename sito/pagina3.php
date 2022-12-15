<?php
    session_start();

    $_SESSION['utente'] = json_decode(file_get_contents('./users.json'), true);

    if (!isset($_SESSION['selectedUser']))
    {
        header('Location: ./login.php');
    }

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
    
    if (isset($_POST['GoToP2']))
    {
        header('Location: ./pagina2.php');
    }
    
    if (isset($_POST['GoToP4']))
    {
        if($_SESSION['selectedUser']['livello'] >= 2)
        {
            header('Location: ./pagina4.php');
        }
        else
        {
            header('Location: ./acc_neg.php');
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title> Pagina 3 </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Benvenuto nella pagina 3 </h2>
            <img src="./pagina3.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1, alla pagina 2 oppure alla pagina 4.</p>
            
            <form action = "pagina3.php" method = "post">
                <input type = "submit" name = "logout" value = "Effetua il logout" class = "btn btn-primary">
                <input type = "submit" name = "GoToP1" value = "Vai a Pagina 1" class = "btn btn-primary">
                <input type = "submit" name = "GoToP2" value = "Vai a Pagina 2" class = "btn btn-primary">
                <input type = "submit" name = "GoToP4" value = "Vai a Pagina 4" class = "btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>