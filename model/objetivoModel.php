<?php
/**
 * Classe de modelo do controller objetivo
 * utiliza a tabela objetivos
 */
class objetivoModel extends Model{
    
    var $name = 'objetivo';
    var $useTable = 'objetivos';
    
     public function gerarObjetivos($id_mapa){
        $this->uses('regiao');
        $this->Regiao->data['id_mapa'] = $id_mapa;
        $regis = $this->Regiao->select('nome');
        $this->Model->data['id_mapa'] = $id_mapa;
        $objetivos = $this->select();
        $ob = array();
        $i = 0;
        foreach ($objetivos as $val){
            $ob[$i]['name'] = $val['nome'];
            $ob[$i]['tipo'] = $val['tipo'];
            $ob[$i]['classificacoes']['conquistarcontinente'] = $val['conquistarcontinente'];
            $ob[$i]['classificacoes']['conquistafacil'] = $val['conquistafacil'];
            $ob[$i]['classificacoes']['tomarcontinente'] = $val['tomarcontinente'];
            $ob[$i]['parametro'][1] = $val['reg1'];
            $ob[$i]['parametro'][2] = $val['reg2'];
            if($val['outros'] == 1){
                foreach ($regis as $r){
                    if($r['nome'] != $val['reg1'] && $r['nome'] != $val['reg2'])
                    $ob[$i]['parametro'][3][] = $r['nome']; 
                }
            }
        }
        return $ob;
    }
}

?>
