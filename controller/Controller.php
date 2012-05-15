<?php

ini_set('display_errors', 1);
/*Definir a classe controler (atributos e metodos)
 * criar tarefas para desenvolver os metodos
 */

/**
 * Classe representa os dados.
 **/
class Controller{
    
    public $viewVars = array();
    protected $name;
    public $Model;
    protected $uses = array();

    function __construct() {
        
        $this->incluirModel();
        
    }
    
  
    /**
     * Inclui o model do correspondente ao controller
     **/
    public function incluirModel($model = NULL){
        $model = $this->name;
        include '../../model/'.$this->name.'.php';
        $this->Model = new $model();
    }
    
    /** 
        Inclue modulos no controller.
        @param string $model Nome do Modelo a ser utilizado.
        @return objectModel O novo modelo pode ser acessado pelo atributo $uses.
     **/
    protected function uses($model){
        include 'model/'.$model.'.php';      
        $this->uses[$model] = new $model();
        extract($this->uses[$model]);
    }

    
    /*retorna o nome do model*/
    protected function getName(){
        return $this->Model->name;
    }
    
    /**
     * Seta as Variáveis a serem utilizadas na View.<br/>
     * @param string $var <p>Nome da variavel. Pode ser uma <b>string</b> 
     * ou <b>array</b> contendo os nomes das variáveis.</p>
     * @param tipo $value <p>Valor da variável. Pode ser de qualquer 
     * tipo ou uma <b>array</b> contendo os valores das variáveis</p>
    **/
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
		$this->viewVars = array_merge($this->viewVars, $data);
    }
    

}

?>
