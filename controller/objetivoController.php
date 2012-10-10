<?php
class objetivoController extends Controller{
    var $name = 'objetivo';
    
    public function setObjetivo($data){
        $this->setData($data);
        if($data['id'] != 0)
            $this->update($data['id']);
        else
            $this->save();
    }
    
    public function getLista($id_mapa){
        $this->Model->data['id_mapa'] = $id_mapa;
        $lista = $this->select('id, nome');
        $objs = array();
        foreach ($lista as $val){
            $objs[$val['id']] = $val['nome'];
        }
        return $objs;
    }
    
    public function getObjtivo($id){
        $this->Model->data['id'] = $id;
        $dados = $this->select('nome, reg1, reg2, outro');
        return $dados[0];
    }
    
    public function excluir($id){
        $this->Model->data['id'] = $id;
        $this->delete($id);
    }
    
    /*
     {'name' : "conquistar asia e americaSul",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["asia"], ["americaSul"] ],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},
     */
    
   
}
?>
