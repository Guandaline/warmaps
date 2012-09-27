<?php

include_once 'includes.php';

$mapa = isset($_GET['mapa']) ? $_GET['mapa'] : '';
$nome = isset($_GET['nome']) ? $_GET['nome'] : NULL;

Session::start("warmaps");
Session::setVal('mapa', $mapa);
Session::setVal('nome', $nome);

echo Session::getVal('mapa'). ' ';
echo Session::getVal('nome');

?>
