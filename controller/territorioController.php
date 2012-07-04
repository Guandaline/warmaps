<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }
    
    public function getListaterritorios(){
        $this->Model->data['id'] = 10;
        $this->select('inome');
    }
    
    
    
}

?>
