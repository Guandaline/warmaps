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
    }

    /**
     * Action lista
     */
    public function lista() {
        $this->setTitulo('Lista de Mapas');
        $this->set('mapas', $this->select('id , nome'));
    }

    /**
     * <b>Methodo</b><br/>
     * Insere o mapa no banco de dados
     */
    public function salvar($data) {

        $this->uses('territorio');
        $tipo = $data['post']['tipo'];
        $file_name = $data['file']['mapafile']['name'];
        $file_type = $data['file']['mapafile']['type'];
        $file_tmp_name = $data['file']['mapafile']['tmp_name'];
        $mensagem = '';
        $this->set('mensagem', $mensagem);

        if (stristr($file_type, "svg"))/*valida o tipo de arquivo*/
            @move_uploaded_file($file_tmp_name, 'file/mapas/' . $file_name);/*move arquivo para o local lifel/mapas*/
        else {
            $mensagem = "Formato de arquivo inválido";
            $this->set('mensagem', $mensagem);
            return;
        }

        $arquivo = fopen("file/mapas/" . $file_name, "r");/*abre o arquivo*/
        $territorios = NULL; /*Guarda os territorios*/

        if ($arquivo) { 
            $i = 0;
            while (!feof($arquivo)) { /*Percorre o arquivo buscando todos os territorios*/
                $linha = fgets($arquivo);/*le uma linha do arquivo*/

                if (stristr($linha, "id=")) {
                    $novo = explode("\"", $linha);/*pega o id do elemento xml*/
                    /*
                     * Aqui é onde eu verifico se o id tem o "t_" 
                     * É essa condição que tenho que mudar para pegar qualquer pais
                     * Já o tinha feito porém perdi quando meu note deu problema.
                     * Essa semana tento arrumar
                     */
                    if (!stristr($novo[1], "path") && stristr($novo[1], "t_") ) {
                        $nome = explode("_", $novo[1]);
                        $territorios[$i]['id'] = $novo[1];/*id do territorio*/
                        $territorios[$i]['name'] = $nome[1];/*pega o nome do territorio*/
                        $territorios[$i]['path'] = $linha;
                        $i = $i + 1;
                    }
                }
            }
        }

        $num_territorios = count($territorios);/*pega o numero de territorios que existe no mapa*/
        
        /*dados do mapa a ser salvo no banco*/
        $dados = array('numero_territorios' => $num_territorios,
            'nome' => $file_name,
            'tipo' => $tipo,
            'mapa' => 'Mapa');
        /*Seta os dados a serem salvos*/
        $this->setData($dados);
        /*salva*/
        $this->save();
        /*pega id do mapa inserido*/
        $id_mapa = $this->getId();

        /*Adciona o mapa na sessão*/
        Session::setVal('mapa', $id_mapa);
        Session::setVal('nome', $file_name);

        /*Salva todos o territorios encontrados no banco*/
        foreach ($territorios as $value) {

            $dados = array('id_mapa' => $id_mapa,
                'label' => 'l_' . $value['name'],
                'inome' =>  $value['id'],
                'nome' => $value['name']);
            $this->Territorio->data = $dados;
            $this->set('sql', $this->Territorio->save());
            
        }

        /*redireciona pra pagina de configuração sem o metodo de salvar*/
        header("Location:index.php?view=mapa&action=config");
        
    }
    
    /**
     * <b>Methodo</b><br/>
     * Insere o mapa no banco de dados
     */
    public function excluir($mapa){
        
        $this->uses('territorio', '../');
        $this->Territorio->data['id_mapa'] = $mapa;
        $t = $this->Territorio->select('id');
        $this->uses('vizinho', '../');
        foreach ($t as $v){
            $this->Vizinho->data['territorio'] = $v;
            $this->Vizinho->delete();
        }
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
