<?php

class warController extends Controller{
    var $name = 'war';
    /**
     * Action index
     * Pega os dados da sessao e passa para a pagina
     */
    public function index(){
      
        $this->set('nome', Session::getVal('nome'));/*seta o nome do mapa*/
        $this->set('id_mapa', Session::getVal('mapa'));/*seta o id do mapa*/
    }
    
}

?>
