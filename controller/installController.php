<?php

class installController extends Controller{
    var $name = "install";
    /**
     * Action Index
     */
    public function index(){
        
    }
    
    /**
     * <b>Methodo</b>
     * Cria o banco de dados
     */
    public function createDataBase($data){
        
        $user = $data['post']['user'];
        $pass = $data['post']['pass'];
        
        $this->Model->createDataBase($user, $pass);
        $this->configDataBase($user, $pass);
        
        /*Redireciona pra index e manda nenomear oa aquivo install.php*/
        header("Location:index.php?remove=1&msg=".$errmsg);
        
    }
    
    /**
     * Metodo para criar arquivo de configuração do banco de dados
     * @param String $user Nome de usuário
     * @param String $pass Senha do banco
     */
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
