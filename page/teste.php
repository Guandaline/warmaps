 
<?php
    ini_set('display_errors', 1);

    include 'model/teste.php';
    $teste = new teste();
    $teste->data = array('teste' => 55);
    $teste->where = array('id' => 5, 'teste' => 78);
    $teste->del = array('id'=> 9, 'teste' => 50);
    ?>
 
<pre>
   <?php
        
        echo $teste->delete();
        
    ?>
</pre>