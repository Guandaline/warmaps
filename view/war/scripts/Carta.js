
Baralho = function(){
    this._init();
}

Baralho.prototype._init = function(){
    this.qtdExercitos = 2;

    this.cartas = new Array();
    this.monte = new Array();
    
    for(prop in defines.paises)
		this.cartas.pop( defines.paises[prop].instancia );

    this.cartas = this.cartas.aleatory();
}


Baralho.prototype.pegarCarta = function(){

    if( this.cartas.length == 0){
		this.cartas = this.monte.aleatory();
		this.monte = new Array();
	}
    return this.cartas.pop();
}

Baralho.prototype.trocaCarta = function( cartas ){
    this.monte.concat(cartas);

    this.qtdExercitos+=2;
    return this.qtdExercitos;
}

/** cartas de paises da asia*/
// aral = triangulo
// india = quadrado
// siberia = triangulo
// china = circulo
// dudinka = circulo
// orienteMedio = quadrado
// japao = quadrado
// mongolia = circulo
// tchita = triangulo
// omsk = quadrado
// vietna = triangulo
// vladivostok = circulo


/** cartas de paises da oceania*/
// novaGuine = circulo
// australia = triangulo
// sumatra = quadrado
// borneo = quadrado


/** cartas de paises da africa*/
// argelia = circulo
// congo = quadrado
// egito = triangulo
// sudao = quadrado
// madagascar = circulo
// africaSul = triangulo

/** cartas de paises da europa*/
// polonia = quadrado
// franca = quadrado
// moscou = triangulo
// alemanha = circulo
// inglaterra = circulo
// suecia = circulo
// islandia = triangulo

/** cartas de paises da americaNorte*/
// mackenzie = circulo
// groenlandia = circulo
// alaska = triangulo
// labrador = quadrado
// ottawa = circulo
// vancouver = triangulo
// novaYork = triangulo
// california = quadrado
// mexico = quadrado

/** cartas de paises da americaSul*/
// argentina = quadrado
// colombia = triangulo
// brasil = circulo
// chile = triangulo











