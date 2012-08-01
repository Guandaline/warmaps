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
    
    public function lista(){
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
                    
                    if (!stristr($novo[1], "path") && stristr($novo[1], "t_")) {
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

        foreach ($territorios as $value) {

            $dados = array('id_mapa' => $id_mapa,
                'label' => 'l_' . $value['name'],
                'inome' => 't_' . $value['name'],
                'nome' => $value['name']);
            $this->Territorio->data = $dados;
            $this->set('sql', $this->Territorio->save());
        }

        $this->set('dir', "file/mapas/" . $file_name);
        $this->set('f_name', $file_name);
        $this->set('num_t', $num_territorios);
        $this->set('territorios', $territorios);
        
        $this->Territorio->data = null;
        //$this->Territorio->data['campos'] = 'inome';
        //$this->set('lista_territorios', $this->Territorio->select('inome'));
        
        return $territorios;
    }

}

?>
