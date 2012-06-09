<?php

include_once 'Controller.php';

class testeController extends Controller {

    var $name = 'teste';
    
 
    public function index() {
           
        $this->set('arr', $this->Model->selectAll());
        $this->setTitulo('Novo Titulo');
        //$this->set('conteudo', 'page/teste/index.php');
 
    }
    
    
    public function mapa(){
        $this->setTitulo("Mapamapapmapampa");
        $this->set('nome', 'Mapa');
    }
    

}

?>
