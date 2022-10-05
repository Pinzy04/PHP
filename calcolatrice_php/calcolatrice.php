<?php
    $t1=0;
    $t2=0;
    $t3=0;

    if(isset($_POST['B1']))
    {
        $t1 = $_POST['T1'];
        $t2 = $_POST['T2'];
        $t3 = $t1+$t2;
    }

    if(isset($_POST['B2']))
    {
        $t1 = $_POST['T1'];
        $t2 = $_POST['T2'];
        $t3 = $t1-$t2;
    }

    if(isset($_POST['B3']))
    {
        $t1 = $_POST['T1'];
        $t2 = $_POST['T2'];
        $t3 = $t1*$t2;
    }

    if(isset($_POST['B4']))
    {
        $t1 = $_POST['T1'];
        $t2 = $_POST['T2'];
        if($t2!=0)
        {	   
            $t3 = $t1/$t2;
        }
        else
        {
            $t3 = "impossibile"; 
        }	   
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
        <H1>Calcolatrice php</H1>
        <FORM name='F1' method='post' action='calcolatrice_php.php'>
            <INPUT type='text' name='T1' size='5' value='<?php echo $t1; ?>' />
            <INPUT type='text' name='T2' size='5' value='<?php echo $t2; ?>'/>
            <BR><BR>
            <INPUT type='submit' name='B1' value='+' />
            <INPUT type='submit' name='B2' value='-' />
            <INPUT type='submit' name='B3' value='*' />
            <INPUT type='submit' name='B4' value='/' />
            <BR><BR>
            <INPUT type='text' name='T3' size='5' value='<?php echo $t3; ?>' />
        </FORM>
    </BODY>
</HTML>
