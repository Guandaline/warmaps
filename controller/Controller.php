<?php

ini_set('display_errors', 1);
/*Definir a classe controler (atributos e metodos)
 * criar tarefas para desenvolver os metodos
 * (2 dias)
 */
class Controller{
    public $Model;
    public $viewVars;
    protected $name;
    
    function __construct() {
        $this->incluir();
    }
    
    private function incluir(){
        include 'model/'.$this->name.'.php'; 
        $modelo = $this->name;
        $this->model = new $modelo();
    }


    public function getName(){
        return $this->Model->useTable;
    }
    
    public function set($var, $value = NULL){
            if (is_array($var)) {
			if (is_array($value)) {
				$data = array_combine($var, $value);
			} else {
				$data = $var;
			}
		} else {
			$data = array($var => $value);
		}
		$this->viewVars = $data + $this->viewVars;
    }
    

}

?>
