<?php
   session_start();
   
   if(isset($_POST['R']))
   {
	   $_SESSION['y'] = null;
	   $_SESSION['x'] = null;
	   $_SESSION['mosse'] = null;
   }

   if(!isset($_SESSION['y']))
      $_SESSION['y'] = 4;
   if(!isset($_SESSION['x']))
      $_SESSION['x'] = 4;
   if(!isset($_SESSION['mosse']))
      $_SESSION['mosse'] = 0;

function disegnaTable($ri,$co,$to,$ul)
{
   echo "<table border='1'>";
   for($i = 0; $i < 9; $i++)
   {
      echo "<TR>";
      for($j=0;$j<9;$j++)
      {
         if(($ri == $i) && ($co == $j))
            echo "<td bgcolor='red'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
         else
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
      }
      echo "</tr>";
   }
   echo "</table>";
   echo "<BR>Ultima mossa:<B>".$ul."</B>";
   echo "<BR>Totale mosse:<B>".$to."</B>";
}


$r = $_SESSION['y'];
$c = $_SESSION['x'];
$t = $_SESSION['mosse'];
$u = "NULLA";

if(isset($_POST['N']))
{
   if($r > 0)
   {
      $r--;
      $t++;
      $u = "NORD";
   }
}
if(isset($_POST['E']))
{
   if($c < 8)
   {
      $c++;
      $t++;
      $u = "EST";
   }
}
if(isset($_POST['S']))
{
   if($r < 8)
   {
      $r++;
      $t++;
      $u = "SUD";
   }
}
if(isset($_POST['O']))
{
   if($c > 0)
   {
      $c--;
      $t++;
      $u = "OVEST";
   }
}

disegnaTable($r, $c, $t, $u);

$_SESSION['y'] = $r;
$_SESSION['x'] = $c;
$_SESSION['mosse'] = $t;

?>

<br><br>
<form name='F1' method='post' action='<?php echo $_SERVER['PHP_SELF']?>'>
   <table border='1'>
        <tr>
            <td>&nbsp;</td>
            <td><input type='submit' name='N' value='N'></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><input type='submit' name='O' value='O'></td>
            <td><input type='submit' name='R' value='R'></td>
            <td><input type='submit' name='E' value='E'></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type='submit' name='S' value='S'></td>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>
