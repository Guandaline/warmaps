Objetivo = function ( defs  ){
	this._init ( defs );
}

Objetivo.prototype._init = function ( defs ){
	this.defs = defs;
}

Objetivo.prototype.melhorJogada = function (jogadas){
    melhor = -1;
    melhor_idx = 0;

    for(k = 0; k < jogadas.length; k++){
		resultado = 0;
		for( prop in this.defs.classificacoes ){
			resultado += jogadas[ k ][ prop ]() * this.defs.classificacoes[ prop ];
			if( resultado > melhor){
				melhor = resultado;
				melhor_idx = k;
			}
		}
    }
	return jogadas[ melhor_idx ];
}


Objetivo.prototype.melhorMovimento = function (movimentos){
  //alert("Passei por aqui ");
//   o que tem em movimentos?



  return movimentos.pop();
}

Objetivo.prototype.melhorPosicao = function ( paises ){
	//alert("a");
	var melhor_idx = 0;
	maior = paises[ 0 ].calculaImportancia();
	
	for(var k = 0; k < paises.length; k++ ){
		importancia = paises[k].calculaImportancia();
		if( importancia > maior){
			maior = importancia;
			melhor_idx = k;
		}
	}

	return paises[ melhor_idx ];
}



Objetivo.prototype.ganhei = function(){
// 	warAlert( [this.defs.tipo, this.defs.parametro] );
	
   return this.testes[ this.defs.tipo ](  this.defs.parametro );
}



Objetivo.prototype.testes = new Object();



Objetivo.prototype.testes.conquistaTerritorios = function( parm ){
//       if( parm == 24 )
	return ( jogo.jogadorAtual.paises.length >= 24);

//       else{
// 	count = 0;
// 
// 	for(i = 0; i < jogo.jogadorAtual.paises.length; i++)
// 	  //if( jogo.jogadorAtual.paises[i].qtdExercitos >= 2)
// 	    count++;
// 
// 	return (count >= 18);
//       }
}

Objetivo.prototype.testes.conquistaContinentes = function( parm ){
      return false;
}

Objetivo.prototype.testes.eliminaJogador = function( parm ){

      return false;
}
