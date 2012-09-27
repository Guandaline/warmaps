<?php 
if(!empty($_GET["atacante"])) 
	{ 
	
	
	echo "oii";
	// O CAMPO VALOR CONTERÁ O QUE O USUARIO DIGITOU ATÉ O MOMENTO.. 
	// CONECTA AO BANCO COLOCA PARAMENTROS IP,USUARIO,SENHA 
	$conexao=mysql_connect("localhost","root",""); 

	//SELECIONA O BANCO DE DADOS QUE VAI USAR 
	mysql_select_db("War"); 
	$atacante=$_GET["atacante"];
	$atacado=$_GET["atacado"];
	 		 
		  $rodada=$_GET["rodada"];
	$nataque=$_GET["nataque"];
	$consecutivo=$_GET["consecutivo"];
	$jogo=$_GET["jogo"];
	//echo $atacante;
	// EXECUTA A INSTRUÇÃO SELECT PASSANDO O QUE O USUARIO DIGITOU 
	$sql = "INSERT INTO `jogadas` (`atacante`,`atacado`,`rodada`,`numero_do_ataque`,`consecutivo`,`jogo`) VALUES ('$atacante', '$atacado', '$rodada', '$nataque', '$consecutivo', '$jogo')";
	//echo $sql;
	$resultado=mysql_query($sql) or die (mysql_error());
	} 
?> 