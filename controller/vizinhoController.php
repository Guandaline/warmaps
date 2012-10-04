<?php

class vizinhoController extends Controller {

    var $name = 'vizinho';
    /**
     * <b>Methodo</b><br/>
     * Pega os vizinhos de todos os territorios
     * @param int $territorio Id do territoro
     */
    public function getVizinho($territorio) {
        $this->Model->data['territorio'] = $territorio;
        $res = $this->select('vizinho');
        $arr = array();
        foreach ($res as $val) {
            $arr []  = $val['vizinho'];
        }
        return $arr;
    }

    /**
     * Insere ou remove o vizinho<br/>
     * @param String $territorio Id do territorio.
     * @param String $vizinho Id do vizinho.
     * @param String $valor true ou false para <br/>
     * insereir ou remover respectivamente
     * @return String  Mensagem de sucesso ou falha
     */
    public function setVizinho($territorio, $vizinho, $valor) {
        $this->setData(array('territorio' => $territorio, 'vizinho' => $vizinho));
        $id = $this->select('id');
        //return $id;

        if ($valor == 'true') {
            /*inseri vizinhos*/
            if (empty($id)) {
                $this->save();
                $id = $this->select('id');
                $id = $id[0][0];
                return 'salvo ' . $id;
            }
        } else {
            /*Remove vizinhos*/
            if (!empty($id)) {
                $id = $id[0]['id'];
                $this->Model->data = null;
                $this->Model->data['id'] = $id;
                $this->delete();
                return 'removido ' . $id . ' ' . $this->Model->sql;
            }
        }

        /*Territorio não encontrado*/
        return $id;
    }

}

?>
