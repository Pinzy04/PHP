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
if($_SESSION['selectedUser']['livello'] < 3) {  //controlla se l'utente ha il livello necessario per accedere alla pagina
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
if (isset($_POST['nuovo_ing'])) {
    //$query = "UPDATE ingredienti SET (nome, quantita, misura) VALUES ('" . $_POST['ingredienti'] . "', " . $_POST['quantita'] . ", '" . $_POST['misura'] . "');";
    //if (!$risultato = $mysqli->query($query)) exit;
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Magazzino</title>
    </head>

    <body>
        <?php
            include('header.php');
        ?>   
        <div class="d-flex align-items-center flex-column" style="height: 200px;">


            <br><h1>Magazzino</h1>

            <br><table class="table table-striped table-bordered table-info">

            <thead>
                <td><strong>Ingrediente</strong></td>
                <td><strong>Quantità</strong></td>
                <td><strong>Misura</strong></td>
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
                    echo "<td>" . $row[2]  . "</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <form action="" method="post">
                <label for="ingrediente">Aggiungi ingrediente:</label>
                <input required type="text" name="ingredienti" id="ingredienti">
                <label for="quantita">Quantità:</label>
                <input required type="number" min="0.01" step="0.01" name="quantita" id="quantita">
                <label for="misura">Misura:</label>
                <input required type="text" name="misura" id="misura">
                <input type="submit" name="nuovo_ing" value="Inserisci">
            </form>

            <form action="" method="post">
                <label for="ingrediente">Modifica ingrediente:</label>
                <select name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <label for="quantita">Quantità da aggiungere:</label>
                <input required type="number" min="0.01" step="0.01" name="quantita" id="quantita">
                <input type="submit" name="modifica_ing" value="Modifica">
            </form>

            <br><a href="index.php">Main page</a>
        </div>

    </body>
</html>