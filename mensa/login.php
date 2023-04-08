<?php
    session_start();

    $query="SELECT * 
            FROM Utenti 
            WHERE 1";
            
    if (isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit();
    }

    if (isset($_POST['signIn'])) {  //se viene cliccato il tasto di login ("Accedi")
        $database=new mysqli("localhost", "root", "", "utenze");  //connessione al database
        if ($database -> connect_errno) {
            echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error; 
        }

        foreach($database -> query($query) as $user) {   //cerca l'utente con la relativa password
            if (($user['Username'] == $_POST['username']) && (password_verify($_POST['password'], $user['Password']) || ($user['Password'] == $_POST['password']))) {   //quando viene trovato (password_verify() decripta la password dal database e la confronta con quella inserita)
                $_SESSION['selectedUser']=$user;  //prende i dati dell'utente dal database e li mette in un array di sessione
                header("location: ./pagina1.php");  //va alla pagina 1
            }
        }
        // se il ciclo finisce l'utente è inesistente o la password è errata
        echo "<script language='javascript'>alert('Username e/o Password errati!');window.location.href='login.php';</script>";
    }

    if (isset($_POST['guest'])) {   //se viene cliccato il tasto di login as guest ("Accedi come ospite")
        $_SESSION['selectedUser']=array('Nome' => 'utente', 'Cognome' => 'ospite', 'Username' => 'utenteospite', 'Password' => null, 'Livello' => 0);
        header("location: ./pagina1.php");  //va alla pagina 1
    }

    if (isset($_POST['signUp'])) {  //se viene cliccato il tasto di signup ("Registrati")
        header("location: ./registrazione.php");    //va alla pagina di registrazione
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Login </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            $_GET['current']=-1;
            include('header.php');
        ?>   
        <div align=center class="container">
            <h1> Benvenuto esegui l'accesso per continuare </h1><br>
            <div class="box">
                <form align=left action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="username" class="form-label">Username: </label>
                    <input class="form-control" type="text" name="username" size="40" placeholder="Inserisci il nome utente" required>

                    <label for="password" class="form-label">Password: </label>
                    <input class="form-control" type="password" name="password" size="40" placeholder="Inserisci la password" required>
                    
                    <p align=center> 
                        *Dedicato esclusivamente alla fase di testing* <br>
                        Per accedere come amministratore usare le seguenti credenziali: <br>
                        Username -> "admin" <br>
                        Password -> "admin"
                    </p>
                    <div align=center>
                        <input type="submit" name="signIn" value="Accedi" class="btn btn-outline-light me-2">
                </form>
                
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
