<?php
class regiaoController extends Controller{
    var $name = 'regiao';
    /**
     * Pega a lista de regiões de um mapa
     * @param int $mapa id do mapa
     * @return Array As regiões do mapa
     */
    public function getListaRegiao($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, nome');/*seleciona todas as regiões de um mapa*/
        $arr = array();
        foreach ($res as $val) {/*cria um lista de id => nome de todas as regiões*/
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
        $res = $this->select();/*seleciona reguiao*/
        return $res;
    }
    
    /**
     * Cria uma nova Região
     * @param int $mapa Id do mapa
     * @param String $nome Nome da região
     * @param int $exercitos Quantidade de exercitos de bonus
     * @param String $cor a cor da nova região.
     * @param int $id Id da região caso seja diferente de nulo<br/>
     * realiza um update na tabela
     * @return string O sql montado;
     */
    public function setRegiao($mapa, $nome, $exercitos, $cor, $id = NULL){
        /*Dados a serem salvos*/
        $dados = array('id_mapa' => $mapa,
                        'nome' => $nome,
                        'exercitos' => $exercitos,
                        'cor' => $cor
            );
        $this->setData($dados);/*seta os dados*/
       
        if($id == NULL)/*Se não tiver id Salva*/
            $this->save();
        else/*atualiza*/
            $this->update ($id); /*Atualiza*/
        return $this->Model->sql;
    }
    
    /**
     * Pega as cores dos Territórios 
     * @param int $id Id do mapa
     * @return Array Lista de cores no mapa
     */    
    public function getCores($mapa){
        $this->Model->data['id_mapa'] = $mapa;
        $res = $this->select('id, cor'); /*Pega as cores de cara região*/
        $arr = array();
        foreach ($res as $val) {/*cira lista id => cor*/
            $arr [$val['id']]  = $val['cor'];
        }
        return $arr;
    }
    
    
    /**
     * Excluir uma região.
     * @param int $id Id da região
     * @return Array Lista de territórios que foram afetados
     */
    public function excluir($id){
        $this->uses('territorio', '../');/*Usa o Model território*/
        $this->Territorio->data['id_regiao'] = $id;
        $territorio = $this->Territorio->select('id'); /*Seleciona o id de todos os territórios*/
        foreach ($territorio as $t){/*percorre todos os territorios*/
            $this->Territorio->data['id_regiao'] = null;
            $this->Territorio->update($t['id']); /*Remove id da região no territorio*/
        }
        $this->Model->data = null;
        $this->Model->data['id'] = $id;
        $this->delete();/*deleta a regiao*/
        return $territorio;
    }
    
}

?>