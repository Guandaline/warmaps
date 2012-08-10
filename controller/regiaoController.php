<?php
class regiaoController extends Controller{
    var $name = 'regiao';
    
    public static function getListaRegiao($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, nome');
        $arr = array();
        foreach ($res as $val) {
            $arr [$val['id']]  = $val['nome'];
        }
        return $arr;
    }
    
    
}

?>