<?php

class conecta
{
		

function conecta()

	 	{		

		 	$localhost="localhost";// local da conexao com o banco

  			$user ="war1"; // nome do usuário

  			$senha = "12345"; // senha para acessar o banco

  			$nome_banco ="war1"; //nome do banco de dados

  			$conexao = mysql_connect($localhost,$user,$senha) or die ("Configuracao de Banco de Dados Errada!");

  			mysql_select_db("$nome_banco",$conexao);

		

		}

		

		function desconnecta()

			{

        	 mysql_close($conexao);

    	

			}
}

?>