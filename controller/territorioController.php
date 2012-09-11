<?php

class territorioController extends Controller {

    var $name = 'territorio';

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
        $contis = array();

        foreach ($regs as $val) {

            $contis['continentes'][$val['nome']]['valorEstrategico'] = $val['valor_estrategico'];
            $contis['continentes'][$val['nome']]['exercitos'] = $val['valor_estrategico'];
            $this->Model->data['id_mapa'] = $mapa;
            $paises = $this->select('nome');

            foreach ($paises as $p) {
            
                $contis['continentes'][$val['nome']]['paises'][] = $p['mome'];
                
            }
            
            $contis['continentes'][$val['nome']]['qtdPaises'] = count($paises);
        }

        $this->Model->data['id_mapa'] = $mapa;
        $territorios = $this->select();
        
        
        
    }

    public function getRegiao() {
        
    }

}

?>
