 
<?php
    ini_set('display_errors', 1);

    include 'controller/testecontroller.php';
    $teste = new testeController();
    
    ?>
 
<pre>
   <?php   
      $teste->index();
      echo getcwd();
    ?>
</pre>