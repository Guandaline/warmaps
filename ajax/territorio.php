<?php

include_once 'includes.php';

$controller = 'territorio';
$func = isset($_GET['func']) ? $_GET['func'] : 0;
$territorio = isset($_GET['territorio']) ? $_GET['territorio'] : NULL;
$mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/


Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new territorioController();

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
        $res = $obj->getNewDefines($mapa);
        break;
    default:
        $res = array('func invalida');
        break;
}

echo json_encode($res);
?>
