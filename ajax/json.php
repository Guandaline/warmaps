<?php
ini_set('display_errors', 1);
//include_once '../element/includes.php';
include_once '../bd/Connexao.php';
/*Classe de funções uteis*/
include_once '../lib/Utils.php';

/*classes principais*/
include_once '../model/Model.php';
include_once '../controller/Controller.php';
include_once '../view/View.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : NULL;
$method = isset($_GET['method']) ? $_GET['method'] : NULL;

if ($controller != NULL && $method != NULL) {
    
    Utils::incluir($controller, 'controller', '../');
    Utils::incluir($controller, 'model', '../');
    $classe = $controller . 'Controller';
    $obj = new $classe();
    $res = $obj->$method();
    
    //echo json_encode($res);
}else{
    
    //echo json_encode(NULL);
    
}

echo $controller . ' ' . $method;
?>
