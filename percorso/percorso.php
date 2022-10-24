<?php
    session_start();

    // righe e colonne della matrice
    $r = 9;
    $c = 9;
    
    


    if(isset($_POST['R']))
    {
        $_SESSION['valori'] = null;
    }

    if(!isset($_SESSION['valori']))
    {
        $_SESSION['x'] = 4;
        $_SESSION['y'] = 4;
        $_SESSION['contMosse'] = 0;
        $_SESSION['ultima'] = '';

        $_SESSION['valori'] = Array();
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {   
                if($i == $_SESSION['x'] && $j == $_SESSION['y'])
                {
                    $_SESSION['valori'][$i][$j] = 1;
                }
                else
                {
                    $_SESSION['valori'][$i][$j] = 0;
                }
            }
        }
    }

    if(isset($_POST['N']) && $_SESSION['x'] > 0)
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                if($_SESSION['valori'][$i][$j] == 1)
                {
                    $_SESSION['valori'][$i][$j] = 0;
                    $_SESSION['x'] = $_SESSION['x'] - 1;
                    $_SESSION['valori'][$_SESSION['x']][$_SESSION['y']] = 1;
                    $_SESSION['contMosse']++;
                    $_SESSION['ultima'] = 'N';
                }
            } 
        }
    }

    if(isset($_POST['O']) && $_SESSION['y'] > 0)
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                if($_SESSION['valori'][$i][$j] == 1)
                {
                    $_SESSION['valori'][$i][$j] = 0;
                    $_SESSION['y'] = $_SESSION['y'] - 1;
                    $_SESSION['valori'][$_SESSION['x']][$_SESSION['y']] = 1;
                    $_SESSION['contMosse']++;
                    $_SESSION['ultima'] = 'O';
                }
            } 
        }
    }

    if(isset($_POST['E']) && $_SESSION['y'] < 8)
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                if($_SESSION['valori'][$i][$j] == 1)
                {
                    $_SESSION['valori'][$i][$j] = 0;
                    $_SESSION['y'] = $_SESSION['y'] + 1;
                    $_SESSION['valori'][$_SESSION['x']][$_SESSION['y']] = 1;
                    $_SESSION['contMosse']++;
                    $_SESSION['ultima'] = 'E';
                }
            } 
        }
    }

    if(isset($_POST['S']) && $_SESSION['y'] < 8)
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                if($_SESSION['valori'][$i][$j] == 1)
                {
                    $_SESSION['valori'][$i][$j] = 0;
                    $_SESSION['x'] = $_SESSION['x'] + 1;
                    $_SESSION['valori'][$_SESSION['x']][$_SESSION['y']] = 1;
                    $_SESSION['contMosse']++;
                    $_SESSION['ultima'] = 'S';
                }
            } 
        }
    }
?>

<html>
   <body align='center' style="text-align: center; background: #6495ED">

        <!-- viene creato il FORM per gestire la matrice di text -->
        <form name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>

            <?php
                // tabella HTML contenente la matrice di submit
                echo "<table border='1' align='center'>";
                for($i=0; $i<$r; $i++)
                {
                    echo "<tr>"; 
                    for($j=0; $j<$c; $j++)
                    {
                        if($_SESSION['valori'][$i][$j] == 1)
                        {
                            echo "<td style='background: red'> &nbsp;&nbsp;&nbsp;&nbsp; </td>";
                        }
                        else
                        {
                            echo "<td style='background: white'> &nbsp;&nbsp;&nbsp;&nbsp; </td>"; 
                        }
                        
                    }		  
                    echo "</tr>"; 
                }		  
                echo "</table>";
                // fine tabella HTML

                echo "<p>Numero mosse eseguite: </p>".$_SESSION['contMosse'];
                echo "<p>Ultima mossa eseguite: </p>".$_SESSION['ultima'];
            ?>
            
            <br>

            <table border='1' align='center'>
                <tr>
                    <td style='background: white'> &nbsp;&nbsp;&nbsp;&nbsp; </td>
                    <td><input type='submit' name='N' value='N' /></td>
                    <td style='background: white'> &nbsp;&nbsp;&nbsp;&nbsp; </td>
                </tr>
                <tr>
                    <td><input type='submit' name='O' value='O' /></td>
                    <td><input type='submit' name='R' value='R' /></td>
                    <td><input type='submit' name='E' value='E' /></td>
                </tr>
                    <td style='background: white'> &nbsp;&nbsp;&nbsp;&nbsp; </td>
                    <td><input type='submit' name='S' value='S' /></td>
                    <td style='background: white'> &nbsp;&nbsp;&nbsp;&nbsp; </td>
                </tr>
            </table>
        </form>

        <br><br>

    </body>
</html>