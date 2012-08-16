<?php
class regiaoController extends Controller{
    var $name = 'regiao';
    
    public function getListaRegiao($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, nome');
        $arr = array();
        foreach ($res as $val) {
            $arr [$val['id']]  = $val['nome'];
        }
        return $arr;
    }
    
    public function getRegiao($id){
        $this->Model->data['id'] = (int)$id;
        $res = $this->select();
        return $res;
    }
    
    public function setRegiao($mapa, $nome, $exercitos, $valor, $cor, $id = NULL){
        $this->Model->data['id_mapa'] = $mapa;
        $this->Model->data['nome'] = $nome;
        $this->Model->data['exercitos'] = $exercitos;
        $this->Model->data['valor_estrategico'] = $valor;
        $this->Model->data['cor'] = $cor;
        if($id == NULL)
            $this->save();
        else
            $this->update ($id);
        return $this->Model->sql;
    }
    
    
    
}

?>