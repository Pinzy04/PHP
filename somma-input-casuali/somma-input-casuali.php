<?php

// righe e colonne della matrice di text
$r=4;
$c=5;

// viene creata e azzerata 
// la matrice di appoggio per i valori
$valori = Array();
for($j=0;$j<$r;$j++)
{
   for($i=0;$i<$c;$i++)
   {
     $valori[$j][$i]=0;
   } 
}

// viene percorsa l'intera matrice di appoggio
// elemento per elemento
$somma=0;
for($j=0;$j<$r;$j++)
{
   for($i=0;$i<$c;$i++)
   {
	  // se premuto rigenera ogni elemento viene rigenerato 
      if(isset($_POST['R']))
      {
         $valori[$j][$i]=mt_rand(1,99);
	  }	 
	  // se premuto somma ogni elemento viene conservato e sommato
      if(isset($_POST['S']))
      {
		  $valori[$j][$i]=$_POST['T'][$j][$i];
		  $somma = $somma + $valori[$j][$i];
	  }	  
   } 
}

?>

<HTML>
   <BODY>

   <!-- viene creato il FORM per gestire la matrice di text -->
   <FORM name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>

      <?php
	  // tabella HTML contenente la matrice di text
	  echo "<TABLE border='1'>";
      for($j=0;$j<$r;$j++)
	  {
		 echo "<TR>"; 
         for($i=0;$i<$c;$i++)
	     {
		    echo "<TD>";
			// viene creato ogni singolo elemento della matrice di text 
			// in posizione $j $i
			// in ogni casella di testo viene messo il corrispondente valore
			// che in quel momento si trova nella matrice di appoggio
            echo "<INPUT type='text' name='T[".$j."][".$i."]' value='".$valori[$j][$i]."' size='1'/>";
		    echo "</TD>"; 
         }		  
		 echo "</TR>"; 
      }		  
	  echo "</TABLE>";
	  // fine tabella HTML
      ?>
	  
	  <BR>
      <INPUT type='submit' name='R'  value='rigenera'/>
      <INPUT type='submit' name='S'  value='somma'/>
      <INPUT type='text' name='S1' value='<?php echo $somma; ?>' size='2'/>
   </FORM>

   <BR><BR><BR>

</BODY>
</HTML>