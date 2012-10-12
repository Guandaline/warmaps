<?php

class Session {

    /**
     * Inicia uma sessão
     * @param String $var Nome da sessão
     */
    public static function start($var = NULL) {
        if (!isset($_SESSION[$var ]))/*verifica se a sesão ja foi criada*/
            session_start($var);/*inicia a sessão*/
    }
    
    /**
     * Seta uma variável na sessão
     * @param String $var Nome da variavel
     * @param indefinido $val Valor da variavel pode ser qualquer tipo
     */
    public static function setVal($var, $val) {
        $_SESSION[$var] = $val;
    }
    
    /**
     * Seta um array de variaveis. <br/>
     * A chave se torna o nome da variavel <br/>
     * e o valor é atribuido a ela.
     * @param Array $arr Array com valores
     */
    public static function setArray($arr) {
        foreach ($arr as $key => $value) {/*percorre array*/
            $_SESSION[$key] = $value;
        }
    }
    
    /**
     * Pega o valor de uma variavel na sessão
     * @param String $var Nome da variavel
     * @return Valor da variavel de sessão
     */
    public static function getVal($var) {
        return $_SESSION[$var];
    }

    /**
     * Fecha a sessão
     */
    public static function close() {
        session_destroy();
    }

}

?>