<?php

class territorioController extends Controller {

    var $name = 'territorio';
    /**
     * Action index
     */
    public function index() {
        
    }

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

    public function setRegiao($territorio, $regiao) {
        $this->Model->data['id_regiao'] = $regiao;
        $this->update($territorio);
    }

    public function vizinhos($dados) {

        $aux = array();
        foreach ($dados as $value) {
            $t_id = $value['id'];
            $d = explode(' ', $value['d']);

            $tam = count($d);
            $i = 0;
            while ($i < $tam) {
                if (strtoupper($d[$i]) == 'M') {
                    $i++;
                    $aux[$t_id]['pos'] = $d[$i];
                }
                if (strtoupper($d[$i]) == 'C') {
                    $j = 0;
                    $i++;
                    do {

                        $val = explode(',', $d[$i]);
                        $aux[$t_id]['pt'][$j]['x'] = $val[0];
                        $aux[$t_id]['pt'][$j]['y'] = $val[1];
                        $j++;
                        $i++;
                    } while (strtoupper($d[$i]) != 'Z');
                }
                $i++;
            }
        }

        return $aux;
    }

    public function getNewDefines($mapa) {
        $this->uses('regiao', '../');
        $this->Regiao->data['id_mapa'] = $mapa;
        $regs = $this->Regiao->select();
        $defs = array();

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
        
        foreach ($territorios as $t){
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
