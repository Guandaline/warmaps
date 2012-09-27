/** class jogador de AI  */

AI = function (){	

	this.paises = new Array();    

	extende(this, Jogador);

	this._init ();

}



AI.prototype._init = function (){    

	this.tipo = "AI";

}

AI.prototype.encontraPaisMovimento = function(){

  possiveis = new Array();



  for( i = 0; i < this.paises.length; i++ )

    if( this.paises[i].encontraInimigos().length == 0 && this.paises[i].qtdExercitos > 1)

      possiveis.push( this.paises[i] );



  return possiveis;

}



AI.prototype.move = function (){



  possiveis = this.encontraPaisMovimento();



  for( l = 0; l < possiveis.length; l++){

    melhor = 0;

    pmelhor = possiveis[l].vizinhos[0];



    for(k = 0; k < possiveis[l].vizinhos; k++ ){

      timp = possiveis[l].vizinhos[k].calculaImportancia();

      if( timp >= melhor ){

	melhor = timp;

	pmelhor = possiveis[l].vizinhos[k];

      }

    }



    //alert("devo mover de " +  possiveis[l].nome + " para " + pmelhor.nome );

    qtd = 0;

    if( possiveis[l].jaRecebeuExercitos )

      qtd = possiveis[l].qtdExercitosAnterior - 1;

    else

      qtd = possiveis[l].qtdExercitos - 1;



    pmelhor.jaRecebeuExercitos = true;

    pmelhor.qtdExercitosAnterior = pmelhor.qtdExercitos;



    pmelhor.qtdExercitos += qtd;

    possiveis[l].qtdExercitos -= qtd;



    possiveis[l].atualizaExercitosMapa();

    pmelhor.atualizaExercitosMapa();

  }

  this.arrumarPaisesMovimentados();

}

AI.prototype.arrumarPaisesMovimentados = function(){

    for( i = 0; i < this.paises.length; i++ )

      this.paises[i].jaRecebeuExercitos = false;

}

AI.prototype.jogar = function (){

	jogo.flag = 0;



	this.distribuiExercitosContinente();

	this.distribuiExercitos();



	jogo.flag = 1;

	this.joga();



	jogo.flag = 2;

	if( !jogo.kabo )

	  this.move();



	jogo.jogar();

}

AI.prototype.joga = function(){

		

	while( this.encontraJogadas() > 0 && !jogo.kabo ){

		jog = this.objetivo.melhorJogada( this.jogadas );

		jog.jogar();



		if( this.objetivo.ganhei()||(jogo.jogadores.length < 2)  )

			jogo.kabo = true;	

	}

	

}



AI.prototype.distribuiExercitosInicio = function(){

	this.distribuiExercitos();

	jogo.distribuiExercitosInicio();

}



// Verifica se o jogadorAtual tem algum continente conquistado

AI.prototype.distribuiExercitosContinente = function (){

	for( var i = 0; i < 6; i++ )

 		if( this.isMyContinente( jogo.continentes[ i ] ) ){

			warAlert( " o continente -=-> " + jogo.continentes[ i ].nome + " � do " + jogo.jogadorAtual.cor );

			this.qtdExercitos = jogo.continentes[ i ].qtdExercitos;

			this.posicionaContinente(  jogo.continentes[ i ] );

		}	

}



// Posicionando exercitos por continente

AI.prototype.posicionaContinente = function ( continente ){

    var comVizinhos = new Array();

	

    for( prop in continente.paises )

		comVizinhos.push ( continente.paises[ prop ] );

	

// 	warAlert(" comVizinhos no posiona continente " + comVizinhos + " -- com " + continente.qtdExercitos + " novos exercitos " );

	

	exercitos = continente.qtdExercitos;

	

    while( exercitos > 0 ){

		posicao = this.objetivo.melhorPosicao( comVizinhos );

		posicao.qtdExercitos++;

		posicao.atualizaExercitosMapa();

// 		warAlert("→→→" + posicao.nome + " recebe + 1");

		exercitos--;

	}

}



// Distribui exércitos de uma forma geral

AI.prototype.distribuiExercitos = function (){

    this.calculaNovosExercitos();

    var comvizinhos = this.paises;

	while( this.qtdExercitos  ){

		//alert(comvizinhos );
	 //try
	 //	{
		 posicao = this.objetivo.melhorPosicao( comvizinhos );
	 //	}
	 /*catch(err)
	 	{	
		 this.objetivo=new Objetivo();
		 posicao = this.objetivo.melhorPosicao( comvizinhos );
		}*/
		posicao.qtdExercitos++;

		posicao.atualizaExercitosMapa();

// 		warAlert("→→→" + posicao.nome + " recebe + 1");

		this.qtdExercitos--;

	}

}



AI.prototype.encontraJogadas = function()
	{

	 this.jogadas = new Array();	

	 for( i = 0; i < this.paises.length; i++ )
		{

		  //alert(this.paises[i].vizinhos[i].jogador);
		 if( this.paises[i].qtdExercitos > 1 )
		  	{

			 jogada = new Jogada();

			 for( j = 0; j < this.paises[i].vizinhos.length; j++ )
				{
				 if( this.paises[i].vizinhos[j].jogador != this )
					{

					 jogada.destino = this.paises[i].vizinhos[j];

					 jogada.origem = this.paises[i];

					 this.jogadas.push( jogada );

					}
				}
			}

		}

	 return this.jogadas.length;

	}



AI.prototype.ponderaJogadas = function(){

	for(i = 0; i < this.jogadas.length; i++){

		this.jogadas.rate = 0;

		for(j = 0; j < this.objetivo.classificacoes.length; j++)

			this.jogadas.rate += this.objetivo.classificacoes[j]( this.jogada );

	}

}





//--------------------------- troca de cartas---------------------------//

AI.prototype.trocarCartas = function(){

	tipo = this.verificaTroca();

	//alert( tipo + " alertando o tipo " );

	if( tipo ){

		this.escolheCartas( tipo );

		return jogo.qtdExercitosTroca += 2;

	}

	else{

		alert(" As cartas ainda não podem ser trocadas ");

		return 0;

	}

}


//--------------------------- escolhe as cartas, remove do jogador e insere no monte---------------------------//

AI.prototype.escolheCartas = function( tipo ){

	if( tipo == DIFERENTES ){

		//alert( "to entrando no diferente chamando triangulo ");

		this.escolheMelhorCarta( TRIANGULO );

		//alert( "to entrando no diferente chamando circulo ");

		this.escolheMelhorCarta( CIRCULO );

		//alert( "to entrando no diferente chamando quadrado ");

		this.escolheMelhorCarta( QUADRADO );

	}

	else{

		//alert( " to entrando no igual " );

		this.escolheMelhorCartaIgual();

	}

}



//--------------------------- escolhe melhores cartas iguais, ponderando apenas se o pais é do jogador---------------------------//

AI.prototype.escolheMelhorCartaIgual = function( ){

	parametro = this.tipoTroca();

	for( c = 0; c < 3; c++ ){

		//alert(" chamado a " + (c + 1) + " Carta " + " parametro ==> " + parametro );

		this.escolheMelhorCarta( parametro );

	}

}


//--------------------------- escolhe melhores cartas diferentes, ponderando apenas se o pais é do jogador---------------------------//

AI.prototype.escolheMelhorCarta = function( figura ){

	k = -1;

	meu = false;

	for( j = 0; j < this.cartas.length; j++ )

		if( this.cartas[j].figura == figura ){

			if( this.cartas[j].jogador == this ){

				k = j;

				meu = true;

			}

			else if( k == -1 )

				k = j;

		}

	//alert( this.cartas[k].figura + " sera removida " + this.cartas[k] + '\n\n\n'+ this.cartas );

	if( meu ){

		this.cartas[k].qtdExercitos += 2;

		this.cartas[k].atualizaExercitosMapa();

	}

		

	jogo.monte.push( this.cartas[k] );

	//alert( jogo.monte + " monte dpis de receber a nova carta " + this.cartas[k] );

	this.cartas.splice( k, 1 );

	//alert( this.cartas + " dpois da remoção " );

}

