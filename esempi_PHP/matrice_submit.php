<?php
session_start();

// righe e colonne della matrice di text
$r=4;
$c=5;

if(isset($_POST['R']))
{
   $_SESSION['valori']=null;
}

if(!isset($_SESSION['valori']))
{	
   // viene creata e azzerata 
   // la matrice di appoggio per i valori
   $_SESSION['valori'] = Array();
   for($j=0;$j<$r;$j++)
   {
      for($i=0;$i<$c;$i++)
      {
        $_SESSION['valori'][$j][$i]=0;
      } 
   }
}


// intercetta se ho premuto uno dei submit
// della matrice B
if(isset($_POST['B']))
{
   for($j=0;$j<$r;$j++)
   {
     for($i=0;$i<$c;$i++)
     {
		 // li percorro tutti per vedere 
		 // qualè l'unico che esiste
		 if(isset($_POST['B'][$j][$i]))
         {
			 //echo "Hai premuto ".$j."-".$i."<BR>";
			 $_SESSION['valori'][$j][$i]=1;
		 }	 
     } 
   }
}
	
	
?>

<HTML>
   <BODY>

   <!-- viene creato il FORM per gestire la matrice di text -->
   <FORM name='F1' method='POST' action='matrice_submit.php'>

      <?php
	  // tabella HTML contenente la matrice di submit
	  echo "<TABLE border='1'>";
      for($j=0;$j<$r;$j++)
	  {
		 echo "<TR>"; 
         for($i=0;$i<$c;$i++)
	     {
		    echo "<TD>";
            if($_SESSION['valori'][$j][$i]==0)
			   echo "<INPUT type='submit' name='B[".$j."][".$i."]' value='' />";
            else
			   echo "&nbsp;&nbsp;";	
		    echo "</TD>"; 
         }		  
		 echo "</TR>"; 
      }		  
	  echo "</TABLE>";
	  // fine tabella HTML
      ?>
	  
      <BR><INPUT type='submit' name='R' value='reset' />  	  
   </FORM>

   <BR><BR>

</BODY>
</HTML>
