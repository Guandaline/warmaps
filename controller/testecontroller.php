<?php

include 'Controller.php';

class testeController extends Controller {

    var $name = 'teste';
    
    function __construct() {
        parent::__construct();
        $this->index();
    }

    function index() {
        $this->set($this->Model->selectAll());
        $this->set('titulo', 'testando');
        //$this->incluirModel();
        //extract($this->viewVars);
        //print_r($this->viewVars);
    }

}

?>
