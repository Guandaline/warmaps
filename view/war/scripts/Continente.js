/** class Continente*/

Continente = function (name){

  this._init (name);

}



Continente.prototype._init = function (name){
    
  
  this.nome = name;

  this.paises = new Object();

  

  for(i = 0; i < defines.continentes[ name ].paises.length; i++){

      this.paises[ defines.continentes[ name ].paises[i] ] = new Pais( defines.continentes[ name ].paises[i], this);

  }



  this.qtdExercitos = defines.continentes[ name ].exercitos;

  this.qtdPaises = defines.continentes[ name ].qtdPaises;



}







