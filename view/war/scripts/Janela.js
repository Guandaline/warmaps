/** class janela  */

Janela = function ( nome, titulo ){
  this._init ( nome, titulo );
}

Janela.prototype._init = function ( nome, titulo ){
  desktop = document.createElement('div');
  desktop.setAttribute('class', 'desktop');

  completa = document.createElement('div');
  completa.setAttribute('class', 'janela redondo');

  this.janela = document.createElement('div');

  this.titulo = document.createElement('h2');
  if(titulo!="Configurações")
  	fechar=' <span style="font-size:9px">[Fechar]</span>';
  else 
  	fechar='';	
  this.titulo.setAttribute('class', 'redondo');
  
  this.titulo.innerHTML = titulo+fechar;

  this.titulo.onclick = function(){ this.parentNode.parentNode.parentNode.removeChild( this.parentNode.parentNode ) }

  completa.appendChild( this.titulo );  
  completa.appendChild( this.janela );

  desktop.appendChild( completa );
  document.getElementById('body').appendChild( desktop );

  this.desktop = desktop;
}

Janela.prototype.fechar =  function (){
  this.desktop.parentNode.removeChild( this.desktop );
}