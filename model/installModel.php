<?php

class installModel extends Model{
    var $name = "install";
    var $usesTable = FALSE;
    
    public function createDataBase($user, $senha){
        
        $link = mysql_connect('localhost', $user,  $senha);
        
        $this->mysql_install_db('warmaps', 'bd/warmaps.sql', $errmsg);
        
    }
    
    public function mysql_install_db($dbname, $dbsqlfile, &$errmsg) {
        $result = true;

        if (!mysql_select_db($dbname)) {
            $result = mysql_query("CREATE DATABASE $dbname");
            if (!$result) {
                $errmsg = "could not create [$dbname] db in mysql";
                return false;
            }
            $result = $this->mysql_select_db($dbname);
        }

        if (!$result) {
            $errmsg = "could not select [$dbname] database in mysql";
            return false;
        }

        $result = mysql_import_file($dbsqlfile, $errmsg);
 
        return $result;
    }
    
    public function mysql_import_file($filename, &$errmsg) {
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
    
    
}

?>
