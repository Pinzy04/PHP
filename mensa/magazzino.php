<?php

session_start();

// connessione al database
$mysqli = new mysqli("localhost", "root", "", "mensa");
if ($mysqli->connect_errno) {
    echo "non si connette: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

//gestione livelli di accesso
if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
    header('Location: ./login.php');    //vai alla pagina di login
}
if($_SESSION['selectedUser']['livello'] < 2) {  //controlla se l'utente ha il livello necessario per accedere alla pagina
    header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
}
if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout ("Effetua il logout")
    session_destroy();
    header('Location: ./login.php');    //torna alla pagina di login
    exit;
}

// aggiunta nuovo ingrediente
if (isset($_POST['nuovo_ing'])) {
    $query = "SELECT id
    FROM ingredienti
    WHERE nome ='" . $_POST['ingredienti'] . "';";

    if (!$risultato = $mysqli->query($query)) exit;
    $result = $risultato->fetch_row();

    if ($result == NULL) {  // ne aggiunge uno nuovo
        $query = "INSERT INTO ingredienti (nome, quantita, misura) VALUES ('" . $_POST['ingredienti'] . "', " . $_POST['quantita'] . ", '" . $_POST['misura'] . "');";
        if (!$risultato = $mysqli->query($query)) exit;
    }
}

// modifica ingrediente
if (isset($_POST['modifica_ing'])) {
    $query = "UPDATE ingredienti SET quantita = quantita + " . $_POST['quantita'] . " WHERE nome = '" . $_POST['ingredienti'] . "';";
    if (!$risultato = $mysqli->query($query)) exit;
}

// query per generare la tabella generale
$query = "SELECT nome, quantita, misura FROM ingredienti";
if (isset($_POST['piatto'])) {
    if ($_POST['seleziona_piatto'] != "tutto")
        $query = $query . "AND p.nome ='" . $_POST['seleziona_piatto'] . "';";
    else
        $query = $query . ";";
}
if (!$risultato = $mysqli->query($query)) exit;

// query per menu a tendina degli ingredienti
$ingredienti_query = "SELECT nome FROM ingredienti;";
if (!$risultato = $mysqli->query($ingredienti_query)) exit;

?>


<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Magazzino</title>
    </head>
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
</style>
    <body>
        <?php
            include('header.php');
        ?>   
        <div class="d-flex align-items-center flex-column" style="height: 200px;">


            <br><h1>Magazzino</h1>

            <br><table>

            <thead>
                <td><strong>Ingrediente</strong></td>
                <td><strong>Quantità</strong></td>
            </thead>

            <?php
                $result = $mysqli->query($query);
                if (!$result) {
                    echo "Error";
                    exit;
                }

                while ($row = $result->fetch_row()) {
                    echo "<tr>";
                    echo "<td>" . $row[0]  . "</td>";
                    echo "<td>" . $row[1]  . " " . $row[2] . "</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <?php if ($_SESSION['selectedUser']['livello'] >= 3):    // solo il livello 3 può aggiungere/modificare gli ingredienti?>

            <form action="" method="post">
                <label for="ingrediente">Aggiungi ingrediente:</label>
                <input class="animate__animated animate__pulse" required type="text" name="ingredienti" id="ingredienti">
                <label for="quantita">Quantità:</label>
                <input  class="animate__animated animate__pulse" required type="number" min="0.01" step="0.01" name="quantita" id="quantita">
                <label for="misura">Misura:</label>
                <input  class="animate__animated animate__pulse" required type="text" name="misura" id="misura">
                <div align=center>
                <button type="submit" name="nuovo_ing" class="btn btn-success">Inserisci</button>
                </div>
            </form>

            <form action="" method="post">
                
                <label for="ingrediente">Modifica ingrediente:</label>
                <select class="animate__animated animate__pulse" name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <label for="quantita">Quantità da aggiungere:</label>
                <input  class="animate__animated animate__pulse" required type="number" min="0.01" step="0.01" name="quantita" id="quantita">
                <div align=center>
                <button type="submit" class="btn btn-danger" id="b1" name="modifica_ing" >Modifica</button>
                </div>
            </form>

            <?php endif; ?>

         
        </div>

    </body>
</html>