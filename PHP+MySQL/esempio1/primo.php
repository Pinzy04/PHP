<?php

   $query="";

   if(isset($_POST['I']))
   {
      // si connette al dbms (MySQL), fornendo, indirizzo, username, password
      // prendo in uso il database specificato

      $mysqli = new mysqli("localhost", "root", "", "scuola");
      if ($mysqli->connect_errno) {
         echo "non si connette: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }

      $query=$_POST['A'];
  
	  
   }	   
   
?>

<HTML>

<BODY>

   <FORM name='F1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' >
     <TEXTAREA name='A' cols='40' rows='10'><?php echo $query; ?></TEXTAREA>
     <BR><BR>
     <INPUT type='submit' name='I' value='invia'>
   </FORM>

<?php

if(isset($_POST['I']) && substr($query,0,6)=="SELECT")
{
	  // esegue la query proveniente dalla TEXTAREA
	  // e produce un recordset
	  if (!$risultato = $mysqli->query($query)) {
		   echo $query;
	  }

	  // intestazioni colonne 
	  // mysql_num_fields($risultato) ci dice
	  // quante colonne ci sono in $risultato
      for($i=0;$i<$risultato->field_count;$i++)
      {
		 // legge il nome di ciascuna colonna  presente in $risultato
         echo $risultato->fetch_field_direct($i)->name." ";
      }
	  echo "<BR>";
	  echo "<BR>";

	  // qui viene visto ciascun record presente in $risultato
      // e per ciascun record viene mostrato
      // il valore di ciascun campo	 
      while ($row=$risultato->fetch_row()) 
      {
         for($i=0;$i<$risultato->field_count;$i++)
         {
            echo $row[$i]." ";
	     }		
         echo "<BR>";
      }
	  echo "<BR>";
	  echo "<BR>";

   // stessa cosa di prima ma intabellata
   // questa parte di codice va bene SEMPRE !!!!

    if (!$risultato = $mysqli->query($query)) {
	   echo $query;
	}

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

}
   
?>
   
</BODY>

</HTML>
