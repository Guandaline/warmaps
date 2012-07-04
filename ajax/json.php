<?php

include_once 'element/includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : NULL;
$method = isset($_GET['method']) ? $_GET['method'] : NULL;

if ($controller != NULL && $method != NULL) {
    
    Utils::incluirMC($controller);
    $obj = new $controller();
    $res = $obj->$method();
    
    echo json_encode($res);
}else{
    
    echo json_encode(NULL);
    
}
?>
