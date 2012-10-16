<?php

include_once 'includes.php';

$controller = 'mapa';
$func = isset($_GET['func']) ? $_GET['func'] : 0; /*pega a função que deve ser executada*/
$mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/


/*Inclui o controlle e o modelo*/
Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');

$obj = new mapaController();/*cria o objeto */

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
