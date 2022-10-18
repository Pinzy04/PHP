<?php
    $r = 9;
    $c = 9;

    for($i=0; $i<$r; $i++){
        for($j=0; $j<$c; $j++){
            if(isset($_POST["T$i$j"])){
                $_SESSION[$t[$i][$j]] = "<td><INPUT type='hidden' name='T$i$j' value='&nbsp;' size='1'></td>";
            }
            else{
                $_SESSION[$t[$i][$j]] = "<td><INPUT type='submit' name='T$i$j' value='&nbsp;' size='1'></td>";
            }
            
            if(isset($_POST["R"])){
                $_SESSION[$t[$i][$j]] = "<td><INPUT type='submit' name='T$i$j' value='&nbsp;' size='1'></td>";
            }
        }
    }
?>

<html>
    <body align='center'>
        <form name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>
            <?php
                echo "<TABLE border='1' align='center'>";
                for($i=0; $i<$r; $i++){
                    echo "<TR>"; 
                    for($j=0; $j<$c; $j++){
                        echo $t[$i][$j]; 
                    }		  
                    echo "</TR>"; 
                }		  
                echo "</TABLE>";
            ?>
            <br>
            <input type='submit' name='R' value='Reset'/>
        </form>
    </body>
</html>
