<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }

    public function getListaTerritorios($id){
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('id, inome');
        $arr = array();
        foreach ($res as $val){
            $arr[$val['id']] = $val['inome'];
        }
        return $arr;    
    }
    
    public function getListaLabels($id){
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('label');
        $arr = array();
        $i = 0;
        foreach ($res as $val){
            $arr[$i] = $val['label'];
            $i++;
        }
        return $arr;    
    }
    
    
    
}

?>
