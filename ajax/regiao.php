<?php

include_once 'includes.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'regiao';
$func = isset($_GET['func']) ? $_GET['func'] : 0;
$mapa = isset($_GET['mapa']) ? $_GET['mapa'] : NULL;

Session::start("warmaps");
$mapa = Session::getVal('mapa');

Utils::incluir($controller, 'controller', '../');
Utils::incluir($controller, 'model', '../');
$classe = $controller . 'Controller';
$obj = new $classe();

switch ($func) {
    case 1:
        $res = $obj->getListaregiao($mapa);
        break;
    case 2:
        /*pegar dados do post*/
        $nome = $_POST['nome'];
        $cor = $_POST['cor'];
        $valor = $_POST['estrategico'];
        $exercitos = $_POST['exercitos'];
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        
        $res = $obj->setRegiao($mapa, $nome, $exercitos, $valor, $cor, $id);
        
        break;
    case 3:
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $res = $obj->getRegiao($id);
        
        break;
    case 4:
        $res = $obj->getCores($mapa);
        break;
    case 5:
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $res = $obj->excluir($id);
        break;
    default:
        $res = array('func invalida');
        break;
}

//echo $res;
echo json_encode($res);

?>
