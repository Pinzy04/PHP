<?php
    session_start();

    // righe e colonne della matrice
    $r = 9;
    $c = 9;
    $v = 4;
    $o = 4;

    if(isset($_POST['R']))
    {
        $_SESSION['valori']=null;
    }

    if(!isset($_SESSION['valori']))
    {
        $_SESSION['valori'] = Array();
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {   
                if($i == 4 && $j == 4)
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

    if(isset($_POST['N']))
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                $v++;
                $_SESSION['valori'][$o][$v] = 1;
            } 
        }
    }

    if(isset($_POST['O']))
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                $o--;
                $_SESSION['valori'][$o][$v] = 1;
            } 
        }
    }

    if(isset($_POST['E']))
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                $o++;
                $_SESSION['valori'][$o][$v] = 1;
            } 
        }
    }

    if(isset($_POST['S']))
    {
        for($i=0; $i<$r; $i++)
        {
            for($j=0; $j<$c; $j++)
            {
                $v--;
                $_SESSION['valori'][$o][$v] = 1;
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
                        if($i == $o && $j == $v)
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
            ?>
            
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
