<?php
    session_start();

    $database = new mysqli("localhost", "root", "", "utenze");
    if ($database -> connect_errno) {
        echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
    }

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
        if(($_POST['useredit'] != -1) && ($_POST['level'] != -1))
        {
            $database -> query("UPDATE utenti SET livello = ".$_POST['level']." WHERE Username=='".$_POST['useredit']."';");
        }
    }

    if (isset($_POST['delete']))
    {
        if($_POST['userdelete'] != -1)
        {
            $database -> query("DELETE FROM utenti WHERE Username='".$_POST['userdelete']."';");
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
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";

                // esegue la query e produce un recordset
                if (!$risultato = $database -> query("SELECT * FROM Utenti WHERE 1")) {
                    echo "SELECT * FROM Utenti WHERE 1";
                }

                echo "<table align='center' class='table table-bordered'>";
                echo "<thead>";
                for($i = 0; $i < $risultato -> field_count; $i++) {
                    echo "<td><b>".$risultato -> fetch_field_direct($i) -> name."</b></td>";
                }
                echo "</thead>";
                while ($row = $risultato -> fetch_row()) {
                    echo "<tr>";
                    for($i = 0; $i < $risultato -> field_count; $i++) {
                        echo "<td>".$row[$i]."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            ?>

            <form action = "pagina4.php" method = "post">
                <p> Per modificare il livello di accesso di un utente selezionare l'username e il livello nei campi sottostanti. </p>
                <label for="useredit"> Username: </label>
                <select name="useredit">
                    <option value = -1> Seleziona utente</option>
                    <?php
                        $i = 0;
                        foreach($database -> query("SELECT * FROM Utenti WHERE 1") as $user)
                        {
                            echo "<option value = ".$i.">".$user['Username']."</option>";
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
                <label for="userdelete"> Username: </label>
                <select name="userdelete">
                    <option value = -1> Seleziona utente</option>
                    <?php
                        $i = 0;
                        foreach($database -> query("SELECT * FROM Utenti WHERE 1") as $user)
                        {
                            echo "<option value = ".$i.">".$user['Username']."</option>";
                            $i++;
                        }
                    ?>
                </select>
                <br><br>
                <input type = "submit" name = "delete" value = "Elimina" class = "btn btn-primary">
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