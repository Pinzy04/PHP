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
    $query = "SELECT p.id, i.id
    FROM piatti p, piatti_ingredienti pi, ingredienti i
    WHERE p.id = pi.id_piatto AND pi.id_ingrediente = i.id AND p.nome = '" . $_POST['piatti'] . "' AND i.nome ='" . $_POST['ingredienti'] . "';";

    if (!$risultato = $mysqli->query($query)) exit;
    $result = $risultato->fetch_row();

    if ($result == NULL) {  // ne aggiunge uno nuovo
        $query = "SELECT p.id, i.id
        FROM piatti p, ingredienti i
        WHERE p.nome = '" . $_POST['piatti'] . "' AND i.nome = '" . $_POST['ingredienti'] . "';";

        if (!$risultato = $mysqli->query($query)) exit;
        $result = $risultato->fetch_row();
        $piatto_id = $result[0];
        $ingrediente_id = $result[1];

        $query = "INSERT INTO piatti_ingredienti (id_piatto, id_ingrediente, quantita) VALUES ('" . $piatto_id . "', '" . $ingrediente_id . "', " . $_POST['quantita'] . ");";
        if (!$risultato = $mysqli->query($query)) exit;
    } else {    // modifica quello già esistente
        $query = "SELECT p.id, i.id
        FROM piatti p, ingredienti i
        WHERE p.nome = '" . $_POST['piatti'] . "' AND i.nome = '" . $_POST['ingredienti'] . "';";

        if (!$risultato = $mysqli->query($query)) exit;
        $result = $risultato->fetch_row();
        $piatto_id = $result[0];
        $ingrediente_id = $result[1];

        $query = "UPDATE piatti_ingredienti SET quantita = " . $_POST['quantita'] . " WHERE id_piatto = " . $piatto_id . " AND id_ingrediente = " . $ingrediente_id . ";";
        if (!$risultato = $mysqli->query($query)) exit;
    }
}

// rimozione ingrediente
if (isset($_POST['rimuovi_ing'])) {
    $query = "SELECT p.id, i.id
    FROM piatti p, piatti_ingredienti pi, ingredienti i
    WHERE p.id = pi.id_piatto AND pi.id_ingrediente = i.id AND p.nome = '" . $_POST['piatti'] . "' AND i.nome ='" . $_POST['ingredienti'] . "';";

    if (!$risultato = $mysqli->query($query)) exit;
    $result = $risultato->fetch_row();

    if ($result != NULL) {
        $query = "SELECT p.id, i.id
        FROM piatti p, ingredienti i
        WHERE p.nome = '" . $_POST['piatti'] . "' AND i.nome = '" . $_POST['ingredienti'] . "';";

        if (!$risultato = $mysqli->query($query)) exit;
        $result = $risultato->fetch_row();
        $piatto_id = $result[0];
        $ingrediente_id = $result[1];

        $query = "DELETE FROM piatti_ingredienti WHERE id_piatto = " . $piatto_id . " AND id_ingrediente = " . $ingrediente_id . ";";
        if (!$risultato = $mysqli->query($query)) exit;
    }
}


// query per generare la tabella generale
$query = "SELECT p.nome, i.nome, pi.quantita, i.misura
    FROM piatti p, ingredienti i, piatti_ingredienti pi
    WHERE pi.id_piatto = p.id AND pi.id_ingrediente = i.id ";
if (isset($_POST['piatto'])) {
    if ($_POST['seleziona_piatto'] != "tutto")
        $query = $query . "AND p.nome ='" . $_POST['seleziona_piatto'] . "';";
    else
        $query = $query . ";";
}
if (!$risultato = $mysqli->query($query)) exit;

// query per menu a tendina dei piatti
$piatti_query = "SELECT nome FROM piatti;";
if (!$risultato = $mysqli->query($piatti_query)) exit;

// query per menu a tendina degli ingredienti
$ingredienti_query = "SELECT nome FROM ingredienti;";
if (!$risultato = $mysqli->query($piatti_query)) exit;

?>


<!DOCTYPE html>
<html lang="en">
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
#b1:after{
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
.colonna {
  width: 20%;
  vertical-align: top;
  float:left;
}
</style>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Ricette</title>
    </head>

    <body>
        <?php
            include('header.php');
        ?>   
        <div class="d-flex align-items-center flex-column" style="height: 200px;">


            <br><h1>Ricette</h1>


            <form action="" method="post">
                <label for="piatto">Seleziona ricetta:</label>
                <select  class="animate__animated animate__pulse" name="seleziona_piatto" id="piatto">
                    <option value="tutto">Tutto</option>

                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) {
                            echo "Error";
                            exit;
                        }

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <input type="submit" class="btn btn-warning" name="piatto" value="Cerca">
            </form>

            <br><table >
                <thead>
                    <td><strong>Piatto</strong></td>
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
                        echo "<td>" . $row[1]  . "</td>";
                        echo "<td>" . $row[2]  . " " . $row[3] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
<br>
<div class="colonna">
            <form action="" method="post">
                <label for="ingrediente">Aggiungi o modifica ingrediente:</label>
                <select  class="animate__animated animate__pulse" name="piatti" id="piatti">
                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <select  class="animate__animated animate__pulse" name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>
                
                <label for="quantita">Quantità:</label>
                <input  class="animate__animated animate__pulse" required type="number" min="0.01" step="0.01" name="quantita" id="quantita">
                <div align=center>
                <button type="submit"  class="btn btn-success" id="b1" name="nuovo_ing" >Inserisci</button>
                </div>
            </form>
            </div>
            <div class="colonna">
            <br><form action="" method="post">
                <label for="ingrediente">Rimuovi ingrediente:</label>
                <select  class="animate__animated animate__pulse" name="piatti" id="piatti">
                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <select  class="animate__animated animate__pulse" name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>
                <div align=center>
                <button type="submit" class="btn btn-danger" name="rimuovi_ing">Rimuovi</button>
                </div>
            </form>
            </div>
         
        </div>

    </body>
</html>