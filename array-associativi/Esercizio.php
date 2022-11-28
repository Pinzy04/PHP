<?php
session_start();

// se la rubrica non esiste la crea
if(!isset($_SESSION['nazionalita']))
{    
   $_SESSION['nazionalita']=array();
}   

$nome="";
$regione="";

// gestisco l'inserimento di un nuovo elemento
if(isset($_POST['NUOVO']))
{
   $i=count($_SESSION['nazionalita']);
   echo "Aggiunto nominativo<br>";
   $_SESSION['nazionalita'][$i]['nome']=$_POST['NOME'];
   $_SESSION['nazionalita'][$i]['regione']=$_POST['REGIONE'];

}

// gestisco la cancellazione di un elemento in una certa 
// posizione, compattando in seguito la rubrica
$cancella=0;
if(isset($_POST['CANCELLA']))
{
   $cancella=$_POST['CANC']*1;
   for($i=$cancella;$i<count($_SESSION['nazionalita'])-1;$i++)
   {
      $_SESSION['nazionalita'][$i]=$_SESSION['nazionalita'][$i+1];	   
   }
   array_pop($_SESSION['nazionalita']);
}

$i=count($_SESSION['nazionalita']);
echo "Nominativi: ".$i."<br>";

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <?php

		// form di inserimento dati
        echo "<form name='F1' method='post' action='".$_SERVER['PHP_SELF']."'>";
        echo "<TABLE border='1'>";
        echo "<TR><TD>Nome:</TD><TD><input type='text' name='NOME' size='5' value='".$nome."'></TD></TR>";   
        echo "<TR><TD>Cognome:</TD><TD><input type='text' name='REGIONE' size='5' value='".$regione."'></TD></TR>"; 
        echo "</TABLE>";
        echo "<input type='submit' name='NUOVO' value='nuovo'><BR><BR>";
		echo "<input type='text' name='CANC' size='3' value='".$cancella."'>";
        echo "<input type='submit' name='CANCELLA' value='cancella'>";
        echo "</form>";

        //visualizzazione di tutta la rubrica
	    echo "<TABLE border='1'>";
        for($i=0;$i<count($_SESSION['nazionalita']);$i++)
        {
           echo "<TR>";
           echo "<TD>".$i."</TD>";
           echo "<TD>".$_SESSION['nazionalita'][$i]['nome']."</TD>";
           echo "<TD>".$_SESSION['nazionalita'][$i]['regione']."</TD>";
           echo "</TR>";
        }
        echo "</TABLE>";
        ?>

    </body>
</html>
