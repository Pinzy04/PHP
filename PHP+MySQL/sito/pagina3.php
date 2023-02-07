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
        if($_SESSION['selectedUser']['Livello'] >= 2 and $_SESSION['selectedUser']['Livello'] != 9)   //controlla se l'utente ha il livello necessario per accedere alla pagina
        {
            header('Location: ./pagina4.php');  //va alla pagina 4
        }
        else
        {
            header('Location: ./acc_neg.php');  //va alla pagina di accesso negato
        }
    }

   

    if (isset($_POST['SC'])) {
        $dataspesa = $_POST['SD'];
        $importo = $_POST['SI'];
        $descrizione = $_POST['ST'];
        $ID = $_SESSION['selectedUser']['ID_Utente'];
        
        $query1 = "";
        $query1 = $query1."INSERT INTO Spese ";
        $query1 = $query1."(ID_Utenti,dataspesa,importo,descrizione) ";
        $query1 = $query1."VALUES ";
        $query1 = $query1."(".$ID.",".$dataspesa.",".$importo.",'".$descrizione."')";
  
        if (!$risultato1 = $database->query("INSERT INTO Spese (ID_Utenti,dataspesa,importo,descrizione) VALUES ".$ID.",".$dataspesa.",".$importo.",'".$descrizione."')")) {
           echo $query1;
        }
  
     }	   
?>

<!doctype html>
<html>
    <head>
        <title> Gestione spese agenti </title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
        <div align="center" class="box">
            <h2> Benvenuto nella pagina di gestione delle spese degli agenti</h2>

            <?php
                if (!$risultato = $database->query("SELECT Utenti.Cognome,Utenti.Nome,Spese.dataspesa,Spese.importo,Spese.descrizione FROM Spese INNER JOIN Utenti ON Spese.ID_Utente=Utenti.ID_Utente WHERE Utenti.ID_Utente=".$_SESSION['selectedUser']['ID_Utente'])) {
                    echo "SELECT Utenti.Cognome,Utenti.Nome,Spese.dataspesa,Spese.importo,Spese.descrizione FROM Spese INNER JOIN Utenti ON Spese.ID_Utente=Utenti.ID_Utente WHERE Utenti.ID_Utenti=".$_SESSION['selectedUser']['ID_Utente'];
                }

                echo "<H3>Agente :".$_SESSION['selectedUser']['Nome']." ".$_SESSION['selectedUser']['Cognome']."</H3>";   

                echo "<TABLE border='1'>";
                echo "<TR>";

                for($i=0;$i<$risultato->field_count;$i++)
                {
                    echo "<TD><B>".$risultato->fetch_field_direct($i)->name."</B></TD>";
                }
                echo "</TR>";

                while ($row=$risultato->fetch_row()) 
                {
                    echo "<TR>";
                    for($i=0;$i<$risultato->field_count;$i++)
                    {

                        echo "<TD>".$row[$i]."</TD>";

                    }
                    echo "</TR>";
                }
                echo "</TABLE>";
            ?>
            <H4>REGISTRAZIONE NUOVA SPESA</H4> 
            <FORM name='F1' method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                data spesa:<INPUT type='text' name='SD' size='4' value=''>&nbsp;&nbsp;
                importo:<INPUT type='text' name='SI' size='4' value=''>&nbsp;&nbsp;
                descrizione:<INPUT type='text' name='ST' size='8' value=''>&nbsp;&nbsp;
                <INPUT type='submit' name='SC' value='Nuova spesa'>
            </FORM>
            <img src="./images/pagina3.jpg"> <br>
            <?php
                echo "Nome: ".$_SESSION['selectedUser']['Nome']."<br>";
                echo "Cognome: ".$_SESSION['selectedUser']['Cognome']."<br>";
                echo "Livello: ".$_SESSION['selectedUser']['Livello']."<br>";
            ?>
            <p>Da questa pagina puoi segliere se effettuare il logout e tornare alla pagina di login, andare alla pagina 1, alla pagina 2 oppure alla pagina 4.</p>
            
            <form action="pagina3.php" method="post">
                <input type="submit" name="logout" value="Effetua il logout" class="btn btn-primary">
                <input type="submit" name="GoToP1" value="Vai a Pagina 1" class="btn btn-primary">
                <input type="submit" name="GoToP2" value="Vai a Pagina 2" class="btn btn-primary">
                <input type="submit" name="GoToP4" value="Vai alla pagina di gestione degli utenti" class="btn btn-primary">
            </form>
            <br><br>
        </div>
    </body>
</html>
