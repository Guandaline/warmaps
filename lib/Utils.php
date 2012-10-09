<?php

class Utils {

    /**
     * Inclui uma classe na pagina.
     * @param string $classe nome da classe a ser incluida 
     * @param string $tipo tipo de classe (Model ou Controller)
     * @param string $nivel diretorios que devem ser retornados em "../"
     */
    public static function incluir($classe, $tipo, $nivel = '') {
        $url = $nivel . $tipo . '/' . $classe . ucfirst($tipo) . '.php';
        include_once $url;
    }

    public static function incluirMC($classe) {
        $model = 'model/' . $classe . 'Model.php';
        $controller = 'controller/' . $classe . 'Controller.php';
        include_once $model;
        include_once $controller;
    }

    public static function pa($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

?>
