<?php

class Model{
    
    public $data = array();
    public $conn;
    public $id;
    protected $name;
    protected $table;
    protected $schema;
    private $sql;
    
    function __construct() {
        $this->conn = new Connexao();
    }
    
    
    private function geraInsert(){
        $num = count($this->data);
        $i = 0;
        $valores = $num == 1 ? 'VALUE (': 'VALUES (';
        $sql = 'INSERT INTO '.$this->table.' ( ';
        foreach ($this->data as $key => $value) {
            $sql .= $key;
            if($i<$num-1) $sql .= ', ';
            if(is_string($value)) $valores .= '"';
            $valores .= $value;
            if(is_string($value)) $valores .= '"'; 
            if($i<$num-1) $valores .= ', ';
            $i++;
            
        }
        $valores .= ' );';
        $sql .= ' ) '.$valores;
        $this->sql = $sql;
    }
    
    
    public function save(){
        
    }
    
    public function update(){
        $sql = 'UPDATE '.$this->table.''.'';
    }
    
    public function delete(){
        
    }
    
    public function selectAll(){
        $sql = 'SELECT * FROM '.$this->table.';';
        $this->conn->query($sql);
        $this->conn->execute();
        $this->conn->fetchAll();
    }
    
    public function selectById($id){
        $sql= 'SELECT * FROM'.$this->table.' WHERE id = :id;';
        $this->conn->queryAll($sql, array(':id' => $id));
    }
    
    
    

}

?>
