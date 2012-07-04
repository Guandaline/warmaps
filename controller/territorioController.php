<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }
    
    public function getListaterritorios(){
        $this->Model->data['campos'] = 'inome';
        $this->select();
    }
    
    
    
}

?>
