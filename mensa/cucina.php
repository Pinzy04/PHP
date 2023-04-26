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

// preparazione del piatto
if (isset($_POST['submit'])) {
    $piatto = $_POST['piatto'];
    $quantita = $_POST['quantita'];
    $ing_suff = true;   // ingredienti_sufficienti
    $ing_count = 0;
    $message = "";

    $query = "SELECT i.id as id, i.nome as ingrediente, pi.quantita as q_ricetta, i.quantita as q_magazzino
        FROM piatti p, ingredienti i, piatti_ingredienti pi
        WHERE pi.id_piatto = p.id AND pi.id_ingrediente = i.id
        AND p.nome ='" . $piatto . "';";

    if (!$result = $mysqli->query($query)) exit;
    while ($row = $result->fetch_assoc()) {
        $ing_count++;
        if ($row['q_magazzino'] < $row['q_ricetta'] * $quantita)    // non ci sono abbastanza ingredienti nel magazzino
            $ing_suff = false;
    }

    if ($ing_suff && $ing_count > 0) {    // E' possibile cucinare il piatto

        if (!$result = $mysqli->query($query)) exit;    // riesegue la query per aggiornare il magazzino
        while ($row = $result->fetch_assoc()) {
            $nuova_quantita = $row['q_magazzino'] - $row['q_ricetta'] * $quantita;
            $update_query = "UPDATE ingredienti SET quantita = " . $nuova_quantita . " WHERE id = " . $row['id'] . ";";
            if (!$update = $mysqli->query($update_query)) exit;
        }

        // aggiorna la quantità di piatti
        $update_query = "UPDATE piatti SET quantita = quantita + " . $quantita . " WHERE nome = '" . $piatto . "';";
        if (!$update = $mysqli->query($update_query)) exit;

        $message = "Piatto cucinato";
    } else {
        $message = "Non è possibile cucinare il piatto. Controlla se ci sono abbastanza ingredienti o se la ricetta è valida";
    }
}

// aggiunta nuovo piatto
if (isset($_POST['nuovo_piatto'])) {
    $query = "SELECT id
    FROM piatti
    WHERE nome ='" . $_POST['piatto'] . "';";

    if (!$risultato = $mysqli->query($query)) exit;
    $result = $risultato->fetch_row();

    if ($result == NULL) {  // ne aggiunge uno nuovo
        $query = "INSERT INTO piatti (nome, quantita, misura, quantita_servita) VALUES ('" . $_POST['piatto'] . "', 0,'" . $_POST['misura'] . "', " . $_POST['quantita_servita'] . ");";
        if (!$risultato = $mysqli->query($query)) exit;
    }
}

// query per menu a tendina dei piatti
$piatti_query = "SELECT nome, quantita, misura, quantita_servita FROM piatti;";
if (!$risultato = $mysqli->query($piatti_query)) exit;

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
        <title>Cucina</title>
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

</style><?php
            include('header.php');
        ?> 
    <body>
          
        <div class="d-flex align-items-center flex-column" style="height: 200px;">

            <br><h1>Cucina</h1><br>

            <form action="" method="post">
                <label for="piatto">Seleziona piatto da cucinare:</label>
                <select class="animate__animated animate__pulse" name="piatto" id="piatto">
                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) {
                            echo "Error";
                            exit;
                        }

                        while ($row = $result->fetch_row()) {
                            echo "<option  value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <label for="quantita">Quantità:</label>
                <input class="animate__animated animate__pulse" required type="number" min="0.01" step="0.01" name="quantita" id="quantita">

                <input type="submit" class="btn btn-warning" name="submit" value="Cucina">
            </form>

            <?php if (isset($message) && $message != "") echo $message . "<br>"; ?>

            <br><h3>Piatti:</h3>
            <table >
                <thead>
                    <td><strong>Piatto</strong></td>
                    <td><strong>Quantità a disposizione</strong></td>
                    <td><strong>Quantità da servire</strong></td>
                </thead>

                <?php
                    $result = $mysqli->query($piatti_query);
                    if (!$result) {
                        echo "Error";
                        exit;
                    }

                    while ($row = $result->fetch_row()) {
                        echo "<tr>";
                        echo "<td>" . $row[0]  . "</td>";
                        echo "<td>" . $row[1]  . " " . $row[2] . "</td>";
                        echo "<td>" . $row[3]  . " " . $row[2] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>

            <br><form action="" method="post">
                <label for="piatto">Aggiungi piatto:</label>
                <input class="animate__animated animate__pulse" required type="text" name="piatto" id="piatto">
                <label for="misura">Unità di misura:</label>
                <input  class="animate__animated animate__pulse" required type="text" name="misura" id="misura">
                <label for="quantita_servita">Quantità da servire ai clienti:</label>
                <input  class="animate__animated animate__pulse" required type="number" min="0.01" step="0.01" name="quantita_servita" id="quantita_servita">
                <div align=center>
                <button type="submit" name="nuovo_piatto" class="btn btn-success">Inserisci</button>
                </div>
            </form>
        </div>

    </body>
</html>