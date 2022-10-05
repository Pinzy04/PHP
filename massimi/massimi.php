<?php
   $r = 0;
   $c = 0;
   $max = 0;

   if(isset($_POST['B']))
   {
      $r=$_POST['R'];
      $c=$_POST['C'];
   }
?>

<HTML>
    <HEAD>
        <meta charset = "UTF-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
      
        <link rel = "stylesheet" href = "style.css">
    </HEAD>
   <BODY>

        <FORM name='F1' method='POST' action='massimi.php'>
           <INPUT type='text' name='R' size='3' value='<?php echo $r; ?>' />
           <INPUT type='text' name='C'  size='3' value='<?php echo $c; ?>' />
           <INPUT type='submit' name='B'  value='invio'/>
        </FORM>

        <TABLE border = '2' align = "center">

        <?php
           for($i = 0; $i < $r; $i++)
           {
              for($j = 0; $j < $c; $j++)
              {
                 $t[$i][$j] = mt_rand(1,99);

                 if($t[$i][$j] > $max)
                 {
                     $max = $t[$i][$j];
                 }
              }
            }


            for($i = 0; $i < $r; $i++)
            {
               echo "<TR>";
               for($j = 0; $j < $c; $j++)
               {
                  if($t[$i][$j] == $max)
                  {
                     echo "<TD width='50px' align='center' style='background-color: red'>&nbsp;".$t[$i][$j]."&nbsp;</TD>";
                  }
                  else
                  {
                     echo "<TD width='50px' align='center' style='background-color: white; color: black'>&nbsp;".$t[$i][$j]."&nbsp;</TD>";
                  }
               }
               echo "</TR>";
            }
        ?>

        </TABLE>
    </BODY>
</HTML>
