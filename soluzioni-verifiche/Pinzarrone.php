<?php
    session_start();
    if(isset($_SESSION['tabella1']) && isset($_SESSION['tabella2']))
    {
        $_SESSION['tabella1'] = array();

        for($i = 0; $i < 7; $i++)
        {
            $_SESSION['tabella1'][$i] = array();
            for($j = 0; $j < 2; $j++)
            {
                $_SESSION['tabella1'][$i][$j] = '&nbsp';
            }
        }

        $_SESSION['tabella2'] = array();

        for($i = 0; $i < 7; $i++)
        {
            $_SESSION['tabella2'][$i] = array();
            for($j = 0; $j < 2; $j++)
            {
                $_SESSION['tabella2'][$i][$j] = '&nbsp';
            }
        }
    }
    
    
    for($i = 0; $i < 7; $i++)
    {
        for($j = 0; $j < 2; $j++)
        {
            if(isset($_POST["T1[$i][$j]"]))
            {
                $ci1 = $i;
                $cj1 = $j;
                $c1 = true;
            }
            else
            {
                $c1 = false;
            }

            if(isset($_POST["T2[$i][$j]"]))
            {
                $ci2 = $i;
                $cj2 = $j;
                $c2 = true;
            }
            else
            {
                $c2 = false;
            }
        }
    }

    if(isset($_POST['C']))
    {
        if($c1)
        {
            $_SESSION['tabella1'][$ci1][$cj1] = $_POST["testo"];
        }
        if($c2)
        {
            $_SESSION['tabella2'][$ci2][$cj2] = $_POST["testo"];
        }
        
    }

?>
<!doctype html>
<html>
    <head>
        <title> Verifica PHP </title>
        <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel = "stylesheet">
    </head>
    <body>
        <form action = "<?php echo $_SERVER['PHP_SELF']?>" method = "post">
                <?php

                    echo "<div>";

                    echo "<table border='1'>";

                    for($i = 0; $i < 7; $i++)
                    {
                        echo "<tr>";
                        
                        for($j = 0; $j < 2; $j++)
                        {
                            echo "<td align='center' width='200px' height='50px'>";
                            if($_SESSION['tabella1'][$i][$j] == '&nbsp')
                            {
                                echo "<input type=submit name='T1[$i][$j]' value=".$_SESSION['tabella1'][$i][$j]." style='width: 200px; height: 50px; background-color: green'>";
                            }
                            else
                            {
                                echo "<input type=submit name='T1[$i][$j]' value=".$_SESSION['tabella1'][$i][$j]." style='width: 200px; height: 50px; background-color: red'>";
                            }
                            echo "</td>";
                        }

                        echo "</tr>";
                    }

                    echo "</table>";

                    echo "</div>";

                    echo "<br><br>";

                    echo "<div>";

                    echo "<table border='1'>";
                    
                    for($i = 0; $i < 7; $i++)
                    {
                        echo "<tr>";
                        
                        for($j = 0; $j < 2; $j++)
                        {
                            echo "<td align='center' width='200px' height='50px'>";
                            if($_SESSION['tabella2'][$i][$j] == '&nbsp')
                            {
                                echo "<input type=submit name='T2[$i][$j]' value=".$_SESSION['tabella2'][$i][$j]." style='width: 200px; height: 50px; background-color: green'>";
                            }
                            else
                            {
                                echo "<input type=submit name='T2[$i][$j]' value=".$_SESSION['tabella2'][$i][$j]." style='width: 200px; height: 50px; background-color: red'>";
                            }
                            echo "</td>";
                        }

                        echo "</tr>";
                    }

                    echo "</table>";

                    echo "</div>";

                    echo "<br><br><br>";

                    echo "<div align='center' style='background-color: mediumpurple; width: 200px; height: 70px;'>";
                    echo "<input type=text name='testo'>";
                    echo "<input type=submit name='C' value='Invia'>";
                    echo "</div>";
                ?>
        </form>
    </body>
</html>
