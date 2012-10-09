<?php

/**
 * <b>Classe de Visão</b><br/>
 * Responsavel por chamar o template e as paginas<br/>
 * assim como as <b>Actions</b> de cada pagina.<br/>
 * e se necessário os <b>Methodos</b>
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
        $res = null;
        if (is_string($method)) { /* Verifica que deve executar um methodo antes de iniciar a pagina */
            if (method_exists($this->controller, $method)) {/*Verifica se o method chamado existe*/
               $res = $this->controller->$method($dados);
            } else {
                /* Mensagens de erro */
                $this->error = 'A classe controller ' . $this->name . 'Controller não possui o metodo ' . $method . '();<br/>';
            }
        }

        if (method_exists($this->controller, $action)) { /*verifica que existe aquela action*/
            $this->controller->$action(); /*Chama a action da visão*/
            $this->vars = $this->controller->viewVars;/*pega as variáveis da pagina*/
            $this->setPage(); /*seta a pagina*/
        } else {
            $this->error .= 'A classe controller ' . $this->name . 'Controller não possui o metodo ' . $this->action . '()';
        }

        $this->incluirTemplate();
        $this->render();
        
        //Utils::pa($res);
    }

    /**
     * Inclue o Controller da View 
     * */
    public function incluirController() {
        $controller = $this->name . 'Controller';
        $this->controller = new $controller;
    }

    /**
     * Inclue o Template 
     * */
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
