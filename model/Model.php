<?php
/**
 * Classe Resposável por todo acesso ao banco de dados.
 * */
class Model {

    public $data = array();
    private $conn;
    public $id = 0;
//   public $resultado;
    public $array = array();
    protected $name;
    protected $useTable;
//   protected $schema;
    public $sql;
    private $aux;

    function __construct($id = 0) {
        if ($this->useTable != FALSE) {
            $this->conn = new Connexao();
            if ($id == 0)
                $this->setID();
            else
                $this->id = $id;
        }
    }

    /**
     * Seleciona o ultimo ID da tabela
     */
    private function setID() {
        $sql = 'SELECT MAX(id) as id FROM ' . $this->useTable . ';';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->array = $this->conn->fetch();
        $this->id = $this->array['id'];
        $this->array = array();
    }

    /**
     * Transforma um <b>Array</b> em uma <b>String</b>. <br/>
     * @param Array $campos Um array de <b>strings</b>.<br/>
     * @return String String com todos os campos do array<br/> 
     * separados por virgula. 
     */
    private function arrayToString($campos) {
        $string = '';
        $num = count($campos);
        $i = 0;
        foreach ($campos as $value) { /*percorre os campos*/
            $string .= $value; /*Insere campo na string*/
            if ($i < $num - 1) /*Não coloca "," depois do ultimo campo*/
                $string .= ', '; 
            $i++;
        }
        return $string;
    }
    
    /**
     * Gera o WHERE dos <b>SQL's</b> <br/>
     * Utiliza os campos desfinidos no atributo <b>data</b><br/>
     * Insere a string gerada no final do atriburo <b>sql</b>
     */
    private function geraWhere(){
        $sql = '';
        if (!empty($this->data)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($this->data as $key => $value) { /* cria parametros do sql*/
                $num = count($this->data);
                $sql .= $key . ' = :' . $key;
                if ($i < $num - 1)
                    $sql .= ' AND ';

                $i++;
            }
        }
        $this->sql .= $sql;
    }

    /** 
     * Gera Query SQL Select<br/>
     * @param Array\String $campos Array ou String 
     * com os campos que serão selecionados na consulta.<br/>
     * Se $campos for Nulo todos os campos são selecionados. <br/>
     * Insere a Consulta gerada no atriburo <b>sql</b>
     */
    private function geraSelect($campos = null) {
        $sql = 'SELECT ';
        if (is_array($campos)) {
            $campos = $this->arrayToString($campos); /*gera string com os campos*/
        }
        if ($campos != null) {
            $sql .= $campos; /* caso tenha algum campo insere no sql*/
        } else {
            $sql .= '*'; /*Caso não tenha um campo especificado selecionara todos*/
        }
        $sql .= ' FROM ' . $this->useTable;
        if (!empty($this->data)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($this->data as $key => $value) { /*cria os parametros*/
                $num = count($this->data);
                $sql .= $key . ' = :' . $key;
                if ($i < $num - 1)
                    $sql .= ' AND ';

                $i++;
            }
        }
        $this->sql = $sql;
    }
    
    
    /** 
     * Gera Query SQL Insert<br/>
     * Insere os campos no atributo <b>data</b> no banco<br/>
     * Insere o sql gerado no atriburo <b>sql</b>
     */

    private function geraInsert() {
        $num = count($this->data);
        $i = 0;
        $valores = $num == 1 ? 'VALUE (' : 'VALUES (';
        $sql = 'INSERT INTO ' . $this->useTable . ' ( ';
        foreach ($this->data as $key => $value) {/*cria os parametros*/
            $sql .= $key;
            if ($i < $num - 1)
                $sql .= ', ';
            $valores .= ':' . $key;
            if ($i < $num - 1)
                $valores .= ', ';
            $i++;
        }
        $valores .= ' );';
        $sql .= ' ) ' . $valores;
        $this->sql = $sql;
    }

    /** 
     * Gera Query SQL UPDATE<br/>
     * Atualiza os campos no atributo <b>data</b> no banco<br/>
     * Guarda o sql gerado no atriburo <b>sql</b>
     */
    private function geraUpdate() {
        $num = count($this->data);
        $i = 0;
        $sql = 'UPDATE ' . $this->useTable . ' SET ';
        foreach ($this->data as $key => $value) {/*cria os parametros*/
            $sql .= $key . ' = :' . $key;
            if ($i < $num - 1)
                $sql .= ', ';
            $i++;
        }
        $sql .= ' WHERE id = :id';
        $this->sql = $sql;
    }

    /** 
     * Gera Query SQL DELETE <br/>
     */
    private function geraDelete() {
        $sql = 'DELETE FROM ' . $this->useTable;
        $this->sql = $sql;
        if (!empty($this->data)) {
            $this->geraWhere(); /*Gera o where*/
        }
        
    }
    
    
    
    /** 
     * Salva os dados no Banco
     * @return String Query sql gerada para inserir dados no banco. 
     */
    public function save() {
        $this->geraInsert();
        $this->conn->query($this->sql);/*prepara a query*/
        $this->conn->execute($this->data); /*executa a query*/
        $this->setID(); /*seta o ultimo id*/
        return $this->sql;
    }

    /**
     * Update
     * @param int $id id a ser atualizado<br/>
     * Utiliza os valores no atributo <b>data</b>
     */
    public function update($id) {
        $this->geraUpdate();
        $this->conn->query($this->sql);
        $this->conn->execute($this->data + array('id' => $id));
    }

    /**
     * Deleta os campos onde os valores sejam iguais<br/>
     * campos definidos atributo <b>data</b>
     */
    public function delete() {
            $this->geraDelete();
            $this->conn->query($this->sql);
            $this->conn->execute($this->data);
            $this->setID();
            return 1;
       
    }

    /**
     * Seleciona os dados na tabela referente ao modelo.<br/>
     * Filtrados pelos campos definido no atributo <b>data</b>
     * @param Array\String $campos Array ou String 
     * com os campos que serão selecionados na consulta.<br/>
     * Se $campos for Nulo todos os campos são selecionados. <br/>
     * @return Array resultado da consulta
     */
    public function select($campos = NULL) {
        $this->geraSelect($campos);
        $this->conn->query($this->sql);
        $this->conn->execute($this->data);
        $this->array = $this->conn->fetchALL();
        return $this->array;
    }

    
    /**
     * Seleciona todos os campos da tabela referente ao modelo.
     * @return Array resultado da consulta
     */
    public function selectAll() {
        $sql = 'SELECT * FROM ' . $this->useTable . ' ORDER BY id;';
        $this->array = $this->conn->queryAll($sql, array());
        return $this->array;
    }

    /**
     * Seleciona todos os campos na tabela referente ao modelo.
     * @param int $id Id a ser buscado na tabela.
     * @return Array resultado da consulta
     */
    public function selectById($id) {
        $sql = 'SELECT * FROM' . $this->useTable . ' WHERE id = :id;';
        $this->conn->query($sql);
        $this->conn->execute(array('id' => $id));
        $this->array = $this->conn->fetchAll();
        return $this->array;
    }

    /**
     * Prepara a query sql
     */
    private function query() {
        $this->conn->query($this->sql);
    }

    /**
     * Prepara e executa uma query sql
     * @param Array campos utilizados na query
     * @return Array Resultado da consulta.
     */
    public function queryFetch($dados) {
        $this->conn->query($this->sql);
        return $this->conn->fetchAll($dados);
    }

    /**
     * Prepara e executa uma query sql
     * @param Array campos utilizados na query
     */    
    public function queryExecute($dados = null) {
        $this->conn->query($this->sql);
        $this->conn->execute($dados);
    }

}

?>
