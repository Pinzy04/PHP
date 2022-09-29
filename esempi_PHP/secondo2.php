<HTML>
   <BODY>

      <?php
         if(isset($_POST['B1']))
         {
            $a = $_POST['T1'];
            $b= $a * 3;
            echo $a."<br>".$b;
         }
         else
         {
            echo "nessun dato";
         }
      ?>

   </BODY>
</HTML>