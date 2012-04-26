 
<?php
    ini_set('display_errors', 1);

    include 'model/teste.php';
    $teste = new teste();
    $teste->data = array('campos' => 'teste, id','teste' => 500);
    ?>
 
<pre>
   <?php
        
       echo $teste->select();
       print_r($teste->array); 
    ?>
</pre>