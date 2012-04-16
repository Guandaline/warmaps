<?php

class connexao {

    private $banco;
    private $user;
    private $pass;
    private $conexao;
    private $resultado;
    private $obj = NULL;
    private $array = NULL;

    function __construct($host, $banco, $user, $pass = NULL) {
        $this->banco = $banco;
        $this->pass = $pass;
        $this->host = $host;
        $this->user = $user;
        try {
            if ($pass != NULL)
                $this->conexao = new PDO('mysql:host=' . $this->host . ';port=3306;dbname=' . $this->banco, $this->user); // conecta o servidor
            else
                $this->conexao = new PDO('mysql:host=' . $this->host . ';port=3306;dbname=' . $this->banco, $this->user, $this->pass); // conecta o servidor
            echo 'Conexão estabelecida!';
        } catch (PDOException $e) {
            echo 'error: falha ao criar conexão\n'.$e->getMessage();
        }
    }

    public function query($sql) {
        try{
            $this->resultado = $this->conexao->prepare($sql);
        }catch(PDOException $e){
            echo 'error: function query\n'.$e->getMessage();
        }
    }
    
    public function execute($dados = NULL){
        try{
            $this->resultado->execute($dados);
        }  catch (PDOException $e){
            echo 'error: function execute\n'.$e->getMessage();
        }
    }
    
    public function fetch(){
        try{
            $this->obj = $this->resultado->fetch(PDO::FETCH_OBJ);
        }  catch (PDOException $e){
            echo 'error: function fetch\n'.$e->getMessage();
            $this->obj = NULL;
        }
        return $this->obj;
    }

    public function fetchAll(){
        try{
            $this->array = $this->resultado->fetchAll();
        }  catch (PDOException $e){
            echo 'error: function fetchAll\n'.$e->getMessage();
            $this->array = NULL;
        }
        return $this->array;
    }
    
    public function queryAll($sql, $dados){
        try{
            query($sql);
            execute($dados);
            return fetchAll();
        }catch(PDOException $e){
            echo 'error: function queryAll'.$e->getMessage();
            return NULL;
        }
    }

    public function close(){
        $this->conexao = NULL;
    }

}

?>
