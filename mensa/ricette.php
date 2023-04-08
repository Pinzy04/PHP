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

// rimozione nuovo ingrediente
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
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <select name="seleziona_piatto" id="piatto">
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

                <input type="submit" class="btn btn-warning" name="piatto" value="Cerca ricetta">
            </form>

            <br><table class="table table-striped table-bordered table-info">
                <thead>
                    <td><strong>Piatto</strong></td>
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
                        echo "<td>" . $row[3]  . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>

            <form action="" method="post">
                <label for="ingrediente">Aggiungi o modifica ingrediente:</label>
                <select name="piatti" id="piatti">
                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <select name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>
                
                <label for="quantita">Quantità:</label>
                <input required type="number" min="0.01" step="0.01" name="quantita" id="quantita">

                <input type="submit" class="btn btn-warning" name="nuovo_ing" value="Inserisci">
            </form>


            <br><form action="" method="post">
                <label for="ingrediente">Rimuovi ingrediente:</label>
                <select name="piatti" id="piatti">
                    <?php
                        $result = $mysqli->query($piatti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <select name="ingredienti" id="ingredienti">
                    <?php
                        $result = $mysqli->query($ingredienti_query);
                        if (!$result) exit;

                        while ($row = $result->fetch_row()) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                        }
                    ?>
                </select>

                <input type="submit" class="btn btn-warning" name="rimuovi_ing" value="Rimuovi">
            </form>

            <br><a href="index.php">Main page</a>
        </div>

    </body>
</html>