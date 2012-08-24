<?php

ini_set('display_errors', 1);
include_once 'element/includes.php';

Session::start("warmaps");

$view = isset($_GET['view']) ? $_GET['view'] : 'home';
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

Utils::incluirMC($view);

$obj = new View($view, $action, $method, $data);

/*
  if($post){
  if(is_string($method))
  $obj->controller->$method($_POST);
  } */
?>
