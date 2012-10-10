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
        $this->setTitulo('Configurações do Mapa');
        $this->set('nome', Session::getVal('nome'));
    }

    /**
     * Action lista
     */
    public function lista() {
        $this->setTitulo('Lista de Mapas');
        $this->set('mapas', $this->select('id , nome'));
    }

    private function percorreMapa($file_name) {

        $arquivo = fopen("file/mapas/" . $file_name, "r"); /* abre o arquivo */
        $territorios = NULL; /* Guarda os territorios */

        if ($arquivo) {
            $i = 0;
            while (!feof($arquivo)) { /* Percorre o arquivo buscando todos os territorios */
                $linha = fgets($arquivo); /* le uma linha do arquivo */

                if (stristr($linha, "id=")) {
                    $novo = explode("\"", $linha); /* pega o id do elemento xml */
                    /*
                     * Aqui é onde eu verifico se o id tem o "t_" 
                     * É essa condição que tenho que mudar para pegar qualquer pais
                     * Já o tinha feito porém perdi quando meu note deu problema.
                     * Essa semana tento arrumar
                     */
                    if (!stristr($novo[1], "path") && stristr($novo[1], "t_")) {
                        $nome = explode("_", $novo[1]);
                        $territorios[$i] = $nome[1]; /* pega o nome do territorio */
                        $i = $i + 1;
                    }
                }
            }
        }

        fclose($arquivo);

        return $territorios;
    }

    private function updateMapa($id_mapa, $mapa) {

        $this->uses('territorio');
        $this->Territorio->data['id_mapa'] = $id_mapa;
        $t_ant = $this->Territorio->select('id, nome');
        $ant = array();
        foreach ($t_ant as $val){
            $ant[] = $val['nome'];
        }

         $territorios = $this->percorreMapa($mapa);
            
         return $this->diffTerritorios($territorios, $ant, $id_mapa);
    }

    private function diffTerritorios($arr1, $arr2, $id_mapa) {

        $novos = array_diff($arr1, $arr2);
        $this->saveTerritorio($novos, $id_mapa);
        $remove = array_diff($arr2, $arr1);
        return $this->removeTerritorio($remove, $id_mapa);
    }

    private function removeTerritorio($territorio, $id_mapa) {
        $this->uses('vizinho');
        $teste = array();
        $this->Territorio->data = null;
        foreach ($territorio as $val) {
            
            $this->Territorio->data['id_mapa'] = $id_mapa;
            $this->Territorio->data['nome'] = $val;
            $tr = $this->Territorio->select('id');
            $teste[] =  'sql = ' . $tr[0]['id']. ' '.$this->Territorio->sql. ' '. $id_mapa . ' '. $val;
             $this->Territorio->delete();

            $this->removeVizinhos($tr);

            $this->Vizinho->data['vizinho'] = $tr[0]['id'];
            $teste [] = $this->Vizinho->select();
           
        }
        
        return 'Go sleep';
    }

    private function saveTerritorio($territorios, $id_mapa) {

        foreach ($territorios as $value) {

            $dados = array('id_mapa' => $id_mapa,
                'label' => 'l_' . $value,
                'inome' => 't_' . $value,
                'nome' => $value);
            $this->Territorio->data = $dados;
            $this->Territorio->save();
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
        Session::start("warmaps");
        $id = $this->existe($file_name);

        if (stristr($file_type, "svg"))/* valida o tipo de arquivo */
            move_uploaded_file($file_tmp_name, 'file/mapas/' . $file_name); /* move arquivo para o local lifel/mapas */
        else {
            $mensagem = "Formato de arquivo inválido";
            $this->set('mensagem', $mensagem);
            return 0;
        }

        if ($id != 0) {
            Session::setVal('mapa', $id);
            Session::setVal('nome', $file_name);
            return $this->updateMapa($id, $file_name);
            
            header("Location:index.php?view=mapa&action=config");
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

        /* Adciona o mapa na sessão */
        Session::setVal('mapa', $id_mapa);
        Session::setVal('nome', $file_name);

        /* Salva todos o territorios encontrados no banco */
        $this->saveTerritorio($territorios, $id_mapa);

        /* redireciona pra pagina de configuração sem o metodo de salvar */
        header("Location:index.php?view=mapa&action=config");
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
            return $res[0]['id'];
        }

        return 0;
    }

    private function removeVizinhos($territorios) {
        $this->uses('vizinho', '../');
        foreach ($territorios as $v) {
            echo $v;
            $this->Vizinho->data['territorio'] = $v['id'];
            $this->Vizinho->delete();
        }
    }

    /**
     * <b>Methodo</b><br/>
     * Remove o mapa do banco de dados
     */
    public function excluir($mapa) {

        $this->uses('territorio', '../');
        $this->Territorio->data['id_mapa'] = $mapa;
        $territorios = $this->Territorio->select('id');
        $this->removeVizinhos($territorios);
        $this->uses('vizinho', '../');
        $this->Territorio->delete();
        $this->uses('regiao', '../');
        $this->Regiao->data['id_mapa'] = $mapa;
        $this->Regiao->delete();
        $this->Model->data = null;
        $this->Model->data['id'] = $mapa;
        $this->delete();
    }

}

?>
