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

    /**
     * Prepara a query SQL
     * @param String $sql Query Sql a ser preparada
     */
    public function query($sql) {
        try{
            $this->resultado = $this->conexao->prepare($sql);
        }catch(PDOException $e){
            $this->errors[] =  'error: function query<br/>'.$e->getMessage();
        }
    }
    
    /**
     * Executa a query com os dados
     * @param Array $dados Dados necessarios para execução da query.<br/>
     * Pode ser Nulo ou vazio.
     */
    public function execute($dados = NULL){
        try{
            $this->resultado->execute($dados);
        }  catch (PDOException $e){
            $this->errors[] =  'error: function execute<br/>'.$e->getMessage();
        }
    }
    
    /**
     * Pega uma linha do resultado da consulta sql e retorna como objeto.
     * @return Object obj O objeto de uma linha da consulta.
     */
    public function fetchObj(){
        try{
            $this->obj = $this->resultado->fetch(PDO::FETCH_OBJ);
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetchObj<br/>'.$e->getMessage();
            $this->obj = NULL;
        }
        return $this->obj;
    }
   
    /**
     * Retorna uma linha do resultado da consulta.
     * @return Array uma linha do resultado da consulta
     */
    public function fetch(){
        try{
            $this->array = $this->resultado->fetch();
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetch<br/>'.$e->getMessage();
            $this->array = NULL;
        }
        return $this->array;
    }

    /**
     * Retorna todo o resultado da consulta em um Array
     * @return Array Todas a linhas resultantes da consulta.
     */
    public function fetchAll(){
        try{
            $this->array = $this->resultado->fetchAll();
        }  catch (PDOException $e){
            $this->errors[] =  'error: function fetchAll<br/>'.$e->getMessage();
            $this->array = NULL;
        }
        return $this->array;
    }
    
    /**
     * Prepara a query sql, executa e retorna os dados
     * @param String $sql Consulta SQL.
     * @param Array $dados dados necessários para execução da query.
     * @return Array Todas a linhas resultantes da consulta.
     */
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

    /**
     * Fecha a conexão.
     */
    public function close(){
        $this->conexao = NULL;
    }

}

?>