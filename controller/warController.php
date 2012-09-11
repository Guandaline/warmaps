<?php

class warController extends Controller{
    var $name = 'war';
    
    public function index(){
        Session::start();
        $this->set('nome', Session::getVal('nome'));
        $this->set('id_mapa', Session::getVal('mapa'));
    }
    
    public function index2(){
        
    }
}

?>
