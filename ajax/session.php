<?php

include_once 'includes.php';

$mapa = isset($_GET['mapa']) ? $_GET['mapa'] : '';
$nome = isset($_GET['nome']) ? $_GET['nome'] : NULL;


Session::setVal('mapa', $mapa);
Session::setVal('nome', $nome);


?>
