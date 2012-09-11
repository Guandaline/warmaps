<?php session_start(); 
include "conexao.php";
include "k-means.php";

class insercao 
	{

	 var $tipo;	

	 var $jogo;	

	 var $id_jogo;

	 var $numero_jogadores;

	 var $atacante;

	 var $atacado;

	 var $rodada;

	 var $numero_do_ataque;

	 var $consecutivo;

	function __construct($tipo,$valor1,$valor2,$valor3,$valor4)
	 	{ 
			$this->tipo=$tipo;

			switch($this->tipo)

				{

				 case 0:

			    	 $this->id_jogo=$valor1;

					 $this->numero_jogadores=$valor2;

					 break;

			 	case 1:

					$this->atacante=$valor1;

					$this->atacado=$valor2;

					$this->ataque=$valor3;
					 
					$this->defesa=$valor4;

					break;

				case 2:

					$this->atacante=$valor1;

				 	break;
				
				case 4:

					$this->numero_execitos=$valor1;
					$this->numero_paises=$valor2;
					$this->numero_continentes=$valor3;
					$this->jogador=$valor4;

				 	break;
					

				}

   		} 
	function jogo_atual()
		{

			$sql="SELECT max( id_jogo ) FROM `jogo` ";
			
			$dados=mysql_db_query("war1",$sql)or die ("jogo_atual => ".mysql_error());

			$id_jogo1=mysql_fetch_array($dados);

			$nova_id=$id_jogo1[0];
			//echo $nova_id;

			return $nova_id;

		}
	function id_ultimo_jogador($id_jogo)
		{

			$sql="SELECT max( id_jogador ) FROM `jogadores` where id_jogo = $id_jogo";

			$dados=mysql_db_query("war1",$sql)or die ("id_ultimo_jogador => ".mysql_error());

			$id_jogo1=mysql_fetch_array($dados);

			$nova_id=$id_jogo1[0];

			return $nova_id;

		}
	function insere_jogo()
		{

			

			//$id_jogo=$this->jogo_atual();

			//$id_jogo=$id_jogo+1;

			$sql1="INSERT INTO  `jogo` (  `numero_jogadores` ) VALUES ('$this->numero_jogadores');"; 			

			mysql_db_query("war1",$sql1)or die ("insere_jogo => ".mysql_error());
			
			$_SESSION["jogo"]=$this->jogo_atual();	

		}
	function insere_jogador()
		{ 

			$id_jogo=$_SESSION["jogo"];

			$id_jogo=$id_jogo;

			$id_jogador= $this->id_ultimo_jogador($id_jogo);

			$id_jogador=$id_jogador+1;
			 
			
			$sql1="INSERT INTO  `jogadores` (  `nome` ,`id_jogador`,`id_jogo` ) VALUES ('$this->atacante','$id_jogador','$id_jogo');";
			
			//echo $sql1." ";
			
			mysql_db_query("war1",$sql1)or die ("insere_jogador => ".mysql_error());



		}
	function busca_jogador($nome_jogador,$id_jogo)
		{

			$sql="SELECT id_jogador FROM  `jogadores` WHERE nome = '$nome_jogador' AND id_jogo = '$id_jogo'";
			//echo $sql;
			$dados=mysql_db_query("war1",$sql)or die ("busca_jogador => ".mysql_error());

			$id_jogador=mysql_fetch_array($dados);

			$nova_id=$id_jogador[0];

			return $nova_id;

		}
	function insere_rodada()
		{ 
			
			$id_jogo=$_SESSION["jogo"];

			$rodada=$this->busca_ultima_rodada($id_jogo);

				$rodada=$rodada+1;
				//echo $rodada;
				if($rodada>1)
					{
					$this->define_perfil();
					//$this->retorna_perfil();
					//echo "ooi";
					}
				 $sql="INSERT INTO  `rodada` ( `id_rodada`,`id_jogo` ) VALUES ('$rodada','$id_jogo');";

				 mysql_db_query("war1",$sql)or die ("insere_rodada => ".mysql_error());

			

		}
	function busca_ultima_jogada($id_rodada)
		{
			
			$id_jogo=$_SESSION["jogo"];
			
			$sql="SELECT MAX( id_jogada ) FROM jogada WHERE id_rodada = $id_rodada and id_jogo=$id_jogo";
			//echo $sql;

			$dados=mysql_db_query("war1",$sql)or die ("busca_ultima_jogada => ".mysql_error());

			$id_jogada=mysql_fetch_array($dados);

			$nova_id=$id_jogada[0];

			return $nova_id;

		}
	function busca_ultima_rodada($id_jogo)
		{
			$sql="SELECT MAX( id_rodada ) FROM rodada WHERE id_jogo = $id_jogo";
			$dados=mysql_db_query("war1",$sql)or die ("busca_ultima_rodada => ".mysql_error());

			$id_rodada=mysql_fetch_array($dados);

			$nova_id=$id_rodada[0];

			return $nova_id;

		}
	function insere_ultimo($id_atacante,$id_atacado,$id_jogo)
		{

			$sql="INSERT INTO ultimo  (`id_atacante`,`id_atacado`,`numero_de_ataque`,`id_jogo`) VALUES('$id_atacante','$id_atacado','1','$id_jogo');";

			$dados=mysql_db_query("war1",$sql)or die ("insere_ultimo => ".mysql_error());

			return 1;

		}
	function atualiza_ultimo($id_atacante,$id_atacado,$id_jogo)
		{

			$controle=$this->verifica_ultimo_atacado($id_atacante,$id_atacado,$id_jogo);

			if($controle!=0)

				{

					$ultimo_valor=$this->busca_ultimo_ataque($id_atacante,$id_jogo);

				}

			$ultimo=$ultimo_valor+1;

			$sql="UPDATE ultimo SET ultimo.numero_de_ataque= 

			$ultimo ,ultimo.id_atacado=$id_atacado WHERE ultimo.id_atacante= $id_atacante AND ultimo.id_jogo=$id_jogo;";

			//echo $sql;
			$dados=mysql_db_query("war1",$sql)or die ("atualiza_ultimo => ".mysql_error());

			return $ultimo;

		}
	function busca_ultimo_atacado($id_atacante,$id_atacado,$id_jogo)
		{

			$sql="select ultimo.numero_de_ataque FROM ultimo where ultimo.id_atacante =$id_atacante  AND ultimo.id_jogo=$id_jogo";

			$dados=mysql_db_query("war1",$sql)or die ("busca_ultimo_atacado => ".mysql_error());

			$valor_atacado=mysql_fetch_array($dados);

			$atacado=$valor_atacado[0];

			//echo $atacado;

			return $atacado;

		}	
	function verifica_ultimo_atacado($id_atacante,$id_atacado,$id_jogo)
		{

			$sql="select ultimo.id_atacado FROM ultimo where ultimo.id_atacante =$id_atacante  AND ultimo.id_jogo=$id_jogo";

			//echo $sql;

			$dados=mysql_db_query("war1",$sql)or die ("verifica_ultimo_atacado => ".mysql_error());

			$valor_atacado=mysql_fetch_array($dados);

			$atacado=$valor_atacado[0];

			if($atacado==$id_atacado)

			  return 1;

			else

			  return 0;

		}
	function busca_dados_rodada()
		{			
					$id_jogo=$_SESSION["jogo"];
										
					$sql="SELECT jogada.id_jogada, jogada.id_atacante,jogada.continuidade FROM jogada WHERE id_jogo=$id_jogo AND jogada.id_rodada=(SELECT MAX(rodada.id_rodada)FROM rodada WHERE rodada.id_jogo=$id_jogo ) ORDER BY jogada.id_rodada,jogada.id_jogada,jogada.id_atacante,continuidade;
";
					//echo $sql;
					$dados=mysql_query($sql)or die ("busca_dados_rodada => ".mysql_error());
					return $dados;
				
		}
	function busca_ultimo_ataque($id_atacante,$id_jogo)
		{

			$sql="select ultimo.numero_de_ataque FROM ultimo where ultimo.id_atacante = '$id_atacante'  AND ultimo.id_jogo= '$id_jogo';";

			$dados=mysql_db_query("war1",$sql)or die ("busca_ultimo_ataque => ".mysql_error());

			$valor_ataque=mysql_fetch_array($dados);

			$novo_ataque=$valor_ataque[0];

			//echo $sql;
			

			return $novo_ataque;

		}
	function insere_jogada()
		{ 
			$id_jogo=$_SESSION["jogo"];
			$id_rodada=$this->busca_ultima_rodada($id_jogo);
			$id_jogada=$this->busca_ultima_jogada($id_rodada);
			$id_jogada=$id_jogada+1;
			$id_atacante= $this->busca_jogador($this->atacante,$id_jogo);
			$id_atacado= $this->busca_jogador($this->atacado,$id_jogo);	
			if(NULL==$this->busca_ultimo_ataque($id_atacante,$id_jogo))
				 $ultimo=$this->insere_ultimo($id_atacante,$id_atacado,$id_jogo);
			else
			  	$ultimo=$this->atualiza_ultimo($id_atacante,$id_atacado,$id_jogo);
			$sql=" INSERT INTO  `jogada` ( `id_jogada`,`id_rodada`,`id_atacante`,`id_atacado`,`ataque`,`defesa`,`continuidade`,`id_jogo` ) VALUES ('$id_jogada','$id_rodada','$id_atacante','$id_atacado','$this->ataque','$this->defesa','$ultimo','$id_jogo');";
			mysql_db_query("war1",$sql)or die ("insere_jogada => ".mysql_error());		 

		}
        function busca_max_rodada_forca($id_jogador)
		{
			$id_jogo=$_SESSION['jogo'];
			$sql="SELECT max(forca.id_rodada) FROM forca WHERE forca.id_jogador=$id_jogador AND forca.id_jogo=$id_jogo";
			//echo $sql;
			$dados=mysql_db_query("war1",$sql)or die ("busca_max_rodada_forca => ".mysql_error());
			$valor_rodada=mysql_fetch_array($dados);
			$novo_rodada=$valor_rodada[0];
			return $novo_rodada;
			
		}
	function mais_forte($id_jogador)
		{
			$jogo_id=$_SESSION["jogo"];
			$sql="SELECT jogadores.id_jogador FROM jogadores WHERE jogadores.id_jogo=$jogo_id AND jogadores.id_jogador!='$id_jogador'";
			//echo $sql;
			$dados=mysql_db_query("war1",$sql)or die ("busca_adversario_mais_forte => ".mysql_error());
			
			$id_adversario=mysql_fetch_array($dados);
			$forca=$this->busca_forca($id_adversario["id_jogador"]);
			$id=$id_adversario["id_jogador"];
			while($id_adversario=mysql_fetch_array($dados))
				{
					if($forca < $this->busca_forca($id_adversario["id_jogador"]))
						{
							$forca=$this->busca_forca($id_adversario["id_jogador"]);
							$id=$id_adversario["id_jogador"];
						}
					
				}
			return	$id;	
		}		
        function mais_fraco($id_jogador)
                {
                        $id_jogo=$_SESSION['jogo'];
                        $sql="SELECT jogadores.id_jogador FROM jogadores WHERE jogadores.id_jogo=$id_jogo AND jogadores.id_jogador!='$id_jogador'";
                        $dados=mysql_db_query("war1",$sql)or die ("busca_adversario_mais_forte => ".mysql_error());
                        $id_adversario=mysql_fetch_array($dados);
                        $forca=$this->busca_forca($id_adversario["id_jogador"]);
                        $id=$id_adversario["id_jogador"];
                        while($id_adversario=mysql_fetch_array($dados))
                                {
                                        if($forca > $this->busca_forca($id_adversario["id_jogador"]))
                                                {
                                                        $forca=$this->busca_forca($id_adversario["id_jogador"]);
                                                        $id=$id_adversario["id_jogador"];
                                                }

                                }
                        return	$id;
                }
        function maior_numero_ataque_jogador($id_jogador)
                {
                        $id_jogo=$_SESSION['jogo'];
                        $sql="SELECT jogada.id_atacado,COUNT(jogada.id_atacado) AS numero_ataques FROM jogada WHERE jogada.id_jogo=$id_jogo AND jogada.id_rodada=(SELECT MAX(jogada.id_rodada) FROM jogada WHERE jogada.id_jogo=$id_jogo) AND jogada.id_atacante='$id_jogador' GROUP BY id_atacado order by numero_ataques DESC";
                        $dados=mysql_db_query("war1",$sql)or die ("maior_numero_ataque_jogador => ".mysql_error());
                        $id_atacado=mysql_fetch_array($dados);
                        return $id_atacado["id_atacado"];
                }
        function busca_forca($id_jogador)
                {
                        $id_jogo=$_SESSION['jogo'];
                        $sql="SELECT ((forca.q_continetes*1)+(forca.q_paises*0.5)+(forca.q_exercitos*0.3)) FROM forca WHERE forca.id_jogo=$id_jogo AND forca.id_jogador='$id_jogador' AND forca.id_rodada=(SELECT MAX(rodada.id_rodada) FROM rodada WHERE rodada.id_jogo=$id_jogo AND rodada.id_rodada=(SELECT MAX(jogada.id_rodada)FROM jogada WHERE jogada.id_atacante='$id_jogador' AND jogada.id_jogo=$id_jogo) );";
                        $dados=mysql_db_query("war1",$sql)or die ("busca_forca => ".mysql_error());
                        $forca=mysql_fetch_array($dados);
                        return $forca[0];
                }
        function insere_forca()	
                {
                        $id_jogo=$_SESSION['jogo'];
                        $id_rodada=$this->busca_ultima_rodada($id_jogo);
                        $id_atacante= $this->busca_jogador($this->jogador,$id_jogo);
                        $max_rodada_forca=$this->busca_max_rodada_forca($id_atacante);
                        if($id_rodada > $max_rodada_forca){
                                  $sql="INSERT INTO `forca` (`id_jogo`, `id_rodada`, `id_jogador`, `q_continetes`, `q_paises`, `q_exercitos`) VALUES ('$id_jogo', '$id_rodada', '$id_atacante', '$this->numero_continentes', '$this->numero_paises', '$this->numero_execitos')";
                        }
                        else{
                                  $sql="UPDATE `forca` SET `q_continetes`='$this->numero_continentes', `q_paises`='$this->numero_paises', `q_exercitos`='$this->numero_execitos' WHERE (`id_jogo`=$id_jogo) AND (`id_rodada`=(SELECT MAX(jogada.id_rodada)FROM jogada WHERE jogada.id_jogo=$id_jogo)) AND (`id_jogador`='3')";
                        }
                        mysql_db_query("war1",$sql)or die ("insere_forca => ".mysql_error());	
                }
        function busca_mais_me_atacou($id)
                {
                    $id_jogo=$_SESSION['jogo'];	
                    $sql="SELECT tb1.id_atacante,MAX(tb1.conta) FROM(
                    SELECT jogada.id_atacante,jogada.id_atacado,COUNT(jogada.id_atacante)as conta FROM jogada
                    WHERE jogada.id_jogo=$id_jogo
                    AND jogada.id_rodada>=((SELECT MAX(rodada.id_rodada) FROM rodada WHERE rodada.id_jogo=$id_jogo)-1)
                    AND jogada.id_atacado='$id' GROUP BY jogada.id_atacante,jogada.id_atacado)AS tb1 GROUP BY tb1.id_atacado ;";
                    $dados=mysql_db_query("war1",$sql)or die ("Busca Mais Me Atacou => ".mysql_error());
                    $id_atacado=mysql_fetch_array($dados);
                    return $id_atacado[0];
                }
        function busca_ataques_nao_continuos($id,&$r1,&$r2)
                {
                    $id_jogo=$_SESSION['jogo'];	
                    $sql="SELECT maior_ataque,maior_defesa from 
                    (SELECT COUNT(jogada.id_atacado)AS maior_ataque FROM jogada WHERE jogada.id_jogo=$id_jogo
                    AND jogada.id_rodada=(SELECT MAX(rodada.id_rodada)FROM rodada WHERE rodada.id_jogo=$id_jogo)
                    AND jogada.ataque > jogada.defesa
                    AND jogada.id_atacante=$id)AS x,

                    (SELECT COUNT(jogada.id_atacado)AS maior_defesa FROM jogada WHERE jogada.id_jogo=$id_jogo	
                    AND jogada.id_rodada=(SELECT MAX(rodada.id_rodada)FROM rodada WHERE rodada.id_jogo=$id_jogo)
                    AND jogada.ataque < jogada.defesa
                    AND jogada.id_atacante=$id)AS y  ";
                    $dados=mysql_db_query("war1",$sql)or die ("Busca Ataques Nao Continuos => ".mysql_error());
                    $id_atacado=mysql_fetch_array($dados);
                    $r1=$id_atacado["maior_ataque"];
                    $r2=$id_atacado["maior_defesa"];		
                    echo $r1,$r2;	
                }		
        function busca_nome_jogador($id)
                {
                        $id_jogo=$_SESSION['jogo'];
                        $sql="SELECT jogadores.nome FROM jogadores WHERE jogadores.id_jogo=$id_jogo AND jogadores.id_jogador='$id'";
                        $dados=mysql_db_query("war1",$sql)or die ("Busca_Nome => ".mysql_error());
                        $forca=mysql_fetch_array($dados);
                                return $forca[0];
                }		
        function define_perfil()
                {
                $jogadores=0;
                $id_jogo=$_SESSION['jogo'];
                cria_estrutura($jogadores,$jogada);//cria estrutura
                k_means($jogadores,$jogada);//clusteriza
                for($i=1;$i<=$jogadores;$i++) //imprime clusters
                                {
                                 if($jogada[$i]["cluster"]==1)
                                        {
                                        $r1=$r2=1;	
                                         $this->busca_ataques_nao_continuos($i,$r1,$r2);	
                                         if($r1<$r2)
                                                {
                                                 //echo "?1?";	
                                                 $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                 $id_jogo";
                                                 $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                 if(mysql_num_rows($dados1)==0)
                                                        {	
                                                         $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                         ($id_jogo, '$i', '6')";
                                                         $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                        }
                                                 else
                                                        {
                                                         $sql="UPDATE `perfil` SET `id_perfil`='6' WHERE `id_jogo`=$id_jogo AND
                                                         (`id_jogador`='$i')";
                                                         $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                        }
                                                }
                                         else 
                                                {
                                                 if($r1>$r2)
                                                        {
                                                         //echo "?1?";	
                                                         $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                         $id_jogo";
                                                         $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                         if(mysql_num_rows($dados1)==0)
                                                                {	
                                                                 $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                                 ($id_jogo, '$i', '7')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                                }
                                                         else
                                                                {
                                                                 $sql="UPDATE `perfil` SET `id_perfil`='7' WHERE `id_jogo`=$id_jogo AND
                                                                 (`id_jogador`='$i')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                                }
                                                        }
                                                 else
                                                        {
                                                         $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                         $id_jogo";
                                                         $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                         if(mysql_num_rows($dados1)==0)
                                                                {	
                                                                 $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                                 ($id_jogo FROM jogo), '$i', '4')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                                }
                                                         else
                                                                {
                                                                 $sql="UPDATE `perfil` SET `id_perfil`='4' WHERE `id_jogo`=$id_jogo AND
                                                                 (`id_jogador`='$i')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                                }
                                                        }
                                                }
                                        }

                                 else
                                        {
                                        //echo "?2?";	
                                         if(($jogada[$i]["cluster"]==2)&&($this->maior_numero_ataque_jogador($i) ==$this->mais_forte($i)))
                                                {	
                                                 //echo "perfil mais forte";
                                                 $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                 $id_jogo";
                                                 $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                 if(mysql_num_rows($dados1)==0)
                                                        {	
                                                         $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                         ($id_jogo, '$i', '1')";
                                                         $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                        }
                                                 else
                                                        {
                                                        $sql="UPDATE `perfil` SET `id_perfil`='1' WHERE `id_jogo`=$id_jogo AND
                                                         (`id_jogador`='$i')";
                                                        $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                        }
                                                }
                                         else
                                                { 
                                                 if(($jogada[$i]["cluster"]==2)&&($this->maior_numero_ataque_jogador($i)==$this->mais_fraco($i)))																												
                                                        {
                                                         //echo "perfil mais fraco";
                                                         $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                         $id_jogo";
                                                         $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                         if(mysql_num_rows($dados1)==0)
                                                                {	
                                                                 $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                                 ($id_jogo, '$i', '2')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                                }
                                                         else
                                                                {
                                                                 $sql="UPDATE `perfil` SET `id_perfil`='2' WHERE `id_jogo`=$id_jogo AND
                                                         (`id_jogador`='$i')";
                                                                 $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                                }
                                                        }
                                                 else
                                                        {
                                                         //echo "perfil indefinido";
                                                         if(($jogada[$i]["cluster"]==2)&&($this->maior_numero_ataque_jogador($i)==$this->maior_numero_ataque_jogador($i)))																												
                                                                {
                                                                 //echo "perfil mais vingativo";
                                                                 $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                                 $id_jogo";
                                                                 $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                                 if(mysql_num_rows($dados1)==0)
                                                                        {	
                                                                         $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                                         ($id_jogo, '$i', '5')";
                                                                         $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                                        }
                                                                 else
                                                                        {
                                                                         $sql="UPDATE `perfil` SET `id_perfil`='5' WHERE `id_jogo`=$id_jogo AND
                                                                     (`id_jogador`='$i')";
                                                                         $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                                        }
                                                                }
                                                         else
                                                                {
                                                                 $sql1="SELECT * FROM perfil where perfil.id_jogador= $i AND perfil.id_jogo=
                                                                 $id_jogo";
                                                                 $dados1=mysql_db_query("war1",$sql1)or die ("Insere Perfil => ".mysql_error());
                                                                 if(mysql_num_rows($dados1)==0)
                                                                        {	
                                                                         $sql="INSERT INTO `perfil` (`id_jogo`, `id_jogador`, `id_perfil`) VALUES 
                                                                     ($id_jogo, '$i', '3')";
                                                                         $dados=mysql_db_query("war1",$sql)or die ("Insere Perfil => ".mysql_error());
                                                                        }
                                                                 else
                                                                        {
                                                                         $sql="UPDATE `perfil` SET `id_perfil`='3' WHERE `id_jogo`=$id_jogo AND
                                                                     (`id_jogador`='$i')";
                                                                         $dados=mysql_db_query("war1",$sql)or die ("Aluaiza Perfil => ".mysql_error());
                                                                        }
                                                                }			
                                                        }
                                                }	
                                        }
                                        //echo $this->mais_fraco($i);

                                }	

        }
        function retorna_perfil()
                {
                $id_jogo=$_SESSION['jogo'];	
                $sql="SELECT jogadores.nome,perfil.id_jogo,tipo.nome_perfil,tipo.ataque_minimo,tipo.defesa_minima FROM perfil,tipo,jogadores
                WHERE  perfil.id_perfil = tipo.id_perfil 
                AND perfil.id_jogo=$id_jogo
                AND jogadores.id_jogo=$id_jogo
                AND jogadores.id_jogador =perfil.id_jogador
                ORDER BY jogadores.nome";
                $perfis=mysql_db_query("war1",$sql)or die ("Retorna Perfil => ".mysql_error());
                while($perfil = mysql_fetch_array($perfis))
                        {
                        echo "|".$perfil["nome"].",".$perfil["id_jogo"].",".$perfil["nome_perfil"].",".$perfil["ataque_minimo"].",".$perfil["defesa_minima"]."|";
                        }
                }
        function insere()
                {	
                        switch($this->tipo)

                                {

                                 case 0:


                                        $this->insere_jogo();
                                        //echo "jogo";
                                        break;

                                 case 1:

                                     $this->insere_jogada();
                                         //echo"jogada";
                                         break;

                                case 2:

                                     $this->insere_jogador();
                                         //echo"jogador";

                                         break;	

                                case 3:
                                         $this->insere_rodada();

                                          //echo "rodada";


                                         break;	
                                case 4:

                                     $this->insere_forca();
                                         //echo"forca";

                                         break;		 
                                case 5:
                                         $this->retorna_perfil();
                                         break;



                                }



                }
	 /*function atualiza_valores()

		 {

			 

			 echo $sql = "SELECT max(numero_do_ataque) FROM `jogadas` WHERE `atacante` = '$this->atacante' AND `atacado` = '$this->atacado' ";

			 $dados=mysql_db_query("war",$sql)or die (mysql_error());

			 $numero_do_ataque+=mysql_fetch_array($dados);

			 

			 

		 }

	 

	 function insere()

	 	{	

		 $sql="INSERT INTO `jogadas` (`atacante`, `atacado`, `rodada`, `numero_do_ataque`, `consecutivo`, `jogo`) VALUES ('$this->atacante', '$this->atacado', '$this->rodada','$this->numero_do_ataque','$this->consecutivo','$this->jogo');"; 

			mysql_db_query("war",$sql)or die (mysql_error());

		}

	 

	 */ 

	}
/*switch($_GET["tipo"]==1)

	{

	 case 0:

	 	 

		 break;

	 case 1:

	 	 $conectar=new banco($_GET["tipo"],$_GET["atacante"],$_GET["atacado"],$_GET["rodada"],$_GET["nataque"],$_GET["consecutivo"],$_GET["jogo"]);

		  break;	  

	}*/

//echo "socorro";
$insere=new insercao($_GET["tipo"],$_GET["valor1"],$_GET["valor2"],$_GET["valor3"],$_GET["valor4"]);
$conecta=new conecta();
$conecta->conecta();
//$rodada=$insere->busca_dados_rodada();

//while($res_dados = mysql_fetch_array($rodada))
//    echo $res_dados["id_jogada"];

//echo $insere->busca_forca(1)." ";
//echo $insere->busca_forca(2)." ";
//echo $insere->busca_forca(3)." ";
//echo $insere->tipo." ";
  
//if($insere->tipo==3)
//{	
//echo "oi";	
//$jogadores=0;
//cria_estrutura($jogadores,$jogada);//cria estrutura
//echo "{".$jogadores."}";
//k_means($jogadores,$jogada);//clusteriza
//echo " [".$insere->mais_fraco(1)." ]";
//echo  " [".$insere->mais_forte(1)."] ";
//echo "*".$insere->maior_numero_ataque_jogador(1)."*";
/*for($i=1;$i<=$jogadores;$i++) //imprime clusters
		 			{
					echo "[".$jogada[$i]["cluster"]."]";
					if(($jogada[$i]["cluster"]==2)&&($insere->maior_numero_ataque_jogador($i)==$insere->mais_forte($i)))
						echo "perfil mais forte";																							
					if(($jogada[$i]["cluster"]==2)&&($insere->maior_numero_ataque_jogador($i)==$insere->mais_fraco($i)))																												
						echo "perfil mais fraco";
					}	
*/

//}

$insere->insere();
echo $_SESSION["jogo"];
$conecta->desconecta;



/*___________________________________________________________________________________________________________________________________*/
/*___________________________________________________________________________________________________________________________________*/

 
?>