<?php
    session_start();
    $query="SELECT * 
            FROM Utenti 
            WHERE 1";
    
    if (isset($_POST['signUp'])) {  //se viene cliccato il tasto di signup ("Registrati")   
        $mysqli=new mysqli("localhost", "root", "", "mensa");  //connessione al database
        $esiste=false;
        foreach($mysqli -> query($query) as $user) {   //cerca un utente con l'username uguale all'username inserito
            if ($user['username'] == $_POST['username']) {   //se l'username inserito esiste già nel database
                echo "<script language='javascript'>alert('Username già utilizzato da un altro utente!');window.location.href='registrazione.php';</script>";
                $esiste=true;
                break;
            }
        }
        if (!$esiste) { //se l'username inserito non esiste già nel database
            if ($_POST['password'] == $_POST['cpassword']) {    //se le password non corrispondono
                //inserisce i dati inseriti nel database e torna alla pagina di login
                
                $query="INSERT INTO utenti( `nome`, 
                                            `username`, 
                                            `psw`, 
                                            `livello`) 
                                    VALUES( '".$_POST['name']."', 
                                            '".$_POST['username']."', 
                                            PASSWORD('".$_POST['password']."'), 
                                            1 );
                                        ";
                $mysqli -> query($query);
                
                echo "<script language='javascript'>alert('Utente registrato con successo! Esegui l\'accesso alla pagina di login.');window.location.href='login.php';</script>";
            } else {
                echo "<script language='javascript'>alert('Le password devono corrispondere!');window.location.href='registrazione.php';</script>";
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container">
            <h1> Registrati al sito </h1><br>
            <h4>Dopo esserti registrato dovrai attendere che l'amministratore verifichi le tue credenziali di accesso.</h4>
            <div class="box">
                <form align=left action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="name" class="form-label"> Nome: </label>
                    <input type="text" name="name" class="form-control" size="40" placeholder="Inserisci il tuo nome" required>

                    <label for="username" class="form-label"> Username: </label>
                    <input type="text" name="username" class="form-control" size="40" placeholder="Inserisci il tuo nome utente" required>

                    <label for="password" class="form-label"> Password: </label>
                    <input type="password" name="password" class="form-control" size="40" placeholder="Crea una password" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                    
                    <label for="cpassword" class="form-label"> Conferma password: </label>
                    <input type="password" name="cpassword" class="form-control" size="40" placeholder="Ripeti la password" pattern="[0-9A-Za-z]{8,30}" title="La password deve essere minimo di 8 caratteri e deve contenere almeno una lettera maiuscola, una minuscola e un numero" required></p>
                    
                    <div align=center>
                        <input type="submit" name="signUp" value="Registrati" class="btn btn-outline-success me-2">
                    
                </form>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <br><input type="submit" name="login" value="Torna al login" class="btn btn-outline-danger me-2">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
