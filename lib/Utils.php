<?php

/**
 * Classe com algumas funções uteis;
 */

class Utils {

    /**
     * Inclui uma classe na pagina.
     * @param string $classe nome da classe a ser incluida 
     * @param string $tipo tipo de classe (Model ou Controller)
     * @param string $nivel diretorios que devem ser retornados em "../"
     */
    public static function incluir($classe, $tipo, $nivel = '') {
        /*cria o link para inclusao de arquivos*/
        $url = $nivel . $tipo . '/' . $classe . ucfirst($tipo) . '.php';
        include_once $url;
    }

    /**
     * Inclui Model e Controller de uma classe
     * @param String $classe Nome da classe a ser inserida
     */
    public static function incluirMC($classe) {
        $model = 'model/' . $classe . 'Model.php'; /*cria o caminho para incluir o modelo*/
        $controller = 'controller/' . $classe . 'Controller.php'; /* cira o caminho para incluir o controle*/
        include_once $model;
        include_once $controller;
    }

    /*
     * Função utilizada para visualizar um array
     * vou tirar assim que terminar 
     */
    public static function pa($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
    
    
    /**
     * Cria lista de figuras para os paises
     * @param int $tam Numero de figuras que dever ser geradas
     */
    public static function randFiguras($tam){
        $cartas = array();
        for($i = 0; $i < $tam; $i++){
            $cartas[] = rand(0, 2);/*pega um numero aleatório ente 0 e 2*/
        }
        return $cartas;
    }
}

?>
