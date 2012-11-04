<?php

/**
 * Controller do Mapa
 * Metodos e Atributos referentes ao mapa estão aqui.
 */
class mapaController extends Controller {

    var $name = 'mapa';

    /**
     * Action novo
     */
    public function novo() {
        $this->setTitulo('Novo Mapa');
    }

    /**
     * Action config
     */
    public function config() {
        $mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/
        $nome = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/
        $this->setTitulo('Configurações do Mapa');
        $this->set('nome', $nome);
    }

    /**
     * Action lista
     */
    public function lista() {
        $this->setTitulo('Lista de Mapas');
        $this->set('mapas', $this->select('id , nome'));
    }
    
    
    /*
     * faz leitura do arquivo .svg
     */
    private function percorreMapa($file_name) {

        $arquivo = fopen("file/mapas/" . $file_name, "r"); /* abre o arquivo */
        $territorios = NULL; /* Guarda os territorios */

        if ($arquivo) {
            $i = 0;
            while (!feof($arquivo)) { /* Percorre o arquivo buscando todos os territorios */
                $linha = fgets($arquivo); /* le uma linha do arquivo */

                if (stristr($linha, " id=")) {
                    $novo = explode("\"", $linha); /* pega o id do elemento xml */
                    if (!stristr($novo[1], "path") && !stristr($novo[1], "path") && !stristr($novo[1], "circle")
                            && !stristr($novo[1], "rect") && !stristr($novo[1], "l_") && !stristr($novo[1], "image")
                            && !stristr($novo[1], "tspan") && !stristr($novo[1], "text") && !stristr($novo[1], "flow")
                            && !stristr($novo[1], "false") && !stristr($novo[1], "Arrow") && !stristr($novo[1], "namedview")
                            && !stristr($novo[1], "perspective") && !stristr($novo[1], "defs") && !stristr($novo[1], "metadata")
                            && !stristr($novo[1], "svg") && !stristr($novo[1], "line") && !stristr($novo[1], "layer")) {
                        //$nome = explode("_", $novo[1]);
                        $territorios[$i] = $novo[1]; /* pega o nome do territorio */
                        $i = $i + 1;
                    }
                }
            }
        }

        fclose($arquivo);/*Fecha o arquivo*/

        return $territorios; /*retorna lista de territorios*/
    }
    
    
    /*Verifica as diferenças entre o mapa atual e novo mapa*/
    private function updateMapa($id_mapa, $mapa) {

        $this->uses('territorio');/*usa o modelo territorio*/
        $this->Territorio->data['id_mapa'] = $id_mapa;
        $t_ant = $this->Territorio->select('id, nome');/*seleciona os territorios atuais*/
        $ant = array();
        foreach ($t_ant as $val){/*cria lista com os nomes dos */
            $ant[] = $val['nome'];
        }

         $territorios = $this->percorreMapa($mapa); /*pega lista de territórios novos*/
            
        $this->diffTerritorios($territorios, $ant, $id_mapa); /*verifica diferença entre os territórios*/
    }

    /*encontra os territorios novos e os removidos*/
    private function diffTerritorios($arr1, $arr2, $id_mapa) {
        /* Pega lista de territorios novos*/
        $novos = array_diff($arr1, $arr2);
        /*salva os novos territorios*/
        if(count($novos) > 0)
            $this->saveTerritorio($novos, $id_mapa);
        /*Lista de territorios removidos*/
        $remove = array_diff($arr2, $arr1);
        if(count($remove) > 0)
            $this->removeTerritorio($remove, $id_mapa);
        
    }
    
    /*Remove um territorio de um mapa*/
    private function removeTerritorio($territorio, $id_mapa) {
        $this->uses('vizinho');/*Usa model Viizinho*/
        $teste = array();
        $this->Territorio->data = null;
        foreach ($territorio as $val) {/*percorre todos os territorios*/
            $this->Territorio->data['id_mapa'] = $id_mapa;
            $this->Territorio->data['nome'] = $val;
            $tr = $this->Territorio->select('id');/*pega o id dos territorios*/
            $this->removeVizinhos($tr);
            $this->Vizinho->data['vizinho'] = $tr[0]['id'];
            $this->Vizinho->delete();/*remove esse territorio como vizinho de outros*/
            $this->Territorio->delete();/*remove os vizinhos de um territorio*/
           
        }

    }

    /*salva os territorios*/
    private function saveTerritorio($territorios, $id_mapa) {

        foreach ($territorios as $value) {/*percorre os territorios*/
            /*gera os dados dos territorios*/
            $dados = array('id_mapa' => $id_mapa,
                'label' => 'l_' . $value,
                'inome' => $value,
                'nome' => $value);
            $this->Territorio->data = $dados;
            $this->Territorio->save();/*Salva o territorio*/
        }
    }

    /**
     * <b>Methodo</b><br/>
     * Insere o mapa no banco de dados
     */
    public function salvar($data) {

        $this->uses('territorio');
        $file_name = $data['file']['mapafile']['name'];
        $file_type = $data['file']['mapafile']['type'];
        $file_tmp_name = $data['file']['mapafile']['tmp_name'];
        $mensagem = '';
        $this->set('mensagem', $mensagem);
       
        $id = $this->existe($file_name);/*verifica se o novo mapa existe*/
        

        if (stristr($file_type, "svg"))/* valida o tipo de arquivo */
            move_uploaded_file($file_tmp_name, 'file/mapas/' . $file_name); /* move arquivo para o local lifel/mapas */
        else {
            $mensagem = "Formato de arquivo inválido";
            $this->set('mensagem', $mensagem);
            return 0;
        }

        if ($id != 0) {/*atualiza configuraçoes de um mapa*/
            
            $this->updateMapa($id, $file_name);
            
            header("Location:index.php?view=mapa&action=config&viz=1&id_mapa=".$id."&nome=".$file_name);
            return 1;
        }


        $territorios = $this->percorreMapa($file_name);

        $num_territorios = count($territorios); /* pega o numero de territorios que existe no mapa */

        /* dados do mapa a ser salvo no banco */
        $dados = array('numero_territorios' => $num_territorios,
            'nome' => $file_name,
            'mapa' => 'Mapa');
        /* Seta os dados a serem salvos */
        $this->setData($dados);
        /* salva */
        $this->save();
        /* pega id do mapa inserido */
        $id_mapa = $this->getId();

        /* Salva todos o territorios encontrados no banco */
        $this->saveTerritorio($territorios, $id_mapa);

        /* redireciona pra pagina de configuração sem o metodo de salvar */
        header("Location:index.php?view=mapa&action=config&viz=1&id_mapa=".$id_mapa."&nome=".$file_name);
        return 1;
    }

    /**
     * Verifica se o mapa adcionado já existe.
     * @param String $mapa Nome do Mapa
     * @return int id do mapa se o mapa já existir e 0 se não existir
     */
    private function existe($mapa) {
        $this->setData(array('nome' => $mapa));
        $res = $this->select('id');
        if (count($res) > 0) {
            return $res[0]['id'];/*retorna id do mapa*/
        }

        return 0; /*o mapa não existe*/
    }

    /*remove todos os vizinhos de um territorios*/
    private function removeVizinhos($territorios) {
        $this->uses('vizinho', '../');
        foreach ($territorios as $v) {/*percore a lista de territorios*/
            $this->Vizinho->data['territorio'] = $v['id'];
            $this->Vizinho->delete();/*remove todos os vizinho de cada territorio*/
        }
    }

    /**
     * <b>Methodo</b><br/>
     * Remove o mapa do banco de dados
     */
    public function excluir($mapa) {

        $this->uses('territorio', '../');
        $this->Territorio->data['id_mapa'] = $mapa;
        $territorios = $this->Territorio->select('id');/*seleciona os territorios do mapa*/
        $this->removeVizinhos($territorios);/*remove os vizinhso do teritorio*/
        $this->uses('vizinho', '../');
        $this->Territorio->delete();/*remove todos os territorios*/
        $this->uses('regiao', '../');
        $this->Regiao->data['id_mapa'] = $mapa;
        $this->Regiao->delete();/*deleta todas as reriões*/
        $this->uses('objetivo', '../');
        $this->Objetivo->data['id_mapa'] = $mapa;
        $this->Objetivo->delete();
        $this->Model->data = null;
        $this->Model->data['id'] = $mapa;
        $this->delete();/*deleta o mapa*/
    }

}

?>
