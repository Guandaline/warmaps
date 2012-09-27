<?php

ini_set('display_errors', 1);
include_once 'element/includes.php';

$link = mysql_connect('localhost', 'root', '021190');

$errmsg = null;

Utils::mysql_install_db('warmaps', 'bd/estrutura_bd.sql', $errmsg);

header("Location:index.php?remove=1&msg=".$errmsg);




?>
