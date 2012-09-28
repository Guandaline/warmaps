<?php

class conecta
{
		

function conecta()

	 	{		

		 	$localhost="localhost";// local da conexao com o banco

  			$user ="root"; // nome do usuário

  			$senha = ""; // senha para acessar o banco

  			$nome_banco ="warmaps"; //nome do banco de dados

  			$conexao = mysql_connect($localhost,$user,$senha) or die ("Configuracao de Banco de Dados Errada!");

  			mysql_select_db("$nome_banco",$conexao);

		

		}

		

		function desconnecta()

			{

        	 mysql_close($conexao);

    	

			}
}

?>