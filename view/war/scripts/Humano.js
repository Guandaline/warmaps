Humano = function ()
	{

     this.paises = new Array();    

     extende(this, Jogador);

     this._init ();

	}



Humano.prototype._init = function ()
	{

     this.tipo = "Humano";

	   

     iVar = this;

    

     this.setaProximo = document.getElementById('setaAvancar');

     this.setaMover = document.getElementById('setaMover');

	 this.setaCartas = document.getElementById('setaCartas');

    

     this.setaMover.addEventListener('click', function()
		{

	     if( jogo.flag == 1 )
			{

			 jogo.selecionado.desselecionarVizinhos( );

	         jogo.selecionado = "";

	         jogo.flag = 2;

	        }

	     else

	      warAlert(' Você ja finalizou seu ataque, portanto mova os exércitos que julgar necessário clicando sobre a parte colorida do pais, para finalizar clique na seta "terminar turno" ');



		}, false);

    

     this.setaProximo.addEventListener('click', function()
		{

		 if( jogo.jogadorAtual == iVar )
			{

			 for( i = 0; i < jogo.jogadorAtual.paises.length; i ++ )
			    {

				 jogo.jogadorAtual.paises[i].qtdExercitosAnterior = 0;

				 jogo.jogadorAtual.paises[i].jaRecebeuExecitos = false;

			    }

			 jogo.flag = 0;

			 jogo.jogar();

		    }

		 else
			{
			 /*warAlert(jogo.jogadores.length);	
			 for (h=0;h<jogo.jogadores.length;h++)
	 			{
		 		 alert(jogo.jogadores[h].nome+jogo.jogadores[h].paises.length);
		 		 for(c=0;c<jogo.jogadores[h].paises.length;c++)
		 			{
			  		 alert(jogo.jogadores[h].nome + " => "+jogo.jogadores[h].paises[c].nome+" = "+jogo.jogadores[h].paises[c].qtdExercitos);
					}
				}	
			     
			 jogo.jogar();*/	 
			 warAlert("Quem esta jogando é o :" + jogo.jogadorAtual.nome);		
			}

	    }, false);





	 this.setaCartas.addEventListener( 'click', function()
		{

		 iVar.janelaTrocaCartas();

		 if( jogo.jogadorAtual == iVar && jogo.flag == 0)
			{

			 if( iVar.cartas.length > 0 )
				{

				 if( jogo.jogadorAtual.cartas.length > 2 )

					jogo.jogadorAtual.janelaTrocaCartas();

				else

					this.cartas[k].atualizaExercitosMapa();

			    }

			 else
				{

				 alert(" Voces ainda nao possui cartas ");
				}

			}	

		},false);

	 //this.caculaNovosExercitos();

	

	}



Humano.prototype.jogar = function(){

    jogo.flag = 0;

    this.calculaNovosExercitos();

}



Humano.prototype.distribuiExercitos = function(){

    jogo.flag = 0;

    this.calculaNovosExercitos();

}



Humano.prototype.distribuiExercitosInicio = function(){

    this.distribuiExercitos();

}



Humano.prototype.janelaTrocaCartas = function(){

	//addEventListener("passou"); retirado nao executa no firefox

    this.janelaTroca = new Janela('troca', 'Suas cartas');

    this.janelaTroca.janela.innerHTML = JANELA_TROCA;

	this.janelaTroca.select = document.getElementById('select_troca_cartas');

	

	

	var opt;

	

	for(m= 0; m < this.cartas.length; m++ ){

		opt = document.createElement('option');

		opt.value = this.cartas[m].nome;

		opt.innerHTML = this.cartas[m].nome + " -> " + cartas_name[ this.cartas[m].figura ];

		this.janelaTroca.select.appendChild( opt );

	}

	//this.janelaTroca.fechar();

	//alert("ssa");

	//return(4);



}



Humano.prototype.trocarCartas = function(){

	this.janelaTroca.select;

	cartas_p_trocar = new Array();

	

	for(l= 0; l < this.janelaTroca.select.options.length; l++)

		{

			if( this.janelaTroca.select.options[l].selected )

				cartas_p_trocar.push( defines.paises[ this.janelaTroca.select.options[l].value ].instancia );

		}

		if(jogo.jogadorAtual.verificaTroca())

			{ 

				jogo.jogadorAtual.qtdExercitos += 2;
		        warAlert(jogo.jogadorAtual.nome+" tem "+jogo.jogadorAtual.qtdExercitos+" exercitos");
				warAlert("");
				warAlert("Para distribuir seus exercitos clique sobre o numero localizado em cada pais. ");	
				for(l= 0; l < this.janelaTroca.select.options.length; l++)

						{

							if( this.janelaTroca.select.options[l].selected )
									{
									//alert("monte= "+jogo.monte.length+" cartas= "+this.cartas.length);		
								 	jogo.monte.push(this.cartas[l]);
								 	this.cartas.splice(l,1);
									// alert("monte= "+jogo.monte.length+" cartas= "+this.cartas.length);
									}
						}
				//alert("fechar");		
				//this.janelaTroca.fechar();

				}

		else

			alert("nao foi possivel realizar a troca");

		

		

this.janelaTroca.fechar();

//pegar cartas escolhidas

 //validar escola

 //jogo.monte = cartas;

}



