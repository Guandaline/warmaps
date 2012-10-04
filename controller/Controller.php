<?php



/**
 * Classe responsável pela manibulação dos dados.
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

    /**
     * Seta dos dados que devem ser usados em uma query sql
     * @param Array $dados Campos que quevem ser  utilizados em um sql
     */
    public function setData($dados) {
        $this->Model->data = $dados;
    }
    /**
     * Pega o id maximo da tabela
     * @return int id maximo da tabela
     */
    public function getId() {
        return $this->Model->id;
    }

    /** 
     * Salva os dados no Banco
     * @return String Query sql gerada para inserir dados no banco. 
     */
    public function save() {
       return $this->Model->save();
    }

    /**
     * Update
     * @param int $id id a ser atualizado<br/>
     * Utiliza os valores no atributo <b>data</b>
     */
    public function update($id) {
        $this->Model->update($id);
    }

    /**
     * Deleta os campos onde os valores sejam iguais<br/>
     * campos definidos atributo <b>data</b>
     */
    public function delete() {
        $this->Model->delete();
    }
    
    /**
     * Seleciona os dados na tabela referente ao modelo.<br/>
     * Filtrados pelos campos definido no atributo <b>data</b>
     * @param Array\String $campos Array ou String 
     * com os campos que serão selecionados na consulta.<br/>
     * Se $campos for Nulo todos os campos são selecionados. <br/>
     * @return Array resultado da consulta
     */
    public function select($campos = NULL) {
        return $this->Model->select($campos);
    }
    
    /**
     * Seleciona todos os campos da tabela referente ao modelo.
     * @return Array resultado da consulta
     */
    public function selectAll() {
        return $this->Model->selectAll();
    }
    
    /**
     * Seleciona todos os campos na tabela referente ao modelo.
     * @param int $id Id a ser buscado na tabela.
     * @return Array resultado da consulta
     */
    public function selectById($id) {
        return $this->Model->selectById($id);
    }
    
    

}
?>

