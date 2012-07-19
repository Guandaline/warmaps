<?php


class Utils{
    
    public static function incluir($classe, $tipo, $nivel = ''){
        $url = $nivel . $tipo.'/'.$classe.ucfirst($tipo).'.php';
        include_once $url;
    }
    
    public static function incluirMC($classe){
        $model = 'model/'.$classe.'Model.php';
        $controller = 'controller/'.$classe.'Controller.php';
        include_once $model;
        include_once $controller;
    }
    
}
?>
