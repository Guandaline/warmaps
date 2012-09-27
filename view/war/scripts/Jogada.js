Jogada = function (){
	this._init();
}

Jogada.prototype._init = function (){

}

Jogada.prototype.pros = function (){
  
}

Jogada.prototype.contras = function (){
  
}

Jogada.prototype.probabilidadeGanho = function (){
  
}

Jogada.prototype.pondera = function (){
  
}

Jogada.prototype.jogar = function (){
	jogo.selecionado = this.origem;
	jogo.atacado = this.destino;
	jogo.atacar();
}


Jogada.prototype.conquistarcontinente = function(){
	falta = 0;

	for( prop in this.destino.continente.paises )
		if( this.destino.continente.paises[ prop ].jogador == this.origem.jogador )
			falta++;
		
	if( falta + 1 == this.destino.continente.qtdPaises )
		return 10;

	return 0;
}

Jogada.prototype.conquistafacil = function( ){
    if( this.destino.qtdExercitos < this.origem.qtdExercitos )
		return( ( this.origem.qtdExercitos - this.destino.qtdExercitos ) / 10 );
    else
		return 0.1;
}

Jogada.prototype.tomarcontinente = function(){
	dono = 0;
	for( prop in this.destino.continente.paises )
		if( this.destino.continente.paises[ prop ].jogador == this.origem.jogador )
			dono++;
	
	if( dono == this.destino.continente.qtdPaises )
	    return 10;
	else if( dono + 1 == this.destino.continente.qtdPaises )
	    return 5;
	else
	    return 0;
}


Jogada.prototype.toString  = function(){
  return "[Object Jogada]";
}