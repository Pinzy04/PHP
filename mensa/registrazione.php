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
   background-color: black;
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



label {
  margin-bottom: 10px;
  font-weight: bold;
}
span {
  margin-bottom: 10px;
  font-weight: bold;
}
</style>
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
                     </div>
                    <div align=center>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <button type="submit"  name="signUp"  class="btn btn-success">Registrati</button>
                        </form>
               
           
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                       <button type="submit" id="b1" name="login"  class="btn btn-danger">Indietro</button>
                   
                </form>
        </div>
    </body>
</html>
