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
    private $html;

    function __construct($name) {


        $this->name = $name;
        //$this->incluirTemplate();
        ob_start();

        //$this->render();
    }

    /**
     * Inclue o Controller da View 
     * * */
    /*  public function incluirController() {
      // include_once 'controller/'.$this->name.'Controller.php';
      $controller = $this->name . 'Controller';
      $this->controller = new $controller;
      } */

    /**
     * Inclue o Template 
     * * */
    public function incluirTemplate() {
        extract($this->vars);
        include 'template/' . $this->template . '.php';
        $this->html = ob_get_clean();
    }

    /**
     * Mostra a pagina
     * */
    public function render() {
        echo $this->html;
        ob_clean();
    }

    /**
     * Indica a pagina.
     * */
    public function setPage() {
        $this->page = 'view/' . $this->name . '/' . $this->action . '.php';
    }

}

?>
