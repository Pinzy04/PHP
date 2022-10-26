<?php
    session_start();

    $r = 10;
    $c = 10;
    $_SESSION['ult'] = 0;
    $_SESSION['next'] = true;

    if(isset($_POST['R']))
    {
        $_SESSION['valori'] = null;
        for($i = 0; $i < $r; $i++)
        {
            for($j = 0; $j < $c; $j++)
            {
                $_SESSION['numeri'][$i][$j] = rand(1, 100);
                $_SESSION['mosse'] = 0;
            }
        }
        
    }

    if(!isset($_SESSION['valori']))
    {
        for($i = 0; $i < $r; $i++)
        {
            for($j = 0; $j < $c; $j++)
            {
                $_SESSION['valori'][$i][$j] = 0;
            } 
        }
    }

    if(isset($_POST['B']))
    {
        $_SESSION['mosse']++;

        for($i = 0; $i < $r; $i++)
        {
            for($j = 0; $j < $c; $j++)
            {
                if(isset($_POST['B'][$i][$j]))
                {
                    $_SESSION['valori'][$i][$j] = 1;
                }	 
            } 
        }
    }

?>

<html>
    <head>
        <meta charset = "UTF-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">

        <link rel = "stylesheet" href = "style.css">
    </head>
    <body>
        <div id='sfondo'>
            <form name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>
                <?php
                echo "<table border='1' align='center' style='font-size: 36px' >";
                echo "<tr>";
                echo "<td>Mosse: ".$_SESSION['mosse']."</td>";
                echo "<td><input type='submit' name='R' value='Reset' style='font-size: 38px' /></td>";
                echo "</tr>";
                echo "</table>";
                echo "<table border='1' align='center'>";
                
                for($i = 0; $i < $r; $i++)
                {
                    echo "<tr>"; 
                    for($j = 0; $j < $c; $j++)
                    {
                        echo "<td>";
                        if($_SESSION['valori'][$i][$j] == 0)
                        {
                            echo "<input type='submit' class='bottone' name='B[".$i."][".$j."]' value='&nbsp;' />";
                        }
                        else
                        {
                            echo $_SESSION['numeri'][$i][$j];
                        }
                        echo "</td>"; 
                    }		  
                    echo "</tr>"; 
                }		  
                echo "</table>";
                ?>
                <br>
            </form>
        </div>
    </body>
</html>