<?php

include_once 'includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'mapa';
$func = isset($_GET['func']) ? $_GET['func'] : 0;


Session::start("warmaps");
$mapa = Session::getVal('mapa');


Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new $classe();

switch ($func) {
    case 1:
        $mapa = isset($_GET['mapa']) ? $_GET['mapa'] : NULL;
        $res = $obj->excluir($mapa);
        //$res = array("Excluido");
        break;
    default:
        $res = array('func invalida');
        break;
}

echo json_encode($res);
?>
