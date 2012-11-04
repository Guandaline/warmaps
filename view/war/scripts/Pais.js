/** class Pais */

Pais = function (name, continente){

  extende(this, Node);

    

  this._init (name, continente);

  defines.paises[ name ].instancia = this;

}



/**

 * _init sets all Pais attributes to their default value. Make sure to call this

 * method within your class constructor

 */

Pais.prototype._init = function (name, continente){

    this.nome = name;

    this.jogador = "";

    this.vizinhos = Array();

    this.janelaAtaque = "";

    this.qtdExercitos = 1;

    this.jaRecebeuExecitos = false;

    this.qtdExercitosAnterior = 0;

    this.figura = defines.paises[ name ].figura;

    this.valorEstrategico = defines.paises[ name ].valorEstrategico;

    this.continente = continente;

    this.noMapa = document.getElementById( name );
       
    this.noMapaLabel = document.getElementById("l_" + name);



    this.noMapaLabel.textContent = this.qtdExercitos;



    var iVar = this;



    this.noMapa.addEventListener("click",function (){

		iVar.selecionaPaisAtaque();

    }, false);





    this.noMapaLabel.addEventListener("click", function () {	

		iVar.distribuiExercitos();

    }, false);

}



Pais.prototype.distribuiExercitos = function(){
	var cont;
    if( this.jogador == jogo.jogadorAtual){  
	 // 		distribuição por territorio
		if( jogo.jogadorAtual.flagDist == 0 ){
			if( jogo.jogadorAtual.qtdExercitos > 0 ){
				jogo.jogadorAtual.qtdExercitos--;
				this.qtdExercitos++;
				this.noMapaLabel.textContent = this.qtdExercitos;
			}
			else{
				if( jogo.jogada <= jogo.jogadores.length )
					jogo.distribuiExercitosInicio();
				else
                                    if( jogo.jogadorAtual.qtdExercitos == 0 && jogo.flag != 2 && jogo.jogadorAtual.flagDist == 0 ){
						cont = 0;
						var tem = 0;
						for( m = 0; m < jogo.continentes.length; m++ )
							if( jogo.jogadorAtual.isMyContinente( jogo.continentes[ m ] ) )
								tem = 1;
						if( tem )
							jogo.jogadorAtual.flagDist = 1;
						else{
							warAlert( " COMECE SEU ATAQUE  ");
							warAlert("");
							warAlert("Para atacar clique na area colorida de um pais e na area colorida do vizinho a ser atacado. ");
							jogo.flag = 1;
						}

				}
			}

		}
// 		distribuição por continente conquistado
		else if( jogo.jogadorAtual.flagDist == 1 ){
			if( jogo.jogadorAtual.idxCont < 6 || jogo.jogadorAtual.qtdExercitos > 0 ){
				if( jogo.jogadorAtual.qtdExercitos == 0 ){
					while( !jogo.jogadorAtual.isMyContinente( jogo.continentes[ jogo.jogadorAtual.idxCont ] ) && jogo.jogadorAtual.idxCont < 5 )
						jogo.jogadorAtual.idxCont++;
					if( jogo.jogadorAtual.isMyContinente( jogo.continentes[ jogo.jogadorAtual.idxCont ] )){
						jogo.jogadorAtual.qtdExercitos = jogo.continentes[ jogo.jogadorAtual.idxCont ].qtdExercitos; 			
						warAlert( "Voc� tem --> " + jogo.jogadorAtual.qtdExercitos + " exercitos para distribuir no continente -->  " + jogo.continentes[ jogo.jogadorAtual.idxCont ].nome );
					}
					jogo.jogadorAtual.idxCont++;
				}
				else{
					if( this.continente == jogo.continentes[ jogo.jogadorAtual.idxCont - 1 ] ){
						jogo.jogadorAtual.qtdExercitos--;
						this.qtdExercitos++;
						this.noMapaLabel.textContent = this.qtdExercitos;
					}
					else
						warAlert( " Voce tem " + jogo.jogadorAtual.qtdExercitos + " novos exércitos mas so pode distribuir no continente --> " + jogo.continentes[ jogo.jogadorAtual.idxCont - 1 ].nome );
						warAlert("");
						warAlert("Para distribuir seus exercitos clique sobre o numero localizado em cada pais. ");
				}
			}
		}
    }
	if( jogo.jogadorAtual.qtdExercitos ==0 ){
		 warAlert( " COMECE SEU ATAQUE  ");
		 warAlert("");
		 warAlert("Para atacar clique na area colorida de um pais e na area colorida do vizinho a ser atacado. ");
		 jogo.flag = 1;
		}

}



Pais.prototype.selecionaPaisAtaque = function(){
     truta = 0;
     if( this.jogador == jogo.jogadorAtual ){
		 if( jogo.flag == 1 ){
			 if( jogo.selecionado != "" )
				jogo.selecionado.desselecionarVizinhos( );  
			 jogo.selecionado = this;
			 this.selecionarVizinhos();
                 }
		 else if( jogo.flag == 2 ){
			 if( jogo.selecionado == "" ){
			     jogo.selecionado = this;
			     this.selecionarVizinhosMover();
			 } 
			 else{
                            if( this.isVizinho( jogo.selecionado ) ){
					 this.verificaMovimento();
					 jogo.selecionado.desselecionarVizinhos();
					 jogo.selecionado = "";
					}
				 else{
				     jogo.selecionado.desselecionarVizinhos();
					 jogo.selecionado = this;
					 jogo.selecionado.selecionarVizinhosMover();
					}
			    }
		    }
		 else
			confirm("Você precisa terminar de distribuir seus exércitos." + '\n' + "Restam " + ( jogo.jogadorAtual.qtdExercitos ) + " para serem distribuidos");
        }
    if( ( jogo.selecionado != this ) && (jogo.selecionado != "" ) ){
	with( jogo ){   
	    if( flag == 1 ){ 
		for( i = 0; i < selecionado.vizinhos.length; i++ )
		    if( this.nome == selecionado.vizinhos[i].nome && selecionado.qtdExercitos > 1){
			atacado = this;
			atacar();
			if( jogo.jogadorAtual.objetivo.ganhei()||(jogo.jogadores.length < 2) ){
			  warAlert("---Acabou o jogo---");
			  jogo.kabo = true;
			  jogo.finaliza();
			}
			else
			  warAlert("---Ainda não acabou---");
			truta = 1;
		    }
	    }
	}
	if( !truta && jogo.selecionado )
	    jogo.selecionado.desselecionarVizinhos();
    }
}



Pais.prototype.selecionarVizinhosMover = function(){

    var i;

    for( i = 0; i < this.vizinhos.length; i++ ){

	if( this.jogador == this.vizinhos[i].jogador )

	    this.vizinhos[i].noMapa.setAttribute('class', 'pais jogavel ' + this.vizinhos[i].jogador.cor );

    }

    this.noMapa.setAttribute('class', 'pais selecionado ' + this.jogador.cor );

}



Pais.prototype.atualizaExercitosMapa = function(){

    this.noMapaLabel.textContent = this.qtdExercitos;

}





/*seleciona os vizinhos ao clicar o mouse no objeto*/

Pais.prototype.selecionarVizinhos = function(){



    for(i = 0; i < this.vizinhos.length; i++){

	if( this.jogador != this.vizinhos[i].jogador )

	    this.vizinhos[i].noMapa.setAttribute('class', 'pais jogavel ' + this.vizinhos[i].jogador.cor );

    }

    this.noMapa.setAttribute('class', 'pais selecionado ' + this.jogador.cor );

}



/*remove seleção dos vizinhos */

Pais.prototype.desselecionarVizinhos = function(){

  for(i = 0; i < this.vizinhos.length; i++)

      this.vizinhos[i].noMapa.setAttribute('class', 'pais '+ this.vizinhos[i].jogador.cor );



  this.noMapa.setAttribute('class', 'pais ' + this.jogador.cor );

}



Pais.prototype.pintar = function(){

  this.noMapa.setAttribute('class', 'pais ' + this.jogador.cor );

}



Pais.prototype.relacionarVizinhos = function(){

  for( i = 0; i < defines.paises[ this.nome ].vizinhos.length; i++ ){
      console.log(this.nome);
      console.log(defines.paises[this.nome ].vizinhos[i]);
      this.vizinhos.push( defines.paises[ defines.paises[this.nome ].vizinhos[i] ].instancia );

      //this.

  }

}





Pais.prototype.isVizinho = function( obj ){

  for(i = 0; i < this.vizinhos.length; i++)

    if( obj == this.vizinhos[i] )

      return true;



  return false;

}



Pais.prototype.qtdInimigosVizinhos = function( pais ){

	var i, inimigo = 0, maisOdiado = 0;

	for( i = 0; i < pais.vizinhos.length; i++ ){

		if( this.jogador.nome != pais.vizinhos[i].jogador.nome )

			inimigo++;

		if( inimigo > maisOdiado )

			maisOdiado = inimigo;

	}

	warAlert( "vou retornar o valor de maisOdiado = " + maisOdiado + " para " + this.nome );

	return maisOdiado;

}



Pais.prototype.calculaImportancia = function(){

	var importancia = 0;

	nInimigos = this.encontraInimigos();

	

	importancia += nInimigos.length;



	importancia += this.impedeConquista();



	if( importancia > 0)

	  return importancia;



	else{  

	  this.grafo.calcDistances( this );



	  minimo = MAXINT;

	  pminimo = "";



	  for(prop in this.grafo.nodes){

	      if( this.jogador != this.grafo.nodes[ prop ].jogador  )

		  if ( this.grafo.nodes[ prop ].distance < minimo ){

		      minimo = this.grafo.nodes[ prop ].distance;

		      pminimo = this.grafo.nodes[ prop ];

		  }

	  }



	  return Math.abs( pminimo.distance - 10) / 1000;

	}

}



Pais.prototype.impedeConquista = function(){

// 	jog = "";	

// 	for( prop in this.continente.paises )

// 		if( this.continente.paises[ prop ].jogador != this.jogador ){

// 			if( jog == "" )

// 				jog = this.continente.paises[ prop ].jogador;

// 			if( this.continente.paises[ prop ].jogador != jog )

// 				return 0;

// 		}

// 	return 10;

  return 0;

}



Pais.prototype.encontraInimigos = function( ){

	var inimigos = new Array();

	for( var i = 0; i < this.vizinhos.length; i++ )

	    if( this.jogador != this.vizinhos[ i ].jogador )

			inimigos.push( this.vizinhos[ i ] );

	return inimigos;

}



Pais.prototype.verificaMovimento = function( ){    

    qtd = 0;    

    if( jogo.selecionado.jaRecebeuExecitos ){

	if( jogo.selecionado.qtdExercitosAnterior > 1 ){

	    qtd = parseInt( prompt("Digite a quantidade de exércitos que deseja mover | máximo = " + (jogo.selecionado.qtdExercitosAnterior - 1) ) );

	    if( !isNaN( qtd ) && qtd < jogo.selecionado.qtdExercitosAnterior && qtd > 0 ){

			this.jaRecebeuExecitos = true;

			this.qtdExercitosAnterior = this.qtdExercitos;

			jogo.selecionado.qtdExercitosAnterior -= qtd;

			this.move( qtd );

	    }

	}

    }

    else{

	if( jogo.selecionado.qtdExercitos > 1 ){

	    qtd = parseInt( prompt("Digite a quantidade de exércitos que deseja mover | máximo = " + (jogo.selecionado.qtdExercitos - 1) ) );

	    if( !isNaN( qtd ) && qtd < jogo.selecionado.qtdExercitos && qtd > 0){

			if( !this.jaRecebeuExecitos )

				this.qtdExercitosAnterior = this.qtdExercitos;

			this.jaRecebeuExecitos = true;

			this.move( qtd );

	    }

	}

    }

}



Pais.prototype.move = function( qtdMover ){    

    this.qtdExercitos += qtdMover;

    jogo.selecionado.qtdExercitos -= qtdMover;



    this.atualizaExercitosMapa();

    jogo.selecionado.atualizaExercitosMapa();

}





Pais.prototype.toString = function(){

  return "[Pais " + this.nome + "]";

}

