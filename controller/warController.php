<?php

class warController extends Controller{
    var $name = 'war';
    /**
     * Action index
     * Pega os dados da sessao e passa para a pagina
     */
    public function index(){
        $mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/
        $nome = isset($_GET['nome']) ? $_GET['nome'] : 0; 
        $this->set('nome', $nome);/*seta o nome do mapa*/
        $this->set('mapa',$mapa);/*seta o id do mapa*/
    }
    
}

?>
