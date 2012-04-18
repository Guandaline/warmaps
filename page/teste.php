 
<?php
    ini_set('display_errors', 1);

    include 'model/teste.php';

    $data = array('teste' => 50);
    
    ?>
 
<pre>
   <?php
        $teste = new teste();
        echo $teste->useTable.'<br/><br/>';
        $teste->data = $data;
        
        echo 'id: '. $teste->id;
       
    ?>
</pre>