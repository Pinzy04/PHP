<?php
    $r = 4;
    $c = 5;
    for($i=0; $i<$r; $i++){
        for($j=0; $j<$c; $j++){
            $t[$i][$j] = "<INPUT type='submit' name='T[".$i."][".$j."]' value='&nbsp;' size='1'/>";
        }
    }
    for($i=0; $i<$r; $i++){
        for($j=0; $j<$c; $j++){
            if(isset($_POST['T['.$i.']['.$j.']'])){
                $t[$i][$j] = "<p></p>";
            }
        }
    }
?>

<html>
    <body>
        <form name='F1' method='POST' action='<?php echo $_SERVER['PHP_SELF']?>'>
            <?php
                echo "<TABLE border='1'>";
                for($i=0; $i<$r; $i++){
                    echo "<TR>"; 
                    for($j=0; $j<$c; $j++){
                        echo "<TD>";
                        echo $t[$i][$j];
                        echo "</TD>"; 
                    }		  
                    echo "</TR>"; 
                }		  
                echo "</TABLE>";
            ?>
        </form>
    </body>
</html>