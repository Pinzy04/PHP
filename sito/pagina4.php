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
    
    if (isset($_POST['GoToP3']))
    {
        header('Location: ./pagina3.php');
    }

    if (isset($_POST['edit']))
    {
        if(($_POST['nomeutente1'] != -1) && ($_POST['level'] != -1))
        {
            $_SESSION['utente'][$_POST['nomeutente1']]['livello'] = $_POST['level'];
            file_put_contents('./users.json', json_encode($_SESSION['utente'], JSON_PRETTY_PRINT));
        }
    }

    if (isset($_POST['remove']))
    {
        if($_POST['nomeutente2'] != -1)
        {
            array_splice($_SESSION['utente'],$_POST['nomeutente2'],1);
            file_put_contents('./users.json', json_encode($_SESSION['utente'], JSON_PRETTY_PRINT));
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title> Admin </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Benvenuto nella pagina 4 </h2>
            <img src="./pagina4.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['livello']."<br>";

                echo "<table class = 'table table-bordered'>";
                
                echo "<th scope='col'> Nome </th>";
                echo "<th scope='col'> Cognome </th>";
                echo "<th scope='col'> Username </th>";
                echo "<th scope='col'> Password </th>";
                echo "<th scope='col'> Livello </th>";
                
                echo "<tbody>";
                foreach($_SESSION['utente'] as $row)
                {
                    echo "<tr>";

                    foreach($row as $cell)
                    {
                        echo "<td>".$cell."</td>";
                    }

                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            ?>

            <form action = "pagina4.php" method = "post">
                <p> Per modificare il livello di accesso di un utente selezionare l'username e il livello nei campi sottostanti. </p>
                <label for="nomeutente1"> Username: </label>
                <select name="nomeutente1" id="utenti1">
                    <option value = -1> Seleziona utente</option>
                    <?php
                        $i = 0;
                        foreach($_SESSION['utente'] as $user)
                        {
                            echo "<option value = ".$i.">".$user['username']."</option>";
                            $i++;
                        }
                    ?>
                </select>

                <label for="level"> livello </label>
                <select name = "level" id="livelli">
                    <option value = -1> Scegli il livello</option>
                    <option value = 1> normale </option>
                    <option value = 2> amministratore </option>
                </select>
                <br><br>
                <input type = "submit" name = "edit" value = "Modifica" class = "btn btn-primary">

                <p> Per elimiare un utente selezionare l'username nel campo sottostante. </p>
                <label for="nomeutente2"> Username: </label>
                <select name="nomeutente2" id="utenti2">
                    <option value = -1> Seleziona utente</option>
                    <?php
                        $i = 0;
                        foreach($_SESSION['utente'] as $user)
                        {
                            echo "<option value = ".$i.">".$user['username']."</option>";
                            $i++;
                        }
                    ?>
                </select>
                <br><br>
                <input type = "submit" name = "remove" value = "Rimuovi" class = "btn btn-primary">
            </form>
            <br>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1, alla pagina 2 oppure alla pagina 4.</p>
            
            <form action = "pagina4.php" method = "post">
                <input type = "submit" name = "logout" value = "Effetua il logout" class = "btn btn-primary">
                <input type = "submit" name = "GoToP1" value = "Vai a Pagina 1" class = "btn btn-primary">
                <input type = "submit" name = "GoToP2" value = "Vai a Pagina 2" class = "btn btn-primary">
                <input type = "submit" name = "GoToP3" value = "Vai a Pagina 3" class = "btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>