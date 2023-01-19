<?php
    session_start();

    $query="";

    if (isset($_POST['signIn']))
    {
        if (($_POST['username'] != "") && ($_POST['password'] != ""))
        {       
            $database = new mysqli("localhost", "root", "", "utenze");
            if ($database -> connect_errno) {
                echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
            }
            foreach($database -> query("SELECT * FROM Utenti WHERE 1") as $user)
            {
                if (($user['Username'] == $_POST['username']) && ($user['Password'] == $_POST['password']))
                {
                    $_SESSION['selectedUser'] = $user;
                    header("location: ./pagina1.php");
                }
            }
            echo "<script type = 'text/javascript'>alert('Username e/o Password errati');</script>";
        }
        else
        {
            echo "<script type = 'text/javascript'>alert('Alcuni dati sono mancanti');</script>";
        }
    }

    if (isset($_POST['guest']))
    {
        $_SESSION['selectedUser'] = array('Nome' => 'utente', 'Cognome' => 'ospite', 'Username' => 'utenteospite', 'Password' => null, 'Livello' => 0);
        header("location: ./pagina1.php");
    }

    if (isset($_POST['signUp']))
    {
        header("location: ./registrazione.php");
    }
?>
<!doctype html>
<html>
    <head>
        <title> Login </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Benvenuto esegui l'accesso per continuare </h2> <br>
            <form action = "login.php" method = "post">
                <p> Username: <input type = "text" name = "username" size = "40"></p>
                <p> Password: <input type = "password" name = "password" size = "40"></p>
                <p>
                    <input type = "submit" name = "signIn" value = "Accedi" class = "btn btn-primary">
                    <input type = "reset" name = "cancella" value = "Cancella" class = "btn btn-primary"> <br><br>
                    <input type = "submit" name = "guest" value = "Accedi come ospite" class = "btn btn-primary"><br><br>
                    <input type = "submit" name = "signUp" value = "Registrati" class = "btn btn-primary">
                </p>
            </form>
        </div>
    </body>
</html>