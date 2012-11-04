<?php
class objetivoController extends Controller{
    var $name = 'objetivo';
    /**
     * Adiciona objetivo
     * @param Array $data Todos os dados do obejtivo
     */
    public function setObjetivo($data){
        $this->setData($data);
        if($data['id'] != 0)/*se tiver id fa um update*/
            $this->update($data['id']);
        else /*salva*/
            $this->save();
    }
    
    /**
     * Pega lista de de objetivos de um mapa
     * @param int $id_mapa Id do mapa 
     * @return array Lista de objetivos do mapa
     */
    public function getLista($id_mapa){
        $this->Model->data['id_mapa'] = $id_mapa;
        $lista = $this->select('id, nome');
        $objs = array();
        foreach ($lista as $val){ /*monta a lista id => mapa*/
            $objs[$val['id']] = $val['nome'];
        }
        return $objs;
    }
    
    /**
     * Pega dados de um objetivo por id
     * @param int $id Id do objetivo
     * @return Array  Dados do objetivo
     */
    public function getObjtivo($id){
        $this->Model->data['id'] = $id;
        $dados = $this->select('nome, reg1, reg2, outro');
        return $dados[0];
    }
    
    /**
     * Exclui um objetivo
     * @param  int $id Id do objetivo
     */    
    public function excluir($id){
        $this->Model->data['id'] = $id;
        $this->delete($id);/*Deleta o objetivo*/
    }
   
}
?>
