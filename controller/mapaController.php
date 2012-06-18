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

    public function salvar($data) {

        $this->uses('territorio');
         
        $tipo = $data['post']['tipo'];
        
        $file_name = $data['file']['mapafile']['name'];
        $file_type = $data['file']['mapafile']['type'];
        $file_tmp_name = $data['file']['mapafile']['tmp_name'];
                
        $mensagem = '';
        $this->set('mensagem', $mensagem);
       
        if (stristr($file_type , "svg"))
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
                if (stristr($linha, "<path")) {
                    while (!stristr($linha, "/>") && !feof($arquivo)) {
                        if (stristr($linha, "id=")) {
                            $novo = explode("\"", $linha);
                            if (!stristr($novo[1], "path") && stristr($novo[1], "t_")) {
                                $nome = explode("_", $novo[1]);
                                $territorios[$i]['name'] = $nome[1];
                                $territorios[$i]['path'] = $linha;
                                $i = $i + 1;
                            }
                        }
                        $linha = fgets($arquivo);
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
        
        $this->set('regioes', $territorios);

    }
}
?>
