<?php
    session_start();

    if (isset($_POST['reset'])) {
        $_SESSION['rubrica'] = null;
    }

    if (!isset($_SESSION['rubrica'])) {    
        $_SESSION['rubrica'] = array();
    }

    if (!isset($_SESSION['regioni'])) {    
        $_SESSION['regioni'] = array(
            array("nome" => "Valle D'Aosta"),
            array("nome" => "Piemonte"),
            array("nome" => "Lombardia"),
            array("nome" => "Liguria"),
            array("nome" => "Trentino-Alto Adige"),
            array("nome" => "Veneto"),
            array("nome" => "Friuli-Venezia Giulia"),
            array("nome" => "Emilia Romagna"),
            array("nome" => "Toscana"),
            array("nome" => "Umbria"),
            array("nome" => "Marche"),
            array("nome" => "Abruzzo"),
            array("nome" => "Lazio"),
            array("nome" => "Molise"),
            array("nome" => "Campania"),
            array("nome" => "Basilicata"),
            array("nome" => "Puglia"),
            array("nome" => "Calabria"),
            array("nome" => "Sardegna"),
            array("nome" => "Sicilia"),
        );

        $_SESSION['colori'] = array(
            "Valle D'Aosta" => "red",
            "Piemonte" => "red",
            "Lombardia" => "red",
            "Liguria" => "red",
            "Trentino-Alto Adige" => "red",
            "Veneto" => "red",
            "Friuli-Venezia Giulia" => "red",
            "Emilia Romagna" => "red",
            "Toscana" => "yellow",
            "Umbria" => "yellow",
            "Marche" => "yellow",
            "Abruzzo" => "yellow",
            "Lazio" => "yellow",
            "Molise" => "blue",
            "Campania" => "blue",
            "Basilicata" => "blue",
            "Puglia" => "blue",
            "Calabria" => "blue",
            "Sardegna" => "green",
            "Sicilia" => "green",
        );
    }

    if(isset($_POST['submit'])) {
        $i = count($_SESSION['rubrica']);
        echo "Aggiunto nominativo in rubrica<br>";
        $_SESSION['rubrica'][$i]['nome']=$_POST['nome'];
        $_SESSION['rubrica'][$i]['regione']=$_POST['regione'];
    }

    $num_elementi = count($_SESSION['rubrica']);
    echo "Nominativi rubrica: ". $num_elementi ."<br>";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post">
            <table boreder='1'>
                <tr><td>Nome:</td><td><input type="text" name="nome" id="nome"></td></tr>
            </table>

            <label for="regioni">Regione:</label>
            <select name="regione" id="regioni">
            <?php
                for ($i = 0; $i < count($_SESSION['regioni']); $i ++) {
                    echo '<option value="' . $_SESSION['regioni'][$i]["nome"]. '">' . $_SESSION['regioni'][$i]["nome"] . "</option>";
                }
            ?>
            </select>

            <br><br><input type="submit" name="submit" value="Nuovo">
            <input type="submit" name="reset" value="Reset">
        </form>

        <?php
            echo "<table border='1'>";
                for($i = 0; $i  <count($_SESSION['rubrica']); $i ++) {
                    echo "<tr>";
                    echo "<td bgcolor='". $_SESSION['colori'][$_SESSION['rubrica'][$i]['regione']] ."'>".$i."</td>";
                    echo "<td bgcolor='". $_SESSION['colori'][$_SESSION['rubrica'][$i]['regione']] ."'>".$_SESSION['rubrica'][$i]['nome']."</td>";
                    echo "<td bgcolor='". $_SESSION['colori'][$_SESSION['rubrica'][$i]['regione']] ."'>".$_SESSION['rubrica'][$i]['regione']."</td>";
                    echo "</tr>";
                }
            echo "</table>";
        ?>
    </body>
</html>
