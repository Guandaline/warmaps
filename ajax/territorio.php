<?php

include_once 'includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'territorio';
$func = isset($_GET['func']) ? $_GET['func'] : 0;
$territorio = isset($_GET['territorio']) ? $_GET['territorio'] : NULL;


Session::start("warmaps");
$mapa = Session::getVal('mapa');


Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new $classe();

switch ($func) {
    case 1:
        $regiao = isset($_GET['regiao']) ? $_GET['regiao'] : NULL;
        $res = $obj->setRegiao($territorio, $regiao);
        break;
    case 2:
        $res = $obj->getListaTerritorios($mapa);
        break;
    case 3:
        $res = $obj->getListaLabels($mapa);
        break;
    case 4:
        $res = $obj->vizinhos($_POST);
        
        break;
    default:
        $res = array('func invalida');
        break;
}


echo json_encode($res);
?>
