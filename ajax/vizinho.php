<?php

include_once 'includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'vizinho';
$func = isset($_GET['func']) ? $_GET['func'] : 0;
$territorio = isset($_GET['territorio']) ? $_GET['territorio'] : NULL;


Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new $classe();

switch ($func) {
    case 1:
        $res = $obj->getVizinho($territorio);
        break;
    case 2:
        $vizinho = isset($_GET['vizinho']) ? $_GET['vizinho'] : NULL;
        $val = isset($_GET['val']) ? $_GET['val'] : NULL;
        $res = $obj->setVizinho($territorio, $vizinho, $val);
        break;
    default:
        $res = array('func invalida');
        break;
}


echo json_encode($res);

?>
