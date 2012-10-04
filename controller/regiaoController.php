<?php
class regiaoController extends Controller{
    var $name = 'regiao';
    /**
     * Paga a lisata de regiões de um mapa
     * @param int $mapa id do mapa
     * @return Array As regiões do mapa
     */
    public function getListaRegiao($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, nome');
        $arr = array();
        foreach ($res as $val) {
            $arr [$val['id']]  = $val['nome'];
        }
        return $arr;
    }
    
    /**
     * Pega od dados de uma região
     * @param int $id Id da região
     * @return Array Dados da Região
     */
    public function getRegiao($id){
        $this->Model->data['id'] = (int)$id;
        $res = $this->select();
        return $res;
    }
    
    public function setRegiao($mapa, $nome, $exercitos, $cor, $id = NULL){
        $this->Model->data['id_mapa'] = $mapa;
        $this->Model->data['nome'] = $nome;
        $this->Model->data['exercitos'] = $exercitos;
        $this->Model->data['cor'] = $cor;
        if($id == NULL)
            $this->save();
        else
            $this->update ($id);
        return $this->Model->sql;
    }
    
    public function getCores($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, cor');
        $arr = array();
        foreach ($res as $val) {
            $arr [$val['id']]  = $val['cor'];
        }
        return $arr;
    }
    
    public function excluir($id){
        $this->uses('territorio', '../');
        $this->Territorio->data['id_regiao'] = $id;
        $territorio = $this->Territorio->select('id');
        foreach ($territorio as $t){
            $this->Territorio->data['id_regiao'] = null;
            $this->Territorio->update($t['id']);            
        }
        $this->Model->data = null;
        $this->Model->data['id'] = $id;
        $this->delete();
        return $territorio;
    }
    
}

?>