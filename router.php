<?php

ini_set('display_errors', 1);
include_once 'element/includes.php';

$controller = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
$method = isset($_GET['method']) ? $_GET['method'] : NULL;

$data = NULL;

if($method != NULL){
    if ($_POST)
        $data['post'] = $_POST;
    if ($_FILES) 
        $data['file'] = $_FILES;
}
//if(empty($_FILES)) $file = $_FILES;

Utils::incluirMC($controller);

$obj = $controller.'Controller';

$ctr = new $obj($action, $method, $data);




?>
