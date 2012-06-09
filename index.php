<?php
    ini_set('display_errors', 1);
    include_once 'element/includes.php';
    
    $view = isset($_GET['view']) ? $_GET['view'] : 'home';  
    $action = isset($_GET['action']) ? $_GET['action'] : NULL;  
    
    $obj = new View($view, $action);
   // $obj->$action();

?>
