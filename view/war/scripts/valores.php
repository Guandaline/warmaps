<?php

//include"conexao.php";

 class valores 

 	{

	 var $numero_jogadores;

	 var $jogadas_primeiro;
	 
	 var $numero_jogadas;

		  function __construct($numero_jogadores,&$jogadas)

	  	{

			 $this->numero_jogadores=$numero_jogadores;

	 		 $this->jogadas=$jogadas;
			
			

		}

		function menor_maior()
			{
				
				
			}

		function aumenta_valor()//padtronisa os valores

			{

				$i=0;

				while(1)

					{  

						if(!$this->jogadas[1][$i])

						   {

							 $this->jogadas[1][$i]=1;
							 $saida[1]=1;
							 if(($saida[2]==1) && ($saida[3]==1) && ($saida[4]==1) && ($saida[5]==1) && ($saida[6]==1) )
					  break;


						   }

						   

						   if(!$this->jogadas[2][$i])

						   {

							 $this->jogadas[2][$i]=1;  
								$saida[2]=1;
								if(($saida[1]==1) && ($saida[3]==1) && ($saida[4]==1) && ($saida[5]==1) && ($saida[6]==1) )
					  break;

						   }

						   

						   if(!$this->jogadas[3][$i])

						   {

							 $this->jogadas[3][$i]=1;  
								$saida[3]=1;
								if(($saida[1]==1) && ($saida[2]==1) && ($saida[4]==1) && ($saida[5]==1) && ($saida[6]==1) )
					  break;

						   }

						   

						   if(!$this->jogadas[4][$i])

						   {

							 $this->jogadas[4][$i]=1;
							 $saida[4]=1;
							 if(($saida[1]==1) && ($saida[2]==1) && ($saida[3]==1) && ($saida[5]==1) && ($saida[6]==1) )
					  break;



						   }

						   

						   if(!$this->jogadas[5][$i])

						   {

							 $this->jogadas[5][$i]=1;  
							 $saida[5]=1;
							 if(($saida[1]==1) && ($saida[2]==1) && ($saida[3]==1) && ($saida[4]==1) && ($saida[6]==1) )
					  break;


						   }

						   

						   if(!$this->jogadas[6][$i])

						   {

							 $this->jogadas[6][$i]=1;
							 $saida[6]=1;
							 if(($saida[1]==1) && ($saida[2]==1) && ($saida[3]==1) && ($saida[4]==1) && ($saida[5]==1) )
					  break;


						   }

						   

						 if(!$this->jogadas[0][$i])

						   {

							 $this->jogadas[0][$i]=1;  

						   }


						  

				  	 $i=$i+1;
					 $this->numero_jogadas=$i;
					 
					}			

			}
		function distancia_pontos($jogadas1,$jogadas2)

			{

				

				

				$acumula_pot[0]=0;

				$soma;

				$i=0;

				while($i <= $this->numero_jogadas)

					{

						$acumula_pot[$i]= pow(($jogadas1[$i] - $jogadas2[$i]),2);	

						

						$i++;

					}

				$i=0;

				$soma=0;

				while($i <= $this->numero_jogadas)

					{

						$soma=$acumula_pot[$i]+$soma ;

						$i++;

					}

				return sqrt($soma);

				

				

			}
		

	}
/*
$a[0]=1000;

$a[1]=0.3;

$b[0]=502;

$b[1]=502;

$c[0]=3;

$n[1]=&$a;
$n[1][cluster]=1;
$n[2]=&$b;
$n[2][cluster]=2;
$n[3]=&$c;
$n[2][cluster]=2;

$x=3;

$w=new valores($x,$n);

$w->aumenta_valor();
echo "#".$w->jogadas[3][2]."#";

$dif=$w->distancia_pontos($w->jogadas[1],$w->jogadas[2]);
if($dif < $w->distancia_pontos($w->jogadas[2],$w->jogadas[3]))
      $n[2][cluster]=$n[1][cluster];
echo "<br>".$n[2][cluster];
*/

?>