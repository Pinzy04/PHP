<?php
    session_start();

    if (isset($_POST['signUp']))
    {   
        if (($_POST['name'] != "") && ($_POST['surname'] != "") && ($_POST['username'] != "") && ($_POST['password'] != ""))
        {
            $esiste = false;
            foreach($_SESSION['utente'] as $user)
            {
                if ($_POST['username'] == $user['username'])
                {
                    echo "<script language = 'javascript'> alert('Username già utilizzato da un altro utente.'); </script>";
                    $esiste = true;
                    break;
                }
            }
            if (!$esiste)
            {
                $_SESSION['utente'][count($_SESSION['utente'])] = array('nome' => $_POST['name'], 'cognome' => $_POST['surname'], 'username' => $_POST['username'], 'password' => $_POST['password'], 'livello' => 1);
                echo "<script language = 'javascript'> alert('Utente registrato con successo. Esegui l\'accesso alla pagina di login.'); </script>";
                file_put_contents('./users.json', json_encode($_SESSION['utente'], JSON_PRETTY_PRINT));
                header("Location: ./login.php");
            }
        }
        else
        {
            echo "<script language = 'javascript'> alert('Alcuni dati sono mancanti'); </script>";
        }
    }

    if (isset($_POST['login']))
    {
        header("location: ./login.php");
    }
    
?>

<!doctype html>
<html>
    <head>
        <title> Registrazione </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <div align = "center" class = "box">
            <h2> Registrati al sito </h2> <br>
            <form action = "registrazione.php" method = "post">
                <p> Nome: <input type = "text" name = "name" size = "40"></p>
                <p> Cognome: <input type = "text" name = "surname" size = "40"></p>
                <p> Username: <input type = "text" name = "username" size = "40"></p>
                <p> Password: <input type = "password" name = "password" size = "40"></p>
                <p>
                    <input type = "submit" name = "signUp" value = "Registra" class = "btn btn-primary">
                    <input type = "reset" name = "cancella" value = "Cancella" class = "btn btn-primary"> <br><br>
                    <input type = "submit" name = "login" value = "Torna al login" class = "btn btn-primary">
                </p>
            </form>
        </div>
    </body>
</html>