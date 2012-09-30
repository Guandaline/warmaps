<?php

class installController extends Controller{
    var $name = "install";
    
    public function index(){
        
    }
    
    public function createDataBase($data){
        
        $user = $data['post']['user'];
        $pass = $data['post']['pass'];
        
        $this->Model->createDataBase($user, $pass);
        $this->configDataBase($user, $pass);
        
        header("Location:index.php?remove=1&msg=".$errmsg);
        
    }
    
    private function configDataBase($user, $pass){

        $file = fopen('bd/DataBaseConfig.php', 'w');
        $string = "<?php
    class DataBaseConfig{
            public \$banco = 'warmaps';
            public \$pass = '". $pass ."';
            public \$host = 'localhost';
            public \$user = '".$user."';
    }
?>";
        fwrite($file, $string);
        
        fclose($file);
    }
    
}

?>
