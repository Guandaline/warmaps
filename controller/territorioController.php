<?php

class territorioController extends Controller{
    var $name = 'territorio';
    
    public function index(){
        
    }

    public function getListaTerritorios($id){
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('id, inome, id_regiao');
        $arr = array();
        foreach ($res as $val){
            $arr[$val['id']]['name'] = $val['inome'];
            $arr[$val['id']]['reg'] = $val['id_regiao'];
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
    
    public function setRegiao($territorio, $regiao){
        
        $this->Model->data['id_regiao'] = $regiao;
        $this->update($territorio);
        return array('sql' => $this->Model->sql);
    }
    
    public function getRegiao(){
        
    }
    
    
}

?>
