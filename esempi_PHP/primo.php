<?php
   $a=7;
   $c="marco";
   $d=3;
   $b="<H".$d.">".$a."</H".$d.">";
?>

<HTML>
   <BODY>
      <H1>TITOLO</H1>

      <?php
         echo ($a*2)."<BR>";
         echo $c;
         echo $b;
      ?>

   </BODY>
</HTML>