<?php
    session_start();

    $database=new mysqli("localhost", "root", "", "sondaggio");  //connessione al database
    if ($database -> connect_errno) {
        echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
    }

    if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout ("Effetua il logout")
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['main'])) {  //se viene cliccato il tasto main page
        header('Location: ./pagina1.php');  //va alla pagina 1
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Risultati </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div align=center class="container">
            <?php
                echo "<h1> Benvenuto ".$_SESSION['selectedUser']['username']."! </h1><br>";
            ?>
            <h2> Risultati </h2>
            <div class='box' style='text-align: left;'>
                <?php
                    $query="SELECT nome,cognome,voti
                            FROM giocatori;";

                    if (!$risultato = $database->query($query)) {   // esegue la query e produce un recordset
                        echo $query;
                    }   

                    //crea la tabella con i dati del database
                    echo "<table border=3 class='table-sm table-bordered border-dark'>";

                    while ($row=$risultato->fetch_row()) {
                        echo "<tr>";
                        echo "<td>".$row[0]."&nbsp".$row[1]."</TD>";
                        for ($j=0; $j<$row[2]; $j++) {
                            echo "<td style='background-color: red'>&nbsp&nbsp&nbsp&nbsp</TD>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                ?>
                <br>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <input type="submit" class="btn btn-outline-primary me-2" name="main" value="Main page">
                </form>
            </div>
            <br>
        </div>
    </body>
</html>
