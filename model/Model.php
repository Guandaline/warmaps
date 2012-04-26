<?php

include 'bd/Connexao.php';

class Model {

    public $data = array();
    public $conn;
    public $id = 0;
#    public $resultado;
    public $array = array();
    protected $name;
    protected $useTable;
#    protected $schema;
    private $sql;
    private $aux;

    function __construct() {
        $this->conn = new Connexao();
        $this->setID();
    }

    private function setID() {
        $sql = 'SELECT MAX(id) as id FROM ' . $this->useTable . ';';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->array = $this->conn->fetch();
        $this->id = $this->array['id'];
        $this->array = array();
    }

    private function geraSelect() {
        $sql = 'SELECT ';
        if (!empty($this->data['campos'])) {
            $sql .= $this->data['campos'];
            $this->aux = $this->data['campos'];
            unset($this->data['campos']);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->useTable.' WHERE ';
        foreach ($this->data as $key => $value) {
            $num = count($this->data);
            $i = 0;
                $sql .= $key . ' = :' . $key;
                if ($i < $num - 1)
                    $sql .= ' AND ';
  
            $i++;
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
            return 1;
        } else {
            return 0;
        }
    }

    public function select() {
        $this->geraSelect();
        $this->conn->query($this->sql);
        $this->conn->execute($this->data);
        $this->array = $this->conn->fetch();
        $this->data['campos'] = $this->aux;
        return $this->sql;
    }

    public function selectAll() {
        $sql = 'SELECT * FROM ' . $this->useTable . ' ORDER BY id;';
        $this->array = $this->conn->queryAll($sql, array());
        return $this->array;
    }

    public function selectById($id) {
        $sql = 'SELECT * FROM' . $this->useTable . ' WHERE id = :id;';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->array = $this->conn->fetch();
        return $this->array;
    }

    /*
      public function select(){
      }

     */
}

?>
