<?php

class Utils {

    public static function incluir($classe, $tipo, $nivel = '') {
        $url = $nivel . $tipo . '/' . $classe . ucfirst($tipo) . '.php';
        include_once $url;
    }

    public static function incluirMC($classe) {
        $model = 'model/' . $classe . 'Model.php';
        $controller = 'controller/' . $classe . 'Controller.php';
        include_once $model;
        include_once $controller;
    }

    public static function pa($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public static function createBd() {

        $link = mysql_connect('localhost', 'root', '12345');
        if (!$link) {
            die('Não foi possível conectar: ' . mysql_error());
        }

        $sql = 'CREATE DATABASE warmaps';
        if (mysql_query($sql, $link)) {
            echo "O banco de dados wawmaps foi criado\n";
        } else {
            echo 'Erro criando o banco de dados: ' . mysql_error() . "\n";
        }
    }

    public static function mysql_import_file($filename, &$errmsg) {
        /* Read the file */
        $lines = file($filename);

        if (!$lines) {
            $errmsg = "cannot open file $filename";
            return false;
        }

        $scriptfile = false;

        /* Get rid of the comments and form one jumbo line */
        foreach ($lines as $line) {
            $line = trim($line);

            if (!ereg('^--', $line)) {
                $scriptfile.=" " . $line;
            }
        }

        if (!$scriptfile) {
            $errmsg = "no text found in $filename";
            return false;
        }

        /* Split the jumbo line into smaller lines */

        $queries = explode(';', $scriptfile);

        /* Run each line as a query */

        foreach ($queries as $query) {
            $query = trim($query);
            if ($query == "") {
                continue;
            }
            if (!mysql_query($query . ';')) {
                $errmsg = "query " . $query . " failed";
                return false;
            }
        }

        /* All is well */
        return true;
    }

    /* Installs a DB with a given name with the help of a given
      .sql file

      Returns: true if all is well
      false if something is wrong
      (error message is embedded in $errmsg)

      One can also use mysql_error() if this function
      returns an error.

     */

    public static function mysql_install_db($dbname, $dbsqlfile, &$errmsg) {
        $result = true;

        if (!mysql_select_db($dbname)) {
            $result = mysql_query("CREATE DATABASE $dbname");
            if (!$result) {
                $errmsg = "could not create [$dbname] db in mysql";
                return false;
            }
            $result = mysql_select_db($dbname);
        }

        if (!$result) {
            $errmsg = "could not select [$dbname] database in mysql";
            return false;
        }

        $result = Utils::mysql_import_file($dbsqlfile, $errmsg);

        return $result;
    }

}

?>
