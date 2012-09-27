<?php

class Session {

    public static function start($var = NULL) {
        if (!isset($_SESSION['mapa']))
            session_start($var);
    }

    public static function setVal($var, $val) {
        $_SESSION[$var] = $val;
    }

    public static function setArray($arr) {
        foreach ($arr as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public static function getVal($var) {
        return $_SESSION[$var];
    }

    public static function close() {
        session_destroy();
    }

}

?>