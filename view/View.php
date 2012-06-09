<?php

/**
 * Classe de Visão
 **/

class View{
    
    public $vars;
    public $controller;
    public $action;
    public $page;
    protected $name;
    protected $template = 'default';
    private $html;
    
    function __construct($name, $action = NULL) {
        $this->name = $name;
        $this->incluirController();
        $method = $action != NULL ? $action : 'index';
        $this->action = $method;
        $this->controller->$method();
        $this->vars = $this->controller->viewVars;
        $this->setPage();
        $this->incluirTemplate();
        $this->render();
    }
    
    /**
     *Inclue o Controller da View 
     ***/
    public function incluirController(){
       // include_once 'controller/'.$this->name.'Controller.php';
        $controller = $this->name.'Controller';
        $this->controller = new $controller;
    }
    
    /**
     *Inclue o Template 
     ***/
    private function incluirTemplate(){
        ob_start();
        extract($this->vars);
        include 'template/'.$this->template.'.php';
        $this->html = ob_get_clean();
        ob_clean();
    }
    
    /**
     * Mostra a pagina
     **/
    private function render(){
        echo $this->html;
    }
    
    /**
     * Indica a pagina.
     **/
    public function setPage(){
        $this->page = 'page/'.$this->name.'/'.$this->action.'.php';
    }

    
    
}

?>
