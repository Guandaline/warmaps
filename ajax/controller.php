<?php
include_once 'includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : NULL;
$method = isset($_GET['method']) ? $_GET['method'] : NULL;
$parametros = isset($_GET['parametros']) ? $_GET['parametros'] : NULL;
$territorio = isset($_GET['territorio']) ? $_GET['territorio'] : NULL;
$vizinho = isset($_GET['vizinho']) ? $_GET['vizinho'] : NULL;
$val = isset($_GET['val']) ? $_GET['val'] : NULL;

if ($controller != NULL && $method != NULL) {
    
    Utils::incluir($controller, 'controller', '../');
    Utils::incluir($controller, 'model', '../');
    $classe = $controller . 'Controller';
    $obj = new $classe();
    if($parametros != NULL)
        $res = $obj->$method($parametros);
    if($territorio !=  NULL && $vizinho != NULL )
        $res = $obj->$method($territorio, $vizinho, $val);
    
    echo json_encode($res);
    
}else{
    
    echo json_encode(NULL);
    
}

?>