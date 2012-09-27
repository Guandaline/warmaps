<?php

class mapaController extends Controller {

    var $name = 'mapa';

    public function index() {
        
    }

    public function novo() {
        $this->uses('tipo');
        $tipos = $this->Tipo->selectAll();
        $this->set('tipos', $tipos);
        $this->setTitulo('Novo Mapa');
    }

    public function config() {
        
    }

    public function lista() {
        $this->set('mapas', $this->select('id , nome'));
    }

    public function salvar($data) {

        $this->uses('territorio');
        $tipo = $data['post']['tipo'];
        $file_name = $data['file']['mapafile']['name'];
        $file_type = $data['file']['mapafile']['type'];
        $file_tmp_name = $data['file']['mapafile']['tmp_name'];
        $mensagem = '';
        $this->set('mensagem', $mensagem);

        if (stristr($file_type, "svg"))
            @move_uploaded_file($file_tmp_name, 'file/mapas/' . $file_name);
        else {
            $mensagem = "Formato de arquivo inválido";
            $this->set('mensagem', $mensagem);
            return;
        }

        $arquivo = fopen("file/mapas/" . $file_name, "r");
        $territorios = NULL;

        if ($arquivo) {
            $mapa = null;
            $i = 0;
            while (!feof($arquivo)) {
                $linha = fgets($arquivo);
                $mapa .= $linha;
                if (stristr($linha, "id=")) {
                    $novo = explode("\"", $linha);

                    if (!stristr($novo[1], "path") && stristr($novo[1], "t_") ) {
                        $nome = explode("_", $novo[1]);
                        $territorios[$i]['id'] = $novo[1];
                        $territorios[$i]['name'] = $nome[1];
                        $territorios[$i]['path'] = $linha;
                        $i = $i + 1;
                    }
                }
            }
        }

        $num_territorios = count($territorios);
        $dados = array('numero_territorios' => $num_territorios,
            'nome' => $file_name,
            'tipo' => $tipo,
            'mapa' => $mapa);
        $this->setData($dados);
        $this->save();
        $id_mapa = $this->getId();

        Session::setVal('mapa', $id_mapa);
        Session::setVal('nome', $file_name);

        foreach ($territorios as $value) {

            $dados = array('id_mapa' => $id_mapa,
                'label' => 'l_' . $value['name'],
                'inome' =>  $value['id'],
                'nome' => $value['name']);
            $this->Territorio->data = $dados;
            $this->set('sql', $this->Territorio->save());
        }

        $this->set('dir', "file/mapas/" . $file_name);
        $this->set('f_name', $file_name);
        $this->set('num_t', $num_territorios);
        $this->set('territorios', $territorios);

        header("Location:index.php?view=mapa&action=config");
        return $territorios;
    }
    
    
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



    public function vizinhos() {
        $id_mapa = Session::getVal('mapa');
        $file_name = Session::getVal('nome');
        $arquivo = fopen("file/mapas/" . $file_name, "r");

        if (stristr($linha, "id=t_")) {
            if (stristr($linha, "id=t_")) {
                
            }
        }
        
        
        $d = array();
        
        if ($arquivo) {
            $i = 0;
            while (!feof($arquivo)) {
                $linha = fgets($arquivo);
                if (strstr($linha, '<') && !strstr($linha, '>')) {
                    while (!strstr($linha, '>')) {
                        $linha = fgets($arquivo);
                        if (stristr($linha, "id=t_")) {
                            
                        }
                    }
                }
            }
        }
    }

}

?>
