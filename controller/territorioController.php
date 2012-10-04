<?php

class territorioController extends Controller {

    var $name = 'territorio';
    /**
     * Action index
     */
    public function index() {
        
    }

    /**
     * Pega a lista de territórios de um mapa;
     * @param int $id Id do mapa.
     * @return array Lista de territorios.
     */
    public function getListaTerritorios($id) {
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('id, inome, id_regiao');
        $arr = array();
        foreach ($res as $val) {
            $arr[$val['id']]['name'] = $val['inome'];
            $arr[$val['id']]['reg'] = $val['id_regiao'];
        }
        return $arr;
    }
    
    /**
     * Pega a lista de labels do mapa
     * @param int $id Id do mapa.
     * @return array Lista de labels.
     */
    public function getListaLabels($id) {
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('label');
        $arr = array();
        $i = 0;
        foreach ($res as $val) {
            $arr[$i] = $val['label'];
            $i++;
        }
        return $arr;
    }
    
    /**
     * Insere a região a qual o território pertence.
     * @param int $territorio Id do território
     * @param int $regiao Id da região
     */
    public function setRegiao($territorio, $regiao) {
        $this->Model->data['id_regiao'] = $regiao;
        $this->update($territorio);
    }

    /**
     * Gera as novas definições do mapa como vizinhos e territórios.
     * @param int $mapa id do mapa
     * @return Array Todas as definições do novo mapa
     */
    public function getNewDefines($mapa) {
        $this->uses('regiao', '../');
        $this->Regiao->data['id_mapa'] = $mapa;
        $regs = $this->Regiao->select();
        $defs = array();

        /*Define as regiões*/
        foreach ($regs as $val) {

            $defs['continentes'][$val['nome']]['valorEstrategico'] = $val['valor_estrategico'];
            $defs['continentes'][$val['nome']]['exercitos'] = $val['valor_estrategico'];
            $this->Model->data['id_regiao'] = $val['id'];
            $paises = $this->select();

            foreach ($paises as $p) {
            
                $defs['continentes'][$val['nome']]['paises'][] = $p['inome'];
                
            }
            
            $defs['continentes'][$val['nome']]['qtdPaises'] = count($paises);
        }
        
        $this->uses('vizinho', '../');
        $this->Model->data = NULL;
        $this->Model->data['id_mapa'] = $mapa;
        $territorios = $this->select();
        $lista = array();
        foreach ($territorios as $t){
            $lista[$t['id']] = $t['inome'];
        }
        
        /*Gera as definições dos territorios e seus vizinhos*/
        foreach ($territorios as $t){
            /*fazer calculo do valor estrategico aqui*/
            $defs['paises'][$t['inome']]['valorEstrategico'] = 2;
            $defs['paises'][$t['inome']]['figura'] = 1;
            $this->Vizinho->data['territorio'] = $t['id'];
            $vizinhos = $this->Vizinho->select();
            foreach ($vizinhos as $vi) {
                $defs['paises'][$t['inome']]['vizinhos'][] = $lista[$vi['vizinho']];
            }
        }
        
        return $defs ;
        
        
    }

}

?>
