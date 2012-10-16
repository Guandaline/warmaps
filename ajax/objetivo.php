<?php

include_once 'includes.php';

$controller = 'objetivo';
$func = isset($_GET['func']) ? $_GET['func'] : 0; /*pega a função que deve ser executada*/
$mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/
/*pega o id do mapa na sessão*/


/*Inclui o controlle e o modelo*/
Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');

$obj = new objetivoController();/*cria o objeto */

switch ($func) {/*Identifica o methodo*/
    case 1:
        $res = $obj->setObjetivo($_POST);
        break;
    case 2:
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $res = $obj->excluir($id);
        break;
    default:
        $res = array('func invalida');
        break;
}

echo json_encode($res);
?>
