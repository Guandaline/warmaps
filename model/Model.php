<?php

class Model{
    
    public $data = array();
    public $conn;
    public $id = 0;
    public $res;
    protected $name;
    protected $useTable;
    protected $schema;
    protected $bd = 'default';
    private $sql;
    private $array;


    function __construct() {
        $this->conn = new Connexao();
        $this->setID();
       
    }
    
    private function setID(){
        $sql = 'SELECT MAX(id) as id FROM '.$this->useTable.';';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->array = $this->conn->fetch();
        $this->id = $this->array['id'];
    }


    private function geraInsert(){
        $num = count($this->data);
        $i = 0;
        $valores = $num == 1 ? 'VALUE (': 'VALUES (';
        $sql = 'INSERT INTO '.$this->useTable.' ( ';
        foreach ($this->data as $key => $value) {
            $sql .= $key;
            if($i<$num-1) $sql .= ', ';
            $valores .= ':'.$key;
            if($i<$num-1) $valores .= ', ';
            $i++;
            
        }
        $valores .= ' );';
        $sql .= ' ) '.$valores;
        $this->sql = $sql;
    }
    
    
    public function save(){
         $this->geraInsert();
         $this->conn->query($this->sql);
         $this->conn->execute($this->data);
         $this->setID();
        
    }
    
    public function update(){
        $sql = 'UPDATE '.$this->useTable.''.'';
    }
    
    public function delete(){
        
    }
    
    public function selectAll(){
        $sql = 'SELECT * FROM '.$this->useTable.';';
        $this->conn->queryAll($sql, array());
        
    }
    
    public function selectById($id){
        $sql= 'SELECT * FROM'.$this->useTable.' WHERE id = :id;';
        $this->conn->query($sql);
        $this->conn->execute();
        
    }
    
    
    

}

?>
