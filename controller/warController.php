<?php

class warController extends Controller{
    var $name = 'war';
    /**
     * Action index
     * Pega os dados da sessao e passa para a pagina
     */
    public function index(){
        Session::start();
        $this->set('nome', Session::getVal('nome'));
        $this->set('id_mapa', Session::getVal('mapa'));
    }
    
}

?>
