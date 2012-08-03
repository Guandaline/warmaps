<?php

//include_once 'bd/Connexao.php';
//include 'bd/Connexao.php';
/**
 * Abstrai todo o acesso ao banco de dados.
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
            if($id == 0) $this->setID();
            else $this->id = $id;
        }
    }

    private function setID() {
        $sql = 'SELECT MAX(id) as id FROM ' . $this->useTable . ';';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->array = $this->conn->fetch();
        $this->id = $this->array['id'];
        $this->array = array();
    }
    
    private function arrayToString($campos){
        $string = '';
        $num = count($campos);
        $i = 0;
        foreach ($campos as $value) {
            $string .= $value;
            if($i < $num - 1)
                $string .= ', ';
        }
        return $string;
    }

    private function geraSelect($campos = null) {
        $sql = 'SELECT ';
        if(is_array($campos)) {
            $campos = arrayToString($campos);
        }
        if ($campos != null) {
            $sql .= $campos;
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->useTable;
        if (!empty($this->data)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($this->data as $key => $value) {
                $num = count($this->data);
                $sql .= $key . ' = :' . $key;
                if ($i < $num - 1)
                    $sql .= ' AND ';

                $i++;
            }
        }
        $this->sql = $sql;
    }

    private function geraInsert() {
        $num = count($this->data);
        $i = 0;
        $valores = $num == 1 ? 'VALUE (' : 'VALUES (';
        $sql = 'INSERT INTO ' . $this->useTable . ' ( ';
        foreach ($this->data as $key => $value) {
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

    private function geraUpdate() {
        $num = count($this->data);
        $i = 0;
        $sql = 'UPDATE ' . $this->useTable . ' SET ';
        foreach ($this->data as $key => $value) {
            $sql .= $key . ' = :' . $key;
            if ($i < $num - 1)
                $sql .= ', ';
            $i++;
        }
        $sql .= ' WHERE id = :id';
        $this->sql = $sql;
    }

    private function geraDelete() {
        $sql = 'DELETE FROM ' . $this->useTable . ' WHERE id = :id';
        $this->sql = $sql;
    }

    public function save() {
        $this->geraInsert();
        $this->conn->query($this->sql);
        $this->conn->execute($this->data);
        $this->setID();
        return $this->sql;
    }

    public function update($id) {
        $this->geraUpdate();
        $this->conn->query($this->sql);
        $this->conn->execute($this->data + array('id' => $id));
    }

    public function delete($id) {
        if ($id > 0) {
            $this->geraDelete();
            $this->conn->query($this->sql);
            $this->conn->execute(array('id' => $id));
            $this->setID();
            return 1;
        } else {
            return 0;
        }
    }

    public function select($campos) {
        $this->geraSelect($campos);
        $this->conn->query($this->sql);
        $this->conn->execute($this->data);
        $this->array = $this->conn->fetchALL();
        return $this->array;
    }

    public function selectAll() {
        $sql = 'SELECT * FROM ' . $this->useTable . ' ORDER BY id;';
        $this->array = $this->conn->queryAll($sql, array());
        return $this->array;
    }

    public function selectById($id) {
        $sql = 'SELECT * FROM' . $this->useTable . ' WHERE id = :id;';
        $this->conn->query($sql);
        $this->conn->execute(array('id' => $id));
        $this->array = $this->conn->fetchAll();
        return $this->array;
    }

    /*
      public function select(){
      }

     */
}

?>
