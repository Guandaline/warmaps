<?php

include_once 'includes.php';

$controller = 'mapa';
$func = isset($_GET['func']) ? $_GET['func'] : 0; /*pega a função que deve ser executada*/

/*pega o id do mapa na sessão*/
Session::start("warmaps");
$mapa = Session::getVal('mapa');

/*Inclui o controlle e o modelo*/
Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new $classe();/*cria o objeto */

switch ($func) {/*Identifica o methodo*/
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
