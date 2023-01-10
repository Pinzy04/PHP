<?php
   $query="";

   if(isset($_POST['I']))
   {
      // si connette al databasems (MySQL), fornendo, indirizzo, username, password
      // prendo in uso il database specificato
      $database = new mysqli("localhost", "root", "", "scuola");
      if ($database->connect_errno) {
         echo "non si connette: (" . $database->connect_errno . ") " . $database->connect_error;
      }
      $query=$_POST['A'];
   }	   
   
?>

<!--
   - visualizzare i voti di uno specifico studente;
   - visualizzare i voti compresi tra un massimo e un minimo;
   - visualizzare il voto minimo e il voto massimo per ciascuno studente.
-->

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Esercizio 1</title>
   </head>
   <body>
      <form name='F1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' >
         <br><br>
         <textarea name='A' cols='40' rows='10'><?php echo $query; ?></TEXTAREA>
         <br><br>
         <input type='submit' name='I' value='invia'>
      </form>

      <?php
         if(isset($_POST['I']) && (substr($query,0,6)=="SELECT" || substr($query,0,6)=="select"))
         {
            // esegue la query proveniente dalla TEXTAREA
            // e produce un recordset
            if (!$risultato = $database->query($query)) {
               echo "hai sbagliato qualcosa"."<br>".$query;
            }

            // intestazioni colonne 
            // mysql_num_fields($risultato) ci dice
            // quante colonne ci sono in $risultato
               for($i=0;$i<$risultato->field_count;$i++)
               {
               // legge il nome di ciascuna colonna  presente in $risultato
                  echo $risultato->fetch_field_direct($i)->name." ";
               }
            echo "<br>";
            echo "<br>";

            // qui viene visto ciascun record presente in $risultato
               // e per ciascun record viene mostrato
               // il valore di ciascun campo	 
               while ($row=$risultato->fetch_row()) 
               {
                  for($i=0;$i<$risultato->field_count;$i++)
                  {
                     echo $row[$i]." ";
               }		
                  echo "<br>";
               }
            echo "<br>";
            echo "<br>";

            // stessa cosa di prima ma intabellata
            // questa parte di codice va bene SEMPRE !!!!

            if (!$risultato = $database->query($query)) {
               echo "hai sbagliato qualcosa"."<br>".$query;
            }

            echo "<table border='1'>";
            echo "<tr>";
            
            for($i=0;$i<$risultato->field_count;$i++)
            {
               echo "<td><b>".$risultato->fetch_field_direct($i)->name."</b></td>";
            }
            echo "</tr>";

            while ($row=$risultato->fetch_row()) 
            {
               echo "<tr>";
               for($i=0;$i<$risultato->field_count;$i++)
               {
                  echo "<td>".$row[$i]."</td>";
               }
               echo "</tr>";
            }
            echo "</table>";
         }
      ?>
   </body>
</html>
