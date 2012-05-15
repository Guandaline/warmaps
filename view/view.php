<?php



class View{
    public $vars;
    protected $name;
    protected $template = 'default';
    public $controller;
    
    function __construct() {
        $this->incluirController();
        $this->vars = $this->controller->viewVars;
        extract($this->vars);
        $this->incluirTemplate();
    }
    
    /**
     *Inclue o Controller da View 
     ***/
    public function incluirController(){
        include '../../controller/'.$this->name.'controller.php';
        $controller = $this->name.'controller';
        echo $controller;
        $this->controller = new $controller;
    }
    
    /**
     *Inclue o Template 
     ***/
    private function incluirTemplate(){
        include '../../template/'.$this->template.'.php';
    }
    
    

}

?>
