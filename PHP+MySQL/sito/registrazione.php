<?php
    session_start();
    $query="SELECT * 
            FROM Utenti 
            WHERE 1";
    
    if (isset($_POST['signUp'])) {  //se viene cliccato il tasto di signup ("Registrati")   
        $database=new mysqli("localhost", "root", "", "utenze");  //connessione al database
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
                
                echo "<script language='javascript'>
                        if (window.confirm('Utente registrato con successo. Esegui l\'accesso alla pagina di login.')) {
                            window.location.href='./login.php'; //torna alla pagina di login
                        };
                    </script>";
            } else {
                echo "<script language='javascript'> alert('Le password devono corrispondere'); </script>";
            }
        }
    }
    if (isset($_POST['login'])) {
        header("Location: ./login.php"); 
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registrazione </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container">
            <h1> Registrati al sito </h1><br>
            <h4>Dopo esserti registrato dovrai attendere che l'amministratore verifichi le tue credenziali di accesso.</h4>
            <div class="box">
                <form align=left action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="name" class="form-label"> Nome: </label>
                    <input type="text" name="name" class="form-control" size="40" required>

                    <label for="surname" class="form-label"> Cognome: </label>
                    <input type="text" name="surname" class="form-control" size="40" required>

                    <label for="username" class="form-label"> Username: </label>
                    <input type="text" name="username" class="form-control" size="40" required>

                    <label for="password" class="form-label"> Password: </label>
                    <input type="password" name="password" class="form-control" size="40" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                    
                    <label for="cpassword" class="form-label"> Confirm password: </label>
                    <input type="password" name="cpassword" class="form-control" size="40" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                    
                    <div align=center>
                        <input type="submit" name="signUp" value="Registrati" class="btn btn-dark">
                    
                </form>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <br><input type="submit" name="login" value="Torna al login" class="btn btn-dark">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
