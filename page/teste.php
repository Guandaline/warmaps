<h1>
        teste
</h1>    
<?php
    ini_set('display_errors', 1);

    include 'bd/Connexao.php';

    $con = new Connexao();

    $data = array('id' => 3, 'teste' => 30, 'evandro' => 'viado', 'vinicius' => 'gay');
    $num = count($data);
    $i = 0;
     $valores = $num == 1 ? 'VALUE (': 'VALUES (';
    $sql = 'INSERTE INTO teste ( ';
    foreach ($data as $key => $value) {
        $sql .= $key;
        if ($i < $num - 1)
            $sql .= ', ';
        if(is_string($value)) $valores .= '"';
        $valores .= $value;
        if(is_string($value)) $valores .= '"'; 
        if ($i < $num - 1)
            $valores .= ', ';
        echo var_dump($value);
        
        $i++;
    }
    $valores .= ' );';
    $sql .= ' ) ' . $valores;
    echo '<br/><br/>' . $sql . '<br/>';
    
   ?>
<h1>
    SELECT * FROM teste 
</h1>    
   <?php
    
    
    ?>
    