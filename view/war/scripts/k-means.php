<?php

include"valores.php";
//include"conexao.php";
//include"banco.php";
/*$jogadores=0;
echo cria_estrutura($jogadores,$jogada);//cria estrutura
echo "{".$jogadores."}";
k_means($jogadores,$jogada);//clusteriza
echo "[".$jogada[1]["cluster"]."]";
*/

function cria_estrutura(&$jogadores,&$jogada)
	{
	 $conecta=new conecta();//conecta banco
	 $insere=new insercao($_GET["tipo"],$_GET["atacante"],$_GET["atacado"],$_GET["rodada"],$_GET["nataque"],$_GET["consecutivo"],$_GET["jogo"]);//cria um objeto tipo insercao para faser a busca

	 $conecta->conecta();//conecat ao banco
	 //echo"passou";
 	 $dados_rodada=$insere->busca_dados_rodada();//busca os dados a serem agrupados
	 $indice1=$indice2=$indice3=$indice4=$indice5=$indice6=0;//idice dos jogadores
	// echo mysql_num_rows($dados_rodada);
 	 while($res_dados = mysql_fetch_array($dados_rodada))//leitura do bamco e montagem da estrutura necessaria para clusterizaçao	
 			{
				//echo $res_dados["id_jogada"],$res_dados["id_atacante"],$res_dados["continuidade"];
				//echo "#";
				switch ($res_dados["id_atacante"]) 
					{
    				 	case 1:
	       					$jogada[1][$indice1]=$res_dados["continuidade"];
							$jogada[1]["cluster"]=1;
							$indice1++;
        				break;
    					case 2:
        					$jogada[2][$indice2]=$res_dados["continuidade"];
							$jogada[2]["cluster"]=1;
							$indice2++;
        				break;
    					case 3:
        					$jogada[3][$indice3]=$res_dados["continuidade"];
							$jogada[3]["cluster"]=1;
							$indice3++;
        				break;
						case 4:
        					$jogada[4][$indice4]=$res_dados["continuidade"];
							$jogada[4]["cluster"]=1;
							$indice4++;
        				break;
						case 5:
        					$jogada[5][$indice5]=$res_dados["continuidade"];
							$jogada[5]["cluster"]=1;
							$indice5++;
        				break;
						case 6:
        					$jogada[6][$indice6]=$res_dados["continuidade"];
							$jogada[6]["cluster"]=1;
							$indice6++;
        				break;
				}
				
				if($res_dados["id_atacante"]>$jogadores)//define o numero de jogadores
					 $jogadores=$res_dados["id_atacante"];
			}
return $res_dados["id_atacante"];
	}

function k_means($jogadores,&$jogada)
	{
	$valores=new valores($jogadores,$jogada);//obijeto que manipula os valores 
	$valores->aumenta_valor();//funçao que padroniza os valores
	$interacao=0;
	//echo $valores->numero_jogadas;
	$o=$valores->jogadas[0];//origem
	$c1=$valores->jogadas[1];//centroide1
	$c2=$valores->jogadas[2];//centroide2
	for($i=1;$i<=$jogadores;$i++)//define o mais proximo e o mais longe da origem como o centroide 1 2  respetvamente
		{    
			//echo"<br>";
			//echo $valores->distancia_pontos($valores->jogadas[$i],$o)."|".$valores->distancia_pontos($c1,$o)."|".$valores->distancia_pontos($c2,$o)."<br>";
			//echo $valores->numero_jogadas[$i][2]."<br>";
			if(($valores->distancia_pontos($valores->jogadas[$i],$o)) < ($valores->distancia_pontos($c1,$o)))
				{
				 $c1=$valores->jogadas[$i];
				// echo"c1";
				}
			if(($valores->distancia_pontos($valores->jogadas[$i],$o)) > ($valores->distancia_pontos($c2,$o)))
				{
				 $c2=$valores->jogadas[$i];
				 //echo"c2";
				}
			
			    	
		}
	/*	
	for($j=0;$j<=$valores->numero_jogadas;$j++)
					{echo "[".$c2[$j]."]";}
					echo"<br>";*/		
	$mudou=-1;//define a primeira entrada no laço
	if(($valores->distancia_pontos($c1,$c2))!= 0)
	while(($mudou!=0) &&($interacao<10000) )//laço que executa ate nao exitir mudanças de cluster
		{
			$iteracao++;
			/*for($i=1;$i<=$jogadores;$i++)
		 			{
						echo "<br>".$valores->jogadas[$i]["cluster"]." tipo =".$valores->jogadas[$i]["tipo"];
					}	*/

		 if($mudou==1)//virifica se houve  aouteraçao nos clusters e se nao é a primeira execuçao 
		 	{
				for($j=0;$j<$valores->numero_jogadas;$j++)
					{
					  $c1[$j]=$c2[$j]=0;
					}
				
				for($i=1;$i<=$jogadores;$i++)//primeira parte do calculo do centroide
		 			{
					 
					 if($valores->jogadas[$i]["cluster"]==1)
					 	{
						  for($j=0;$j<$valores->numero_jogadas;$j++)
							{
					 		 $c1[$j]+=$valores->jogadas[$i][$j];
							}	
						 $d1++;	
						}
					 else
					 	{
						  for($j=0;$j<$valores->numero_jogadas;$j++)
							{
					 		 $c2[$j]+=$valores->jogadas[$i][$j];							 
							}	
						 $d2++; 	
						}
					
					}
					for($j=0;$j<$valores->numero_jogadas;$j++)//segunda parte do calculo do centroide
							{
							 //echo $c2[$j].",";
							 //echo "c2".$c2[$j];
							 //echo "<br>";
					 		 $c2[$j]=$c2[$j]/$d2;
							 $c1[$j]=$c1[$j]/$d1;
							 
							}
						//echo"<br>";	
			}
			//echo"<br>#".$valores->distancia_pontos($c1,$c2)."#<br>";
		 $mudou=0;//zera a variavel de controle de mudança
		 for($i=1;$i<=$jogadores;$i++) //calcualar as distancias de todos os pontos
		 	{
		 	 $distancias[1][$i]=$valores->distancia_pontos($c1,$valores->jogadas[$i]);//calcula distancias do ponto para os centroides
			 $distancias[2][$i]=$valores->distancia_pontos($c2,$valores->jogadas[$i]);
			 //echo "*".$distancias[2][$i],"<br>".$distancias[1][$i]."*<br>";
			 if($distancias[1][$i]< $distancias[2][$i])//verifica a qual cluster pertence um determinado ponto
			 	{
				 if($valores->jogadas[$i]["cluster"]!=1)
						{
						  $valores->jogadas[$i]["cluster"]=1;
						  $mudou=1;
						 
						}
						 					
				}
			 else
				{
				 if($valores->jogadas[$i]["cluster"]!=2)
					{
					 $valores->jogadas[$i]["cluster"]=2;
					 $mudou=1;
					
					}  	
					
				}
			  if($valores->distancia_pontos($o,$c1) < $valores->distancia_pontos($o,$c2))//errado:ara verifivicar tipo cluster
						     $valores->jogadas[$i]["tipo"]=1;
						  else
						      $valores->jogadas[$i]["tipo"]=2;
							  
			}
	
				
		}
	//echo "(".$iteracao.")";	
	$jogada=$valores->jogadas;
	
	}
	
	
	
	

?>