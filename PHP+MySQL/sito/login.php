<?php
    session_start();

    $query="SELECT * 
            FROM Utenti 
            WHERE 1";

    if (isset($_POST['signIn']))    //se viene cliccato il tasto di login ("Accedi")
    {  
        $database=new mysqli("localhost", "root", "", "utenze");  //recupera il database
        if ($database -> connect_errno) {
            echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error; 
        }

        foreach($database -> query($query) as $user)    //cerca l'utente con la relativa password
        {
            if (($user['Username'] == $_POST['username']) && (password_verify($_POST['password'], $user['Password']) || ($user['Password'] == $_POST['password']))) //quando viene trovato (password_verify() decripta la password dal database e la confronta con quella inserita)
            {
                $_SESSION['selectedUser']=$user;  //prende i dati dell'utente dal database e li mette in un array di sessione
                header("location: ./pagina1.php");  //va alla pagina 1
            }
        }
        // se il ciclo finisce l'utente è inesistente o la password è errata
        echo "<script type='text/javascript'>alert('Username e/o Password errati');</script>";
    }

    if (isset($_POST['guest']))     //se viene cliccato il tasto di login as guest ("Accedi come ospite")
    {
        $_SESSION['selectedUser']=array('Nome' => 'utente', 'Cognome' => 'ospite', 'Username' => 'utenteospite', 'Password' => null, 'Livello' => 0);
        header("location: ./pagina1.php");  //va alla pagina 1
    }

    if (isset($_POST['signUp']))    //se viene cliccato il tasto di signup ("Registrati")
    {
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
        <div align=center class="container">
            <h1> Benvenuto esegui l'accesso per continuare </h1><br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <p> Username: <input type="text" name="username" size="40" required></p>
                <p> Password: <input type="password" name="password" size="40" required></p>
                <p> 
                    *Dedicato esclusivamente alla fase di testing* <br>
                    Per accedere come amministratore usare le seguenti credenziali: <br>
                    Username -> "admin" <br>
                    Password -> "admin"
                </p>
                <p><input type="submit" name="signIn" value="Accedi" class="btn btn-primary"></p>
            </form>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <p><input type="submit" name="guest" value="Accedi come ospite" class="btn btn-primary"></p>
                <p><input type="submit" name="signUp" value="Registrati" class="btn btn-primary"></p>
            </form>
        </div>
    </body>
</html>
