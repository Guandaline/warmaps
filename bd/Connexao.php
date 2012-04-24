<?php
/*
 * Classe de Conexão - Reponsavel por todos os acessos ao banco.
 */

/*
 * pegando as configurações do banco
 */
include 'DataBaseConfig.php';

class Connexao {

    private $banco;
    private $user;
    private $pass;
    private $conexao;
    private $resultado;
    private $obj = NULL;
    private $array = NULL;
    private $errors;
    private $msg;

    function __construct() {
        $database = new DataBaseConfig(); 
        $this->banco = $database->banco;
        $this->pass = $database->pass;
        $this->host = $database->host;
        $this->user = $database->user;
        try {
            if ($this->pass == '')
                $this->conexao = new PDO('mysql:host=' . $this->host . ';port=3306;dbname=' . $this->banco, $this->user); // conecta o servidor
            else
                $this->conexao = new PDO('mysql:host=' . $this->host . ';port=3306;dbname=' . $this->banco, $this->user, $this->pass); // conecta o servidor
            $this->msg[] =  'Conexão estabelecida!';
        } catch (PDOException $e) {
            $this->errors[] = 'error: falha ao criar conexão<br/>'.$e->getMessage();
        }
    }

    public function query($sql) {
        try{
            $this->resultado = $this->conexao->prepare($sql);
        }catch(PDOException $e){
            $this->errors[] =  'error: function query<br/>'.$e->getMessage();
        }
    }
    
    public function execute($dados = NULL){
        try{
            $this->resultado->execute($dados);
        }  catch (PDOException $e){
            $this->errors[] =  'error: function execute<br/>'.$e->getMessage();
        }
    }
    
    public function fetchObj(){
        try{
            $this->obj = $this->resultado->fetch(PDO::FETCH_OBJ);
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetchObj<br/>'.$e->getMessage();
            $this->obj = NULL;
        }
        return $this->obj;
    }
   
    public function fetch(){
        try{
            $this->array = $this->resultado->fetch();
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetch<br/>'.$e->getMessage();
            $this->array = NULL;
        }
        return $this->array;
    }

    public function fetchAll(){
        try{
            $this->array = $this->resultado->fetchAll();
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetchAll<br/>'.$e->getMessage();
            $this->array = NULL;
        }
        return $this->array;
    }
    
    public function queryAll($sql, $dados){
        try{
            $this->query($sql);
            $this->execute($dados);
            return $this->fetchAll();
        }catch(PDOException $e){
            $this->errors[] =  'error: function queryAll<br/>'.$e->getMessage();
            return NULL;
        }
    }

    public function close(){
        $this->conexao = NULL;
    }

}

?>