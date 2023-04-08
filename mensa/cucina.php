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
    
    header('Location: ./login.php');    //torna alla pagina di login
}

if(!$_SESSION['selectedUser']['Livello'] == 2 or $_SESSION['selectedUser']['Livello'] == 9) {  //controlla se l'utente ha il livello necessario per accedere alla pagina
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
    $message = "";

    $query = "SELECT i.id as id, i.nome as ingrediente, pi.quantita as q_ricetta, i.quantita as q_magazzino
        FROM piatti p, ingredienti i, piatti_ingredienti pi
        WHERE pi.id_piatto = p.id AND pi.id_ingrediente = i.id
        AND p.nome ='" . $piatto . "';";

    if (!$result = $mysqli->query($query)) exit;
    while ($row = $result->fetch_assoc()) {
        if ($row['q_magazzino'] < $row['q_ricetta'] * $quantita)    // non ci sono abbastanza ingredienti nel magazzino
            $ing_suff = false;
    }

    if ($ing_suff) {    // E' possibile cucinare il piatto

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
        $message = "Non è possibile cucinare il piatto, mancano alcuni ingredienti";
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Cucina</title>
    </head>

    <body>

        <div class="d-flex align-items-center flex-column" style="height: 200px;">

            <br><h1>Cucina</h1><br>

            <form action="" method="post">
                <label for="piatto">Seleziona piatto da cucinare:</label>
                <select name="piatto" id="piatto">
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

                <label for="quantita">Quantità:</label>
                <input required type="number" min="0.01" step="0.01" name="quantita" id="quantita">

                <input type="submit" class="btn btn-warning" name="submit" value="Cucina il piatto">
            </form>

            <?php if (isset($message) && $message != "") echo $message . "<br>"; ?>

            <br><h3>Piatti:</h3>
            <table class="table table-striped table-bordered table-info">
                <thead>
                    <td><strong>Piatto</strong></td>
                    <td><strong>Quantità a disposizione</strong></td>
                    <td><strong>Misura</strong></td>
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
                        echo "<td>" . $row[1]  . "</td>";
                        echo "<td>" . $row[2]  . "</td>";
                        echo "<td>" . $row[3]  . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>

            <br><a href="index.php">Main page</a>
        </div>

    </body>
</html>