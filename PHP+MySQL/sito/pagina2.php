<?php
    session_start();

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
    
    if (isset($_POST['GoToP3']))
    {
        if($_SESSION['selectedUser']['Livello'] >= 1)
        {
            header('Location: ./pagina3.php');
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
        <title> Pagina 2 </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Benvenuto nella pagina 2 </h2>
            <img src="./pagina2.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1 oppure alla pagina 3.</p>
            
            <form action = "pagina2.php" method = "post">
                <input type = "submit" name = "logout" value = "Effetua il logout" class = "btn btn-primary">
                <input type = "submit" name = "GoToP1" value = "Vai a Pagina 1" class = "btn btn-primary">
                <input type = "submit" name = "GoToP3" value = "Vai a Pagina 3" class = "btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>