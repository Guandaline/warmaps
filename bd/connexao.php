<?php

class connexao {
    private $banco;
    private $senha;
    private $conexao;
    
    function __construct($banco, $senha=NULL) {
        $this->banco = $banco;
        $this->senha = $senha;
        $this->conexao = new PDO('mysql:host=localhost;port=3306;dbname='.$banco,'root'); // conecta o servidor
    }
    
    public function query($sql){
        
    }

}

?>
