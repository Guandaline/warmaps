<?php

include_once 'includes.php';

$controller = 'vizinho';
$func = isset($_GET['func']) ? $_GET['func'] : 0;
$territorio = isset($_GET['territorio']) ? $_GET['territorio'] : NULL;
$mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/

Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');


$obj = new vizinhoController();

switch ($func) {
    case 1:
        $res = $obj->getVizinho($territorio);
        break;
    case 2:
        $vizinho = isset($_GET['vizinho']) ? $_GET['vizinho'] : NULL;
        $val = isset($_GET['val']) ? $_GET['val'] : NULL;
        $res = $obj->setVizinho($territorio, $vizinho, $val);
        break;
    case 3:
        $vizinho = isset($_GET['vizinho']) ? $_GET['vizinho'] : NULL;
        $val = isset($_GET['val']) ? $_GET['val'] : NULL;
        $res = $obj->setVizinhoIni($territorio, $vizinho);
        break;
    case 4:
        $res = $obj->haveVizinho($territorio);
        break;
    default:
        $res = array('func invalida');
        break;
}


echo json_encode($res);
?>
