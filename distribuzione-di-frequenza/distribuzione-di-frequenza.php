<?php
    $r = 0;
    $c = 0;
    $array = [];

    $colore=array();	  
    $colore[2]="rgb(100,0,0)";
    $colore[3]="rgb(0,100,0)";
    $colore[4]="rgb(0,0,100)";
    $colore[5]="rgb(100,100,0)";
    $colore[6]="rgb(0,100,100)";
    $colore[7]="rgb(100,0,100)";
    $colore[8]="rgb(0,0,0)";
    $colore[9]="rgb(100,100,100)";
    $colore[10]="rgb(200,0,100)";
    $colore[11]="rgb(100,0,200)";
    $colore[12]="rgb(0,100,200)";

    if(isset($_POST['B']))
    {
        $r=$_POST['R'];
        $c=$_POST['C'];
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset = "UTF-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
      
        <link rel = "stylesheet" href = "style.css">
    </head>
   <body>

        <form name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>
            <input type='text' name='R' size='3' value='<?php echo $r; ?>' />
            <input type='text' name='C'  size='3' value='<?php echo $c; ?>' />
            <input type='submit' name='B'  value='matrice'/>
        </form>

        <table border = '2' align = "center">

            <?php

                $dist=array();	  
                for($i = 2; $i <= 12; $i++)
                {
                    $freq[$i]=0;
                }
                for($i = 0; $i < $r; $i++)
                {
                    echo "<tr>";

                    for($j = 0; $j < $c; $j++)
                    {
                        $dadi = mt_rand(1,6) + mt_rand(1,6);
                        $freq[$dadi]++;
                        echo "<td width='50px' align='center' style='background-color: ".$colore[$dadi]."'>&nbsp;".$dadi."&nbsp;</td>";
                    }

                    echo "</tr>";
                }
                
                echo "</table>";
        
                echo "<br>";

                echo "<table border = '2' align = 'center'>";
            
                echo "<tr>";
                echo "<td width='50px' align='center'> Somma Dadi </td>";
                echo "<td width='50px' align='center'> Frequenza </td>";
                echo "</tr>";
                for($k = 2; $k < 12; $k++)
                {
                    echo "<tr>";
                    echo "<td width='50px' align='center' style='background-color: ".$colore[$k].">".$k."</td>";
                    echo "<td width='50px' align='center' style='background-color: ".$colore[$k].">".$freq[$k]."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>