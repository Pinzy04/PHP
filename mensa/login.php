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
<style>
   @keyframes colorchange {
  0% {background-color: grey;} /* colore di sfondo iniziale */
  50% {background-color: lightgray;}
  100% {background-color: grey;} /* colore di sfondo finale */
}

.btn{
   width: 7em;
   height: 2.8em;
   margin: 0.5em;
   background: black;
   color: white;
   border: none;
   border-radius: 0.625em;
   font-size:  10px;
   font-display: center;
   font-weight: bold;
   cursor: pointer;
   position: relative;
   z-index: 1;
   overflow: hidden;
}
button:hover:after{
    transform: skewX(-45deg) scale(1, 1);
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    color: white;
}
button:hover{
    color: white;
}
button:after{
    content: "";
    caret-color: white;
    background: green;
    position: absolute;
    z-index: -1;
    left: -20%;
    top: 0;
    bottom: 0;
    right: -20%;
    transform: skewX(-45deg) scale(0, 1);
    transition: all 0.5s;
}
#b1:after{
    content: "";
    caret-color: white;
    background: red;
    position: absolute;
    z-index: -1;
    left: -20%;
    top: 0;
    bottom: 0;
    right: -20%;
    transform: skewX(-45deg) scale(0, 1);
    transition: all 0.5s;
}
#b1:hover{
    color: white;
}
#b1:hover:after{
    transform: skewX(-45deg) scale(1, 1);
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    color: white;
}
table {
    color: black;
  border-collapse: collapse;
  border-radius: 3px;
  border-color: black;
  border: 10px;
}

td, tr {
    
    border-color: black;
  border: 10px;
  padding: 10px;
  
}

table tr:hover{
    background-color: #8f8f8f; 
    animation-name: colorchange; /* nome dell'animazione */
  animation-duration: 3s; /* durata dell'animazione */
  animation-iteration-count: infinite;
}
select{
    
    border-radius: 0.625em;
   font-size:  15px;
   font-weight: bold;
}
input{
    border-radius: 0.625em;
   font-size:  15px;
   font-weight: bold;
}
input::-webkit-inner-spin-button::after {
  content: '\25b2'; /* codice unicode della freccia in su */
  font-size: 12px; /* dimensione del carattere */
  color: #333; /* colore della freccia */
}
input::-webkit-inner-spin-button::before {
  content: '\25bc'; /* codice unicode della freccia in giù */
  font-size: 12px; /* dimensione del carattere */
  color: #333; /* colore della freccia */
}

form:not(:last-child) {
  margin-bottom: 20px;
}
form {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

label {
  margin-bottom: 10px;
  font-weight: bold;
}
span {
  margin-bottom: 10px;
  font-weight: bold;
}
</style>
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
            <h2> Benvenuto esegui l'accesso per continuare </h2><br>
            <div class="box">
                <form align=left action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<i></i>
                    <span for="username" class="form-label">Username: </span>
                    <input class="form-control" type="text" name="username" size="40" placeholder="Inserisci il nome utente" required>
<i></i>
                    <span>Password: </span>
                    
                    <input class="form-control" type="password" name="pw" size="40" placeholder="Inserisci la password" required>
                    
                   
                    <div align=center>
                        <input type="submit" name="signIn" value="Accedi" class="btn btn-outline-warning me-2">
                </form>
                
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </body>
<style>

</style>
</html>
