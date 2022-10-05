<?php
    $r = 0;
    $s = ['sasso', 'carta', 'forbice'];
    if(isset($_POST['B']))
    {
        $r=$_POST['R'];
    }

    function esito($g1, $g2)
    {
        if($g1 == 0 && $g2 == 0)
        {
            return "Pareggio";
        }

        if($g1 == 0 && $g2 == 1)
        {
            return "G2 vince";
        }

        if($g1 == 0 && $g2 == 2)
        {
            return "G1 vince";
        }



        if($g1 == 1 && $g2 == 1)
        {
            return "Pareggio";
        }

        if($g1 == 1 && $g2 == 2)
        {
            return "G2 vince";
        }

        if($g1 == 1 && $g2 == 0)
        {
            return "G1 vince";
        }



        if($g1 == 2 && $g2 == 2)
        {
            return "Pareggio";
        }

        if($g1 == 2 && $g2 == 0)
        {
            return "G2 vince";
        }

        if($g1 == 2 && $g2 == 1)
        {
            return "G1 vince";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" href = "style.css">
    </head>
    <body>
        <h1 align='center'>Sasso Carta Forbice</h1>
        <form name='F1' method='POST' action='sasso-carta-forbice.php'>
           <input type='text' name='R' size='3' value='<?php echo $r; ?>' />
           <input type='submit' name='B'  value='play'/>
        </form>
        <table border = '2' align='center'>

            <tr>
                <td width='250px' align='center'>G1</td>
                <td width='250px' align='center'>G2</td>
                <td width='250px' align='center'>Esito</td>
            </tr>

            <?php
                for($i = 0; $i < $r; $i++)
                {
                    $g1=rand(0, 2);
                    $g2=rand(0, 2);
                    echo "<tr>";
                        echo "<td width='50px' align='center'>".$s[$g1]."</td>";
                        echo "<td width='50px' align='center'>".$s[$g2]."</td>";
                        echo "<td width='50px' align='center'>".esito($g1, $g2)."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>