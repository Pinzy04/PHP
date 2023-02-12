<?php
    session_start();
    $query="SELECT * 
            FROM Utenti 
            WHERE 1";
    
    if (isset($_POST['signUp'])) {  //se viene cliccato il tasto di signup ("Registrati")   
        $database=new mysqli("localhost", "root", "", "utenze");  //recupera il database
        $esiste=false;
        foreach($database -> query($query) as $user) {   //cerca un utente con l'username uguale all'username inserito
            if ($user['Username'] == $_POST['username']) {   //se l'username inserito esiste già nel databas
                echo "<script language='javascript'> alert('Username già utilizzato da un altro utente.'); </script>";
                $esiste=true;
                break;
            }
        }
        if (!$esiste) { //se l'username inserito non esiste già nel database
            
            if ($_POST['password'] == $_POST['cpassword']) {    //se le password non corrispondono
                //inserisce i dati inseriti nel database e torna alla pagina di login
                
                $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);   //criptazione password
                $query="INSERT INTO utenti( `Nome`, 
                                            `Cognome`, 
                                            `Username`, 
                                            `Password`, 
                                            `Livello`) 
                                    VALUES( '".$_POST['name']."', 
                                            '".$_POST['surname']."', 
                                            '".$_POST['username']."', 
                                            '".$hashedPassword."', 
                                            9 );
                                        ";
                $database -> query($query);
                echo "<script language='javascript'> alert('Utente registrato con successo. Esegui l\'accesso alla pagina di login.'); </script>";
                header("Location: ./login.php");    //torna alla pagina di login
            } else {
                echo "<script language='javascript'> alert('Le password devono corrispondere'); </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registrazione </title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container-fluid">
            <h1> Registrati al sito </h1><br>
            <p>Dopo esserti registrato dovrai attendere che l'amministratore verifichi le tue credenziali di accesso.</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
