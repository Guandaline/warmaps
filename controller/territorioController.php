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

            // = $val['valor_estrategico'];
            $defs['continentes'][$val['nome']]['exercitos'] = $val['exercitos'];
            $this->Model->data['id_regiao'] = $val['id'];
            $paises = $this->select();

            foreach ($paises as $p) {
            
                $defs['continentes'][$val['nome']]['paises'][] = $p['inome'];
                
            }
              $tam = count($paises);
            $exercitos = (int) $val['exercitos'];
            $defs['continentes'][$val['nome']]['valorEstrategico'] = number_format($tam / $exercitos, 1);
            
          
            $defs['continentes'][$val['nome']]['qtdPaises'] = $tam;
            
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
            // = 2;
            $defs['paises'][$t['inome']]['figura'] = 1;
            $this->Vizinho->data['territorio'] = $t['id'];
            $vizinhos = $this->Vizinho->select();
            $num_vizinhos = count($vizinhos);
            $val = 0;
            
            foreach ($vizinhos as $vi) {
                $this->Model->data['id'] = $vi['vizinho'];
                $t_vizinho = $this->Model->select('id_regiao');
                $reg_vizinho = $t_vizinho[0]['id_regiao'];
                $defs['paises'][$t['inome']]['vizinhos'][] = $lista[$vi['vizinho']];
                if($t['id_regiao'] != $reg_vizinho){
                    $val++;
                }
            }
            
            $defs['paises'][$t['inome']]['valorEstrategico'] = $val + $num_vizinhos;
        }
        
        $this->uses('objetivo', '../');
        $this->Regiao->data['id_mapa'] = $mapa;
        $regis = $this->Regiao->select('nome');
        $this->Objetivo->data['id_mapa'] = $mapa;
        $objetivos = $this->Objetivo->select();
        $ob = array();
        $i = 0;
        foreach ($objetivos as $val){
            $ob[$i]['name'] = $val['nome'];
            $ob[$i]['tipo'] = $val['tipo'];
            $ob[$i]['classificacoes']['conquistarcontinente'] = $val['conquistarcontinente'];
            $ob[$i]['classificacoes']['conquistafacil'] = $val['conquistafacil'];
            $ob[$i]['classificacoes']['tomarcontinente'] = $val['tomarcontinente'];
            $ob[$i]['parametro'][] = $val['reg1'];
            $ob[$i]['parametro'][] = $val['reg2'];
            if($val['outro'] == 1){
                foreach ($regis as $r){
                    if($r['nome'] != $val['reg1'] && $r['nome'] != $val['reg2'])
                    $ob[$i]['parametro'][3][] = $r['nome']; 
                }
            }
            $i++;
        }
        $clas = array();
        $class['conquistarcontinente'] = 0.9;
            $class['conquistafacil'] = 0.5;
            $class['tomarcontinente'] = 0.9;
        
        /*
         * {{'name' : "conquistar 18 territorios com 2 exercitos",

		  'tipo' : "conquistaTerritorios",

		  'parametro' : 18,

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},

         */
         $ob[$i]['name'] = 'destruir o jodador azul';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'azul';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'destruir o jogador preto';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'preto';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'destruir o jogador branco';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'branco';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'destruir o jogador amarelo';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'amarelo';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'destruir o jogador vermelho';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'vermelho';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'destruir o jogador verde';
         $ob[$i]['tipo'] = 'eliminaJogador';
         $ob[$i]['parametro'] = 'verde';
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'conquistar 18 territorios com 2 exercitos';
         $ob[$i]['tipo'] = 'conquistaTerritorios';
         $ob[$i]['parametro'][] = 18;
         $ob[$i]['parametro'][] = 2;
         $ob[$i]['classificacoes'] = $class;
         $i++;
         $ob[$i]['name'] = 'conquistar 24 territórios';
         $ob[$i]['tipo'] = 'conquistaTerritorios';
         $ob[$i]['parametro'] = 24;
         $ob[$i]['classificacoes'] = $class;
         $i++;

         
        $defs['objetivos'] = $ob;
        
        return $defs ;

    }

}

?>
