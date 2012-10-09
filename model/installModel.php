<?php

/**
 * Classe modelo de instalação
 * Cria o banco de dados e insere as tabelas
 */

class installModel extends Model{
    var $name = "install";
    var $usesTable = FALSE;
    
    /**
     * Cria o banco de dados
     * @param String $dbname Nome do banco de dados
     * @param String $dbsqlfile Caminho para o arquivo <b>".sql"</b> com a estrutura do banco
     * @param *String $errmsg Ponteiro para variável que recebera as mesnagens de erro
     * @return Bool <b>True</b> caso a estrutura do banco tenha sido criada corretamente <br/>
     * <b>False</b> caso ocorra algum erro na importação do banco. 
     */
    public function mysql_install_db($dbname, $dbsqlfile, $link, &$errmsg) {
        $result = true;
        
        if (!mysql_select_db($dbname)) { /*Verifica se o banco ja existe*/
            $result = mysql_query("CREATE DATABASE $dbname"); /*Cria o banco*/
            if (!$result) {
                $errmsg = "Não foi possivel criar o banco  de dados[$dbname]. <br/>
                            Certifique-se de que o usuário e senha estão corretos. <br/>
                            Verifique as permissões do usuário do banco.";
                return false;
            }
            $result = mysql_select_db($dbname); /*Seleciona o banco*/
        }

        if (!$result) { /*Mensagem de erro*/
            $errmsg = "Não foi possivel selecionar o banco de dados [$dbname]";
            return false;
        }

        $result = $this->mysql_import_file($dbsqlfile, $errmsg);
 
        return $result;
    }
    
    /**
     * Faz a importação da estrutura do banco de dados
     * @param String $filename Nome do arquivo de importação
     * @param *String $errmsg Variavel que recebe a mensagem de erro 
     */
    public function mysql_import_file($filename, &$errmsg) {
        /* Le o arquivo */
        $lines = file($filename);

        if (!$lines) {
            $errmsg = "Não foi possivel encontrar o arquivo $filename";
            return false;
        }

        $scriptfile = false;

        /* Retira os comentários e cria uma unica linha*/
        foreach ($lines as $line) {
            $line = trim($line);

            if (!ereg('^--', $line)) {
                $scriptfile.=" " . $line;
            }
        }

        if (!$scriptfile) {
            $errmsg = "Arquivo invalido $filename";
            return false;
        }

        /* divide a linha em comandos menores */

        $queries = explode(';', $scriptfile);

        /* Executa todos os comandos sqls */

        foreach ($queries as $query) {
            $query = trim($query);
            if ($query == "") {
                continue;
            }
            if (!mysql_query($query . ';')) {
                $errmsg = "query " . $query . " falhou";
                return false;
            }
        }

        /* Tudo correu bem */
        return true;
    }
    
    
}

?>
