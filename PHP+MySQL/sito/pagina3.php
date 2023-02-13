<?php
    session_start();

    $database=new mysqli("localhost", "root", "", "utenze");  //recupera il database
    if ($database -> connect_errno) {
        echo "non si connette: (".$database -> connect_errno.")".$database -> connect_error;
    }

    if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
    
        header('Location: ./login.php');    //torna alla pagina di login
    }

    if(!$_SESSION['selectedUser']['Livello'] >= 1 and $_SESSION['selectedUser']['Livello'] != 9) {  //controlla se l'utente ha il livello necessario per accedere alla pagina
        header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
    }

    if (isset($_POST['logout'])) {  //se viene cliccato il tasto di logout ("Effetua il logout")
        session_destroy();
        header('Location: ./login.php');    //torna alla pagina di login
        exit;
    }

    if (isset($_POST['GoToP1'])) {  //se viene cliccato il tasto della pagina 1 ("Vai a Pagina 1")
        header('Location: ./pagina1.php');  //va alla pagina 1
    }
    
    if (isset($_POST['GoToP2'])) {  //se viene cliccato il tasto della pagina 2 ("Vai a Pagina 2")
        header('Location: ./pagina2.php');  //va alla pagina 2
    }
    
    if (isset($_POST['GoToP4'])) {  //se viene cliccato il tasto della pagina 4 ("Vai a Pagina 4")
        if($_SESSION['selectedUser']['Livello'] >= 2 and $_SESSION['selectedUser']['Livello'] != 9) {   //controlla se l'utente ha il livello necessario per accedere alla pagina
            header('Location: ./pagina4.php');  //va alla pagina 4
        }
        else {
            header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
        }
    }

   

    if (isset($_POST['AddSpesa'])) {    //se viene cliccato il tasto di creazione spesa ("Nuova spesa")
        $query="INSERT INTO Spese (ID_Utente,dataspesa,importo,descrizione) VALUES (".$_SESSION['selectedUser']['ID_Utente'].",'".$_POST['DataSpesa']."',".$_POST['ImportoSpesa'].",'".$_POST['DescSpesa']."')";
        // esegue la query e produce un recordset
        if (!$risultato = $database->query($query)) {
           echo $query;
        }
  
     }	   
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Gestione spese agenti </title>
        <link rel='stylesheet' type='text/css' href='./public/style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    </head>
    <body>
        <div align=center class="container">
            <h1> Benvenuto nella pagina di gestione delle spese degli agenti</h1><br>
            <img src="./images/pagina3.jpg" class="figure-img img-fluid rounded"> <br>
            <?php
                echo "<div class='box'>";
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
                echo "</div><br>";
            
                $query="SELECT DATE_FORMAT(Spese.dataspesa, '%d/%m/%Y') AS 'Data spesa', Spese.importo AS 'Importo spesa(€)',Spese.descrizione AS 'Descrizione spesa' FROM Spese INNER JOIN Utenti ON Spese.ID_Utente=Utenti.ID_Utente WHERE Utenti.ID_Utente=".$_SESSION['selectedUser']['ID_Utente'];
                // esegue la query e produce un recordset
                if (!$risultato = $database->query($query)) {
                    echo $query;
                }   

                //crea la tabella con i dati del database
                echo "<div class='table-responsive'>";
                echo "<table align='center' border=3 class='table table-sm table-bordered border-dark'>";
                echo "<tr>";

                for($i=0;$i<$risultato->field_count;$i++) {
                    echo "<td><b>".$risultato->fetch_field_direct($i)->name."</B></TD>";
                }
                echo "</tr>";

                while ($row=$risultato->fetch_row()) {
                    echo "<tr>";
                    for($i=0;$i<$risultato->field_count;$i++) {

                        echo "<td>".$row[$i]."</TD>";

                    }
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            ?>
            <h2>Registrazione nuova spesa</h2> 
            <div class="box" style="background-color: coral;">
                <form align=left name='F1' method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="DataSpesa" class="form-label">Data spesa: </label>
                        <input class="form-control" type='date' id='today' name='DataSpesa' value='' required>
                    </div>

                    <div class="mb-3">
                        <label for="ImportoSpesa" class="form-label">Importo: </label>
                        <input class="form-control" type='number' name='ImportoSpesa' value='' required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="DescSpesa" class="form-label">Descrizione: </label>
                        <textarea class="form-control" name='DescSpesa' value=''></textarea>
                    </div>

                    <input class="btn btn-dark" type='submit' name='AddSpesa' value='Nuova spesa' >
                </form>
            </div>
            <br>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1, alla pagina 2 oppure alla pagina di amministrazione degli utenti.</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input class="btn btn-primary" type="submit" name="logout" value="Effetua il logout">
                <input class="btn btn-primary" type="submit" name="GoToP1" value="Vai a Pagina 1">
                <input class="btn btn-primary" type="submit" name="GoToP2" value="Vai a Pagina 2">
                <input class="btn btn-primary" type="submit" name="GoToP4" value="Vai alla pagina di amministrazione degli utenti">
            </form>
            <br><br>
        </div>
    </body>
    <script>
        document.getElementById('today').value = new Date().toISOString().slice(0,10);
    </script>
</html>
