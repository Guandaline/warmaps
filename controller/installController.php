<?php

class installController extends Controller{
    var $name = "install";
    
    public function index(){
        
    }
    
    public function createDataBase($data){
        
        $this->Model->createDataBase($data['user'], $data['pass']);
        header("Location:index.php?remove=1&msg=".$errmsg);
        
    }
    
    
}

?>
