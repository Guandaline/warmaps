<?php

class mapaController extends Controller {

    var $name = 'mapa';

    public function index() {
        
    }

    public function novo() {
        $this->setTitulo('Novo Mapa');
    }

    public function salvar($data) {

        $this->uses('territorio');
        
        $file_name = $data['file']['mapafile']['name'];
        $file_type = $data['file']['mapafile']['type'];
        $file_size = $data['file']['mapafile']['size'];
        $file_tmp_name = $data['file']['mapafile']['tmp_name'];
        $error = $data['file']['mapafile']['error'];
        $formato = explode(".", $file_name);
        $mensagem = '';
        if (stristr($formato[1], "svg"))
            @move_uploaded_file($file_tmp_name, 'file/mapas/' . $file_name);
        else {
            $mensagem = "Formato de arquivo inválido";
            $this->set('mensagem', $mensagem);
            return;
        }
        $arquivo = fopen("file/mapas/" . $file_name, "r");
        if ($arquivo) {
            $i = 0;
            while (!feof($arquivo)) {
                $linha = fgets($arquivo);
                if (stristr($linha, "<path")) {
                    while (!stristr($linha, "/>") && !feof($arquivo)) {
                        if (stristr($linha, "id=")) {
                            $novo = explode("\"", $linha);
                            if (!stristr($novo[1], "path") && stristr($novo[1], "t_")) {
                                $nome = explode("_", $novo[1]);
                                $territorios[$i] = $nome[1];
                                $i = $i + 1;
                            }
                        }
                        $linha = fgets($arquivo);
                    }
                }
            }
        }
    }
}
?>
