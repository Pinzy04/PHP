<?php
    $query="";

    if(isset($_POST['I1']) || isset($_POST['I2']) || isset($_POST['I3'])) {
        $database = new mysqli("localhost", "root", "", "scuola");
        if ($database -> connect_errno) {
            echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
        }
        if(isset($_POST['I1']))
            $query="SELECT Studenti.nome AS Nome, Studenti.cognome AS Cognome, Voti.voto AS Voto
                    FROM Voti
                    INNER JOIN Studenti ON Voti.ID_Studenti = Studenti.ID_Studenti
                    WHERE Studenti.nome = '".$_POST['nomeStudente']."' AND Studenti.cognome = '".$_POST['cognomeStudente']."';";
        if(isset($_POST['I2']))
            $query="SELECT Studenti.nome AS Nome, Studenti.cognome AS Cognome, Voti.voto AS Voto
                    FROM Voti
                    INNER JOIN Studenti ON Voti.ID_Studenti = Studenti.ID_Studenti
                    WHERE Voti.voto < ".(int)$_POST['max']." AND Voti.voto > ".(int)$_POST['min']."
                    ORDER BY Voti.voto;";
        if(isset($_POST['I3']))
            $query="SELECT Studenti.nome AS Nome, Studenti.cognome AS Cognome, MIN(Voti.voto) AS 'Voto minimo', MAX(Voti.voto) AS 'Voto massimo'
                    FROM Voti
                    INNER JOIN Studenti ON Voti.ID_Studenti = Studenti.ID_Studenti
                    GROUP BY Studenti.ID_Studenti 
                    ORDER BY Studenti.nome, Studenti.cognome;";
    }	   
?>

<!--
    - visualizzare i voti di uno specifico studente;
    - visualizzare i voti compresi tra un massimo e un minimo;
    - visualizzare il voto minimo e il voto massimo per ciascuno studente.
-->

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Es 1 php-mysql</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <h2>Esercizio 1 con PHP e MySQL</h2>
            <form name='F1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <div class="mb-3">
                    <p> Visualizza voti di uno specifico studente inserendo il nome e il cognome: </p>
                    <input type='text' name='nomeStudente' placeholder='Nome dello studente...'>
                    <input type='text' name='cognomeStudente' placeholder='Cognome dello studente...'>
                    <input type='submit' class="btn btn-dark" name='I1'>
                </div>
                <br>
                <div class="mb-3">
                    <p> Inserisci 2 numeri e visualizza i voti compresi tra i due numeri: </p>
                    <input type='text' name='min' placeholder='Numero più basso...'>
                    <input type='text' name='max' placeholder='Numero più alto...'>
                    <input type='submit' class="btn btn-dark" name='I2'>
                </div>
                <br>
                <div class="mb-3">
                    <p> Visualizza il voto più alto e il voto più basso di ogni specifico studente: </p>
                    <input type='submit' class="btn btn-dark" name='I3'>
                </div>
            </form>

            <?php
                if(isset($_POST['I1']) || isset($_POST['I2']) || isset($_POST['I3'])) {
                    // esegue la query e produce un recordset
                    if (!$risultato = $database -> query($query)) {
                        echo $query;
                    }

                    echo "<br><br>";

                    echo "<table class='table-responsive table-bordered'>";
                    echo "<thead>";
                    for($i = 0; $i < $risultato -> field_count; $i++) {
                        echo "<td><b>".$risultato -> fetch_field_direct($i) -> name."</b></td>";
                    }
                    echo "</thead>";
                    while ($row = $risultato -> fetch_row()) {
                        echo "<tr>";
                        for($i = 0; $i < $risultato -> field_count; $i++) {
                            echo "<td>".$row[$i]."</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </body>
</html>