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
        $this->Model->data['id_mapa'] = (int) $id;/*indica o id do mapa para pegar os territorios*/
        $res = $this->select('id, inome, id_regiao');/*selecionas os campos indicados no parametro na tabela territorios*/
        $arr = array();
        foreach ($res as $val) {/*organiza a estrutura dos dados recebidos na select*/
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
        /*Seleciona o campo Label*/
        $this->Model->data['id_mapa'] = (int) $id;
        $res = $this->select('label');
        $arr = array();
        $i = 0;
        foreach ($res as $val) {/*organiza os dados em uma lista sequencial*/
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
        $this->update($territorio);/*adiciona uma região ao território*/
    }

    /**
     * Gera as novas definições do mapa como vizinhos e territórios.
     * @param int $mapa id do mapa
     * @return Array Todas as definições do novo mapa
     */
    public function getNewDefines($mapa) {
        /*Definições de Região*/
        $this->uses('regiao', '../'); /*Utiliza o model Região*/
        $this->Regiao->data['id_mapa'] = $mapa;
        $regs = $this->Regiao->select(); /*Seleciona todas as regiões referente ao mapa*/
        
        $defs = array();/*array para guardar todas as definições do mapa*/

        /*Define as regiões*/
        foreach ($regs as $val) {/*percorre todas as regiões do mapa*/
            
            $defs['continentes'][$val['nome']]['exercitos'] = $val['exercitos']; /*Define a quantidade de exercitos que a região rende de bonus*/
            $this->Model->data['id_regiao'] = $val['id']; /*seta id da região*/
            $paises = $this->select();/*seleciona todas os territórios que pertencen a região corrente*/
            foreach ($paises as $p) {/*percorre todas os paises da região*/
                $defs['continentes'][$val['nome']]['paises'][] = $p['inome'];/*indica todos os paises que pertencem a uma regição*/
            }
            $tam = count($paises);/*pega a quantidade de paises de uma região*/
            $exercitos = (int) $val['exercitos'];/* pega a quantidade de exercios de bonus de uma região*/
            $defs['continentes'][$val['nome']]['valorEstrategico'] = number_format($exercitos / $tam, 1);/*defini o valor estratégico de uma região*/
            $defs['continentes'][$val['nome']]['qtdPaises'] = $tam; /*define quantidade de paises*/
            
        }
        /*Definições de vizinhos*/
        $this->uses('vizinho', '../');/*Usa o Model Vizinho*/
        $this->Model->data = NULL;/*Limpa os dados do model*/
        $this->Model->data['id_mapa'] = $mapa;
        $territorios = $this->select();/*Seleciona todos o territorios do mapa*/
        $lista = array();
        foreach ($territorios as $t){/*Cria uma lista id => nome de territorios*/
            $lista[$t['id']] = $t['inome'];
        }
        $cartas = Utils::randFiguras(count($territorios));/*cria lista de figuras*/
        $j = 0;
        /*Gera as definições dos territorios e seus vizinhos*/
        foreach ($territorios as $t){
            $defs['paises'][$t['inome']]['figura'] = $cartas[$j];/*Define uma carta ao territorio*/
            $this->Vizinho->data['territorio'] = $t['id'];
            $vizinhos = $this->Vizinho->select();/*Seleciona todos os vizinhos do corrente território*/
            $num_vizinhos = count($vizinhos);/*pega o numero de viznhos*/
            $val = 0;/*contador de viznhos de outras regiões*/ 
            foreach ($vizinhos as $vi) {/*Percorre lista de vizinhos*/
                $this->Model->data['id'] = $vi['vizinho']; 
                $t_vizinho = $this->Model->select('id_regiao'); /*Selciona o id da região do territorio vizinho corrente*/
                $reg_vizinho = $t_vizinho[0]['id_regiao'];
                $defs['paises'][$t['inome']]['vizinhos'][] = $lista[$vi['vizinho']];/*defini o vizinho de um territoio*/
                if($t['id_regiao'] != $reg_vizinho){/*verifica se o vizinho é da mesma região*/
                    $val++;
                }
            }
            
            $defs['paises'][$t['inome']]['valorEstrategico'] = $val + $num_vizinhos;/*define valor estratégico do pais*/
            $j++;
        }
        /*define objetivos*/
        $this->uses('objetivo', '../');/*Usa o model objetivo*/
        $this->Regiao->data['id_mapa'] = $mapa;
        $regis = $this->Regiao->select('nome');/*pega os nomes das retiões*/
        $this->Objetivo->data['id_mapa'] = $mapa;
        $objetivos = $this->Objetivo->select();/*pega todos os objetivos de um mapa*/
        $ob = array();
        $i = 0;
        foreach ($objetivos as $val){/*pergorre todos os objetivos*/
            $ob[$i]['name'] = $val['nome'];/* define o nome do objetivo*/
            $ob[$i]['tipo'] = $val['tipo'];/*define o tipo*/
            $ob[$i]['classificacoes']['conquistarcontinente'] = $val['conquistarcontinente'];
            $ob[$i]['classificacoes']['conquistafacil'] = $val['conquistafacil'];
            $ob[$i]['classificacoes']['tomarcontinente'] = $val['tomarcontinente'];
            $ob[$i]['parametro'][] = $val['reg1'];/*define a primeira regiao a ser conquistada*/
            $ob[$i]['parametro'][] = $val['reg2'];/*define a segunda regiao a ser conquistada*/
            if($val['outro'] == 1){
                foreach ($regis as $r){/*Define as outras regiões que devem ser */
                    if($r['nome'] != $val['reg1'] && $r['nome'] != $val['reg2'])
                    $ob[$i]['parametro'][3][] = $r['nome']; 
                }
            }
            $i++;
        }
        
        $class = array(); /*Valores para a IA*/
        $class['conquistarcontinente'] = 0.9;
        $class['conquistafacil'] = 0.5;
        $class['tomarcontinente'] = 0.9;
        /*Objetivos padrões */
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

        $defs['objetivos'] = $ob; /*adiciona os objetivos nas definições*/
        
        return $defs; /*retorna as definições*/

    }

}

?>
