<?php
    session_start();
            
    if (isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit();
    }

    if (isset($_POST['signIn'])) {  //se viene cliccato il tasto di login ("Accedi")
        $mysqli=new mysqli("localhost", "root", "", "mensa");  //connessione al database
        if ($mysqli -> connect_errno) {
            echo "non si connette: (".$mysqli -> connect_errno.")".$mysqli -> connect_error; 
        }

        $query="SELECT id,nome,username,livello
                FROM utenti 
                WHERE username='" . $_POST['username'] . "' AND psw=PASSWORD('" . $_POST['pw'] . "');";

        if (!$result = $mysqli->query($query)) exit; else {
            if ($result->num_rows==0) {  // se la query non produce risultati l'utente è inesistente o la password è errata
                echo "<script language='javascript'>alert('Username e/o Password errati!');window.location.href='login.php';</script>"; 
            } else { 
                $_SESSION['selectedUser']=$result->fetch_array();  //prende i dati dell'utente dal database e li mette in un array di sessione
                header("location: ./index.php");  //va alla home page
            }
        }
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include('header.php');
        ?>   
        <div align=center class="container">
            <h1> Benvenuto esegui l'accesso per continuare </h1><br>
            <div class="box">
                <form align=left action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="username" class="form-label">Username: </label>
                    <input class="form-control" type="text" name="username" size="40" placeholder="Inserisci il nome utente" required>

                    <label for="password" class="form-label">Password: </label>
                    <input class="form-control" type="password" name="pw" size="40" placeholder="Inserisci la password" required>
                    
                    <p align=center> 
                        *Dedicato esclusivamente alla fase di testing* <br>
                        Per accedere come amministratore usare le seguenti credenziali: <br>
                        Username -> "admin" <br>
                        Password -> "admin"
                    </p>
                    <div align=center>
                        <input type="submit" name="signIn" value="Accedi" class="btn btn-outline-primary me-2">
                </form>
                
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
