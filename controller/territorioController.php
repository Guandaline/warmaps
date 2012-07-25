<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }

    public function getListaTerritorios($id){
        $this->Model->data['id_mapa'] = (int) $id;
        return $this->select('inome');
    }
    
    
    
}

?>
