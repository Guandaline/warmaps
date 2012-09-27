<?php

/**
 * Classe de Visão
 * */
class View {

    public $vars = array();
    public $controller;
    public $action;
    public $page = 'page/default.php';
    public $error = '';
    protected $name;
    protected $template = 'default';
    private $html = NULL;

    function __construct($name, $action = NULL, $method = NULL, $dados = NULL) {

        $this->name = $name;
        $this->incluirController();
        $action = is_string($action) ? $action : 'index';
        $this->action = $action;

        if (is_string($method)) {
            if (method_exists($this->controller, $method))
                $this->controller->$method($dados);
        }else {
            $this->error = 'A classe controller ' . $this->name . 'Controller não possui o metodo ' . $method . '();<br/>';
        }


        if (method_exists($this->controller, $action)) {
            $this->controller->$action();
            $this->vars = $this->controller->viewVars;
            $this->setPage();
        } else {
            $this->error .= 'A classe controller ' . $this->name . 'Controller não possui o metodo ' . $this->action . '()';
        }

        $this->incluirTemplate();
        $this->render();
    }

    /**
     * Inclue o Controller da View 
     * * */
    public function incluirController() {
        // include_once 'controller/'.$this->name.'Controller.php';
        $controller = $this->name . 'Controller';
        $this->controller = new $controller;
    }

    /**
     * Inclue o Template 
     * * */
    private function incluirTemplate() {
        ob_start();
        extract($this->vars);
        include 'template/' . $this->template . '.php';
        $this->html = ob_get_clean();
        ob_clean();
    }

    /**
     * Mostra a pagina
     * */
    private function render() {
        echo $this->html;
    }

    /**
     * Indica a pagina.
     * */
    public function setPage() {
        $this->page = 'view/' . $this->name . '/' . $this->action . '.php';
    }

}

?>
