<?php

session_start();

// crea array contenente i piatti ordinati
if (!isset($_SESSION['ordine'])) {
    $_SESSION['ordine'] = array();
}

$limite_raggiunto = false;  // il limite di piatti che si possono ordinare
if (count($_SESSION['ordine']) >= 2)
    $limite_raggiunto = true;

//$_SESSION['ordine'] = null;

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

// aggiunge piatto all'ordine
if (isset($_GET['piatto']) && !$limite_raggiunto) {
    $piatto = $_GET['piatto'];  // il piatto scelto
    $piatto_valido = false;     // se il piatto è valido

    $query = "SELECT nome FROM piatti";
    if (!$result = $mysqli->query($query)) exit;

    while ($row = $result->fetch_row()) {   // controllo se il piatto è nel database
        if ($row[0] == $piatto)
            $piatto_valido = true;
    }

    if ($piatto_valido && !in_array($piatto, $_SESSION['ordine']))
        array_push($_SESSION['ordine'], $piatto);   // aggiunge il piatto
}

// rimuove piatto dall'ordine
if (isset($_GET['rimuovi'])) {
    $piatto = $_GET['rimuovi'];  // il piatto scelto
    $piatto_valido = false;     // se il piatto è valido

    $query = "SELECT nome FROM piatti";
    if (!$result = $mysqli->query($query)) exit;

    while ($row = $result->fetch_row()) {   // controllo se il piatto è nel database
        if ($row[0] == $piatto)
            $piatto_valido = true;
    }

    if ($piatto_valido && in_array($piatto, $_SESSION['ordine'])) {
        for ($i=0; $i < count($_SESSION['ordine']); $i++) {     // trova il piatto e lo rimuove
            if ($_SESSION['ordine'][$i] == $piatto) {
                unset($_SESSION['ordine'][$i]);
                $_SESSION['ordine'] = array_values($_SESSION['ordine']);
            }
        }
    }
}

// conferma dell'ordine
if (isset($_POST['ordine'])) {
    $message = "";

    $query = "SELECT nome, quantita, quantita_servita, id FROM piatti";
    if (!$result = $mysqli->query($query)) exit;

    while ($row = $result->fetch_row()) {
        if (in_array($row[0], $_SESSION['ordine'])) {   // se il piatto è nell'ordine
            if ($row[1] >= $row[2]) {    // se c'è abbastanza quantità per servire il cliente
                $quantita = $row[1] - $row[2];
                $update_query = "UPDATE piatti SET quantita = " . $quantita . " WHERE id = " . $row[3] . ";";
                if (!$update = $mysqli->query($update_query)) exit;

                $message = $message . "Ordine " . $row[0] . " eseguito<br>";
            }
            else    // se non c'e abbastanza quantità
                $message = $message . "Ordine " . $row[0] . " non eseguito<br>";
        }
    }

    $_SESSION['ordine'] = array();
}

// query per generare la tabella dei piatti
$query = "SELECT nome FROM piatti";
if (!$risultato = $mysqli->query($query)) exit;

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Mensa</title>
    </head>
    
 <?php
            include('header.php');
        ?> 
    <body>
        
        <div class="d-flex align-items-center flex-column" style="height: 200px;">

        <style>
  body {
 
  flex-direction: column;
  justify-content: center;
  align-items: center;
  
}
@keyframes colorchange {
  0% {background-color: grey;} /* colore di sfondo iniziale */
  50% {background-color: lightgray;}
  100% {background-color: grey;} /* colore di sfondo finale */
}
.btn{
   width: 6.5em;
   height: 2.3em;
   margin: 0.5em;
   background: black;
   color: white;
   border: none;
   border-radius: 0.625em;
   font-size:  20px;
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
    </style>
            <br><h1>Mensa</h1>

            <?php if ($_SESSION['selectedUser']['livello'] != 2):    // solo il livello 1 può effettuare ordini ?>

            <br><form action="" method="post">
                <h3>Il tuo ordine:</h3>

                <?php if (isset($message) && $message != "") echo $message . "<br>"; ?>

                <table >
                    <?php
                        echo "<tr>";
                        foreach ($_SESSION['ordine'] as $ord) {
                            echo "<td>" . $ord . "</td>";
                            echo "<td><a href='index.php?rimuovi=" . $ord . "'>
                                    <button type='button' class='btn btn-danger'>Rimuovi</button>
                                </a></td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </form>

            <?php if (isset($message) && $message != ""): ?>
                <p>Ps: se un ordine non è stato eseguito, vuol dire che il piatto non è disponibile. Prova a scegliere qualcos'altro.</p>
            <?php endif; ?>

            <br><form action="index.php" method="post">
            <div align=center>
                <h3>Scegli 2 piatti</h3>
                </div>

                <table >
                    <thed>
                        <td><strong>Piatto</strong></td>
                        <td><strong>Aggiungi</strong></td>
                    </thead>

                    <?php
                        $result = $mysqli->query($query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<tr>";
                            echo "<td>" . $row[0]  . "</td>";

                            if (in_array($row[0], $_SESSION['ordine']))
                                echo "<td><a href='index.php?piatto=" . $row[0] . "'>
                                        <button disabled type='button' class='btn btn-success'>Aggiungi</button></a></td>";
                            else
                                echo "<td><a href='index.php?piatto=" . $row[0] . "'>
                                        <button type='button' class='btn btn-success'>Aggiungi</button></a></td>";

                            echo "</tr>";
                        }
                    ?>
                </table>

                <?php
                    if (isset($piatto_valido) && !$piatto_valido)
                        echo "Il piatto inserito non è valido<br><br>";
                ?>
                <div align=center>
                <input class='btn btn-warning' type="submit"  name="ordine" value="avanti">
                </div>
            </form>

            <?php else: ?>
                <h3>Quest'area è riservata ai clienti</h3>
            <?php endif; ?>

        </div>

    </body>
    
</html>
