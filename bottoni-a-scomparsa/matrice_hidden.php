<?php

// righe e colonne della matrice di text
$r=4;
$c=5;

// viene creata e azzerata 
// la matrice di appoggio per i valori
$valori = array();
for($j=0;$j<$r;$j++)
{
   for($i=0;$i<$c;$i++)
   {
     $valori[$j][$i]=0;
   } 
}

if(isset($_POST['B']))
{	
   for($j=0;$j<$r;$j++)
   {
      for($i=0;$i<$c;$i++)
      {
		 $valori[$j][$i]=$_POST['H'][$j][$i]; 
		 
         if(isset($_POST['B'][$j][$i]))
         { 	
            $valori[$j][$i]=1;
		 }
      } 
   }
}

?>

<HTML>
   <BODY>

   <!-- viene creato il FORM per gestire la matrice di text -->
   <FORM name='F1' method='POST' action='matrice_hidden.php'>

      <?php
	  // tabella HTML contenente la matrice di text
	  echo "<TABLE border='1'>";
      for($j=0;$j<$r;$j++)
	  {
		 echo "<TR>"; 
         for($i=0;$i<$c;$i++)
	     {
		    echo "<TD>";
			if($valori[$j][$i]==0)
               echo "<INPUT type='submit' name='B[".$j."][".$i."]' value='' />";
            else
			   echo "&nbsp;&nbsp;";	
		   
		    echo "</TD>"; 
			echo "<INPUT type='hidden' name='H[".$j."][".$i."]' value='".$valori[$j][$i]."' />";
         }		  
		 echo "</TR>"; 
      }		  
	  echo "</TABLE>";
	  // fine tabella HTML
      ?>
	  
	  <BR>
      <INPUT type='submit' name='R'  value='reset'/>
   </FORM>


</BODY>
</HTML>
