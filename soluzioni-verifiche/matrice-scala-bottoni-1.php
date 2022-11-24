<?php
session_start();

// righe e colonne della matrice di text
$r=10;
$c=10;

if(isset($_POST['R']))
{
   $_SESSION['valori']=null;
   $_SESSION['conta']=0;
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
        $_SESSION['valori'][$j][$i]=1;
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
			 // scala dalla cima della colonna
			 for($k=0;$k<$c;$k++)
             {
				 if($_SESSION['valori'][$k][$i]==1)
				 {
				    $_SESSION['valori'][$k][$i]=0;
				    $_SESSION['conta']++;
				    $k=$r;
				 }   
		     }		 
			 
		 }	 
     } 
   }
}
	
	
?>

<HTML>
   <BODY>

   <!-- viene creato il FORM per gestire la matrice di text -->
   <FORM name='F1' method='POST' action='<?php $_SERVER['PHP_SELF']?>'>

      <?php
	  // tabella HTML contenente la matrice di submit
	  echo "<TABLE border='1'>";
      for($j=0;$j<$r;$j++)
	  {
		 echo "<TR>"; 
         for($i=0;$i<$c;$i++)
	     {
		    echo "<TD style='width:30px;height:30px;'>";
            if($_SESSION['valori'][$j][$i]==1)
			   echo "<INPUT type='submit' style='width:30px;height:30px;background-color:red;' name='B[".$j."][".$i."]' value='' />";
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
      &nbsp;&nbsp;Eliminati:<INPUT type='text' name='C' size='4' value='<?php echo $_SESSION['conta']; ?>' />  	  
   </FORM>

   <BR><BR>

</BODY>
</HTML>
