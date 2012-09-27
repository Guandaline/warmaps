<?php

/* Definir a classe controler (atributos e metodos)
 * criar tarefas para desenvolver os metodos
 */

/**
 * Classe que representa os dados.
 * */
class Controller {

    public $viewVars = array();
    protected $Model;
    protected $uses = array();
    protected $name;
    
    function __construct() {

        $this->incluirModel();
        $this->setTitulo($this->name);
    }

    /**
     * Inclui o model do correspondente ao controller
     * */
    public function incluirModel($model = NULL) {
        $model = $this->name . 'Model';
        //$nomeModel = ucfirst($this->name); 
        //include_once 'model/'.$this->name.'Model.php';
        //$this->Model = $nomeModel;
        $this->Model = new $model();
    }

    /**
      Inclui modulos no controller.
      @param string $model Nome do Modelo a ser utilizado.
      @return objectModel O novo modelo pode ser acessado pelo atributo $uses.
     * */
    protected function uses($model, $nivel = '') {
        
        include_once $nivel . 'model/' . $model . 'Model.php';
        $nameModel = ucfirst($model);
        $classModel = $model.'Model';
        $this->uses[$model] = $nameModel;
        $this->$nameModel= new $classModel();
    }

    /* retorna o nome do model */

    protected function getName() {
        return $this->Model->name;
    }

    /**
     * Seta as Variáveis a serem utilizadas na View.<br/>
     * @param string $var <p>Nome da variavel. Pode ser uma <b>string</b> 
     * ou <b>array</b> contendo os nomes das variáveis.</p>
     * @param tipo $value <p>Valor da variável. Pode ser de qualquer 
     * tipo ou uma <b>array</b> contendo os valores das variáveis</p>
     * */
    public function set($var, $value = NULL) {
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

    /**
     * Seta o titulo da página
     * @param string $titulo Titulo da Página
     * */
    public function setTitulo($titulo) {
        $this->set('titulo', $titulo);
    }

    public function setData($dados) {
        $this->Model->data = $dados;
    }
    
    public function getId() {
        return $this->Model->id;
    }

    public function save() {
        $this->Model->save();
    }

    public function update($id) {
        $this->Model->update($id);
    }

    public function delete() {
        $this->Model->delete();
    }

    public function select($campos) {
        return $this->Model->select($campos);
    }

    public function selectAll() {
        return $this->Model->selectAll();
    }

    public function selectById($id) {
        return $this->Model->selectById($id);
    }
    
    

}
?>

