<?php

   function calcola()
   {
      $sr=0;
      for($i=0;$i<8;$i++)
      {
         $sc=0;
         for($j=0;$j<8;$j++)
         {
           $sc=$sc+$_SESSION['tabella'][$i][$j];
         }
         $_SESSION['tabella'][$i][8]=$sc;
         $sr=$sr+$sc;
      }
      $_SESSION['tabella'][8][8]=$sr;

      $sc=0;
      for($j=0;$j<8;$j++)
      {
         $sr=0;
         for($i=0;$i<8;$i++)
         {
           $sr=$sr+$_SESSION['tabella'][$i][$j];
         }
         $_SESSION['tabella'][8][$j]=$sr;
         $sc=$sc+$sr;
      }
      $_SESSION['tabella'][8][8]=$sc;
   }

   function tabe($ri,$co)
   {
      echo "<TABLE border='1'>";
      for($i=0;$i<9;$i++)
      {
         echo "<TR>";
         for($j=0;$j<9;$j++)
         {
            if(($ri==$i) && ($co==$j))
               echo "<TD align='center' width='70px' height='30px'><INPUT type='text' name='CELLA' value='".$_SESSION['tabella'][$ri][$co]."' size='6'></FONT></TD>";
            else
               if(($i==8) || ($j==8))
                  echo "<TD bgcolor='#CCCCCC'  align='center' width='70px' height='30px'>".$_SESSION['tabella'][$i][$j]."</TD>";
               else
                  echo "<TD bgcolor='#FFFFCC'  align='center' width='70px' height='30px'>".$_SESSION['tabella'][$i][$j]."</TD>";
         }
         echo "</TR>";
      }
      echo "</TABLE>";
   }

   session_start();

?>

<HTML>
<BODY>

<?php

   if(!isset($_SESSION['ingresso']))
   {
      $_SESSION['riga']=4;
      $_SESSION['colonna']=4;
      $_SESSION['ingresso']=0;
      $_SESSION['tabella'] = array(
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                                array(0,0,0,0,0,0,0,0,0),
                          );
   }

?>


<?php

$r=$_SESSION['riga'];
$c=$_SESSION['colonna'];

if(isset($_POST['C']))
{
   $_SESSION['tabella'][$r][$c]=$_POST['CELLA'];
   calcola();
}

if(isset($_POST['N']))
   if($r>0)
     $r--;
if(isset($_POST['E']))
   if($c<7)
     $c++;
if(isset($_POST['S']))
   if($r<7)
     $r++;
if(isset($_POST['O']))
   if($c>0)
     $c--;

?>

<FORM NAME='F1' METHOD='post' ACTION='index.php'>
   <TABLE border='1'>
      <TR>
         <TD><INPUT type='submit' name='N' value='N'></TD>
         <TD><INPUT type='submit' name='S' value='S'></TD>
         <TD><INPUT type='submit' name='O' value='O'></TD>
         <TD><INPUT type='submit' name='E' value='E'></TD>
         <TD>&nbsp;&nbsp;&nbsp;&nbsp;</TD>
         <TD><INPUT type='submit' name='C' value='C'></TD>
      </TR>
   </TABLE>
   <BR>

<?php

tabe($r,$c);

$_SESSION['riga']=$r;
$_SESSION['colonna']=$c;

?>

</FORM>

</BODY>
</HTML>
