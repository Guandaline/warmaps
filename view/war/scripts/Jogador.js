/** class Jogador */

Jogador = function ( name ){

  this._init ( name );

}



Jogador.prototype._init = function ( name ){

	this.paises = [];

	this.cor = "";

	this.continentes = new Array();

// 	this.cartas = [];

	this.nome = name;

	this.tipo = "Generic";

	this.qtdExercitos = 0;

	this.objetivo = "";

	this.flagDist = 0;

	this.idxCont = 0;

	this.conquisteiCarta = false;
	
	this.perfilNome="x";
	
	this.minAtaque=1;
	
	this.minDefesa=1;
}

Jogador.prototype.calculaNovosExercitos = function (){
    this.qtdExercitos = ( this.paises.length % 2 == 1) ?  ( this.paises.length - 1 ) / 2 : this.paises.length / 2;
//alert("exercitosTroca");
	if( this.cartas.length == 5 ){
		//alert( " É necessário efetuar a troca de cartas, limite máximo " );
		exercitosTroca = this.trocarCartas();
		//alert( " vc ja tem  " + this.qtdExercitos + " novos exercitos por territorio e + " + exercitosTroca + " por troca " );
		this.qtdExercitos += exercitosTroca;
	//alert( " Com troca vc possui agora " + this.qtdExercitos + " novos exercitos ");
	}
    if( this.paises.length < 6 )
		this.qtdExercitos = 3;
    warAlert( this.cor + " tem " + this.qtdExercitos + " novos exércitos." );
	warAlert("");
	warAlert("Para distribuir seus exercitos clique sobre o numero localizado em cada pais. ");
}

Jogador.prototype.isMyContinente = function( continente ){

	var contador = qtdPais = 0;

	for( pais in continente.paises ){

		if( jogo.jogadorAtual == continente.paises[ pais ].jogador )

			contador++;

		qtdPais++;

	}

	if( contador == qtdPais )

		return true;	

	return false;

}

Jogador.prototype.mostarCartas = function(){

	alert( " Você possui as seguintes cartas até o momento:" + '\n  \n' +  this.cartas );

}

//  verifica se o jogador tem 3 cartas iguais ou tres cartas diferentes 

Jogador.prototype.verificaTroca = function(){

	var tri = quad = red = 0;

	for( i = 0; i < this.cartas.length; i++ ){

		if( this.cartas[i].figura == TRIANGULO )

			tri++;

		else if( this.cartas[i].figura == CIRCULO )

			red++;

		else

			quad++;

	}



	//alert( " alertando tri, quad, red " + [tri, quad, red] + " tamando do cartas =  " + this.cartas.length );

	if( ( tri >= 3 || quad >= 3 || red >= 3 ) && ( tri >= 1 && quad >= 1 && red >= 1 ) )

		return IGUAIS; /*( this.melhorTroca() );*/

	else if( tri >= 3 || quad >= 3 || red >= 3 )

		return IGUAIS;

	else if( tri >= 1 && quad >= 1 && red >= 1 )

		return DIFERENTES;

	return 0;

}

// escolhe qual o melhor tipo de troca quando os dois são possiveis

Jogador.prototype.melhorTroca = function(){

	qua = trian = circ = 0;

	for( i = 0; i < this.cartas.length; i++){

		if( this.cartas[i].figura == TRIANGULO ){

			if( this.cartas[i].jogador == this)

				meuTri++;

			trian += 1;

		}

		else if( this.cartas[i].figura == QUADRADO ){

			if( this.cartas[i].jogador == this)

				meuQuad++;

			qua++;

		}

		else{

			if( this.cartas[i].jogador == this)

				meuCirc++;

			circ++;

		}

	}

	if( qua >= 2 || trian >= 2 || circ >= 2 );

		return IGUAIS;

	return DIFERENTES;

}

// retorna qual tipo de troca sera realizada, se com cartas igual ou diferentes 

Jogador.prototype.tipoTroca = function(){

	tri = quad = cir = 0;

	for( j = 0; j < this.cartas.length; j++ ){

			if( this.cartas[j].figura == TRIANGULO )

				tri += 1;

			else if( this.cartas[j].figura == QUADRADO )

				quad += 1;

			else

				cir += 1;

		}

		if( cir >= 3 )

			return CIRCULO;

		else if ( tri >= 3 )

			return TRIANGULO;

		else

			return QUADRADO;

}





