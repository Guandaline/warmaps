<?php

ini_set('display_errors', 1);
//session_save_path(__DIR__ . '/sessions/');

//session_save_path('./');
//ini_set('session.gc_probaility', 1);

include_once 'element/includes.php';

if(file_exists("install.php")){
    $remove = isset($_GET['remove']) ? $_GET['remove'] : 0;
    if($remove == 0)
        header("Location:install.php");
    else
        rename ("install.php", "__install.php");
        //unlink ("install.php");
}

Session::start("warmaps");

$view = isset($_GET['view']) ? $_GET['view'] : 'home'; /*pega a visão*/
$action = isset($_GET['action']) ? $_GET['action'] : NULL; /*pega a pagina*/
$method = isset($_GET['method']) ? $_GET['method'] : NULL; /*pega o methodo a executar antes de abrir a pagina*/

$data = NULL;

if($method != NULL){
    if ($_POST)
        $data['post'] = $_POST;
    if ($_FILES) 
        $data['file'] = $_FILES;
}
//if(empty($_FILES)) $file = $_FILES;

Utils::incluirMC($view); /*Inclui o medelo e controller da visão*/

$obj = new View($view, $action, $method, $data);


?>
