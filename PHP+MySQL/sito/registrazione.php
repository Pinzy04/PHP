<?php
    session_start();
    
    if (isset($_POST['signUp']))    //se viene cliccato il tasto di signup ("Registrati")
    {   
        $database=new mysqli("localhost", "root", "", "utenze");  //recupera il database
        $esiste=false;
        foreach($database -> query("SELECT * FROM Utenti WHERE 1") as $user)    //cerca un utente con l'username uguale all'username inserito
        {
            if ($user['Username'] == $_POST['username'])    //se l'username inserito esiste già nel database
            {
                echo "<script language='javascript'> alert('Username già utilizzato da un altro utente.'); </script>";
                $esiste=true;
                break;
            }
        }
        if (!$esiste)   //se l'username inserito non esiste già nel database
        {
            if ($_POST['password'] == $_POST['cpassword']) {    //se le password non corrispondono
                //inserisce i dati inseriti nel database e torna alla pagina di login
                
                $options = [
                    'cost' => 12,
                ];
                $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, $options); //criptazione password

                $database -> query("INSERT INTO utenti( `Nome`, `Cognome`, `Username`, `Password`, `Livello` ) VALUES( '".$_POST['name']."', '".$_POST['surname']."', '".$_POST['username']."', '".$hashedPassword."', 9 );");
                echo "<script language='javascript'> alert('Utente registrato con successo. Esegui l\'accesso alla pagina di login.'); </script>";
                header("Location: ./login.php");    //torna alla pagina di login
            } else {
                echo "<script language='javascript'> alert('Le password devono corrispondere'); </script>";
            }
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title> Registrazione </title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align="center" class="box">
            <h2> Registrati al sito </h2> <br>
            <p>Dopo esserti registrato dovrai attendere che l'amministratore verifichi le tue credenziali di accesso.</p>
            <form action="registrazione.php" method="post">
                <p> Nome: <input type="text" name="name" size="40" required></p>
                <p> Cognome: <input type="text" name="surname" size="40" required></p>
                <p> Username: <input type="text" name="username" size="40" required></p>
                <p> Password: <input type="password" name="password" size="40" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                <p> Confirm password: <input type="password" name="cpassword" size="40" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                <p><input type="submit" name="signUp" value="Registrati" class="btn btn-primary"></p>
            </form>
            <form action="login.php" method="post">
                <p><input type="submit" name="login" value="Torna al login" class="btn btn-primary"></p>
            </form>
        </div>
    </body>
</html>
