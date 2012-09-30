<?php

include_once 'bd/DataBaseConfig.php';

class conecta
{
		

function conecta()

	 	{	
                    
                        $database = new DataBaseConfig(); 

		 	$localhost = $database->host;// local da conexao com o banco

  			$user = $database->user; // nome do usuário

  			$senha = $database->pass; // senha para acessar o banco

  			$nome_banco = $database->banco; //nome do banco de dados

  			$conexao = mysql_connect($localhost,$user,$senha) or die ("Configuracao de Banco de Dados Errada!");

  			mysql_select_db("$nome_banco",$conexao);

		

		}

		

		function desconnecta()

			{

        	 mysql_close($conexao);

    	

			}
}

?>