<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }

    public function getListaTerritorios($id){
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('inome');
        $arr = array();
        $i = 0;
        foreach ($res as $val){
            $arr[$i] = $val['inome'];
            $i++;
        }
        return $arr;    
    }
    
    
    
}

?>
