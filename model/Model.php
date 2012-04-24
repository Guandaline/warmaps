<?php

include 'bd/Connexao.php';

class Model{
    
    public $data = array();
    public $conn;
    public $id = 0;
    public $where = array();
    public $resultado;
    public $array = array();
    public $del = array();
    protected $name;
    protected $useTable;
    protected $schema;
    protected $bd = 'default';
    private $sql;
    private $up;
    


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
        $this->array = array();
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
    
    private function geraUpdate(){
        $num = count($this->data);
        $i = 0;
        $sql = 'UPDATE '.$this->useTable.' SET ';
        foreach ($this->data as $key => $value) {
            $sql .= $key.' = :'.$key;
            if($i<$num-1) $sql .= ', ';
            $i++;
            
        }
        $k = 0;
        $num = count($this->where);
        if($num >0){
            $sql .= ' WHERE ';
            foreach ($this->where as $key => $value) {
                $sql .= $key.'= :w'.$key;
                if($k<$num-1) $sql .= ' AND ';
                $k++;
            }        
        }
        
        foreach ($this->where as $key => $value) {
            $this->up['w'.$key] = $value;
        }
        
         $this->up += $this->data;
        
        $this->sql = $sql;
    }
    
    private function geraDeltete(){
        $num = count($this->del);
        $i = 0;
        $sql = 'DELETE FROM '.$this->useTable.' WHERE ';
        foreach ($this->del as $key => $value) {
            $sql .= $key.'= :'.$key;
            if($i<$num-1) $sql .= ' AND ';
            $i++;
        } 
        $this->sql = $sql;
    }


    public function save(){
         $this->geraInsert();
         $this->conn->query($this->sql);
         $this->conn->execute($this->data);
         $this->setID();
        
    }
    
    public function update(){
        $this->geraUpdate();
        $this->conn->query($this->sql);
        $this->conn->execute($this->up);
    }
    
    public function delete(){
        if(count($this->del) > 0){
             $this->geraDeltete();
             $this->conn->query($this->sql);
             $this->conn->execute($this->del);
            return $this->sql;
        }else{
            return 0;
        }
    }
    
    public function selectAll(){
        $sql = 'SELECT * FROM '.$this->useTable.';';
        $this->array = $this->conn->queryAll($sql, array());
        return $this->array;
    }
    
    public function selectById($id){
        $sql= 'SELECT * FROM'.$this->useTable.' WHERE id = :id;';
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
