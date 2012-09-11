const MAXINT = 999999;

Node = function( node ){
    this._init( node );
}

Node.prototype._init = function( node ){
	this.nome = node.nome;
	this.vizinhos = node.vizinhos;
}


Node.prototype.teste = function(){
    warAlert("se funcionar tem cerveja");
}


Node.prototype.pathTo = function( node ){
    this.grafo.calcDistances( node );
    
    prox = cross = this;
    path = new Array();
    
    while( cross != node ){
	path.push( cross.nome );
	
	menor = MAXINT;    
	
	for( p in cross.links )
	    if( cross.links[p].distance < menor ){
		menor = cross.links[p].distance;
		prox = cross.links[p];
	    }
	    
	cross = prox;
    }
	
    path.push( node.nome );
    return path;
}

Grafo = function(){
    this._init();  
}

Grafo.prototype._init = function(){
    this.nodes = Object();
}

// Indexa conforme os objetos são inseridos
Grafo.prototype.appendNode = function( node ){    
    this.nodes[ node.nome ] = node;
    node.grafo = this;
    node.links = new Object();

    for(i = 0; i < node.vizinhos.length; i++){
	if( this.nodes[ node.vizinhos[i].nome ] ){
	    node.links[ node.vizinhos[i].nome ] = this.nodes[ node.vizinhos[i].nome ];
	    this.nodes[ node.vizinhos[i].nome ].links[ node.nome ] = node;
	}
    }
    
    return node;
}


// Calcula a distância de todos os elementos para nó e armazena no atributo distance
Grafo.prototype.distanceOf = function ( node ){
    if( !node.closed ){	
	node.closed = true;
	
	menor = MAXINT;
	
	for( prop in node.links ){
		if( node.links[prop].distance > (node.distance + 1) )
		    node.links[prop].distance = node.distance + 1;
	}
	
	for( prop in node.links )
	    this.distanceOf( node.links[prop] );
	    
    }
}



Grafo.prototype.calculaDistanciaFronteira = function( node ){
    
    for(prop in this.nodes){	
	this.nodes[ prop ].closed = false;
	this.nodes[ prop ].path = new Array();
	this.nodes[ prop ].distance = MAXINT;
    }
    
    node.distance = 0;
    node.path.push( node );
    this.distanceOffronteira( node );

}



Grafo.prototype.distanceOffronteira= function( node ){
    if( !node.closed && node.jogador != jogo.jogadorAtual ){	
	node.closed = true;
	
	menor = MAXINT;
	
	for( prop in node.links ){
	    if( node.links[prop].distance > (node.distance + 1) )
		node.links[prop].distance = node.distance + 1;
	}
	
	for( prop in node.links )
	    this.distanceOffronteira( node.links[prop] );
    }
}




// Cria os atributos necessários para a operação de busca por nó
Grafo.prototype.calcDistances = function( node ){
    
    for(prop in this.nodes){	
	this.nodes[ prop ].closed = false;
	this.nodes[ prop ].path = new Array();
	this.nodes[ prop ].distance = MAXINT;
    }
    
    node.distance = 0;
    node.path.push( node );
    this.distanceOf( node );
}

// Imprime o grafo como string
Grafo.prototype.toString = function(){
    ret = new String();
    
    for(prop in this.nodes ){
	ret += prop + " [";
	
	for( aux in this.nodes[prop].links )
	    ret += aux  + " - ";
	
	ret += "]\n";
    }
    
    return ret;
}

// g = new Grafo();
// 
// g.appendNode( new Node({'nome' : 'a', 'vizinhos' : ['b', 'c', 'd'] } ));
// g.appendNode( new Node({'nome' : 'b', 'vizinhos' : ['a', 'c', 'e', 'h'] } ));
// g.appendNode( new Node({'nome' : 'c', 'vizinhos' : ['a', 'b', 'd', 'e', 'f', 'g'] } ));
// g.appendNode( new Node({'nome' : 'd', 'vizinhos' : ['a', 'c', 'g'] } ));
// g.appendNode( new Node({'nome' : 'e', 'vizinhos' : ['b', 'c', 'f', 'h'] } ));
// g.appendNode( new Node({'nome' : 'f', 'vizinhos' : ['c', 'e', 'g'] } ));
// g.appendNode( new Node({'nome' : 'g', 'vizinhos' : ['d', 'c', 'f'] } ));
// g.appendNode( new Node({'nome' : 'h', 'vizinhos' : ['b', 'e', 'i'] } ));
// g.appendNode( new Node({'nome' : 'i', 'vizinhos' : ['h', 'j', 'l'] } ));
// g.appendNode( new Node({'nome' : 'j', 'vizinhos' : ['i', 'l', 'm'] } ));
// g.appendNode( new Node({'nome' : 'l', 'vizinhos' : ['i', 'j', 'm'] } ));
// g.appendNode( new Node({'nome' : 'm', 'vizinhos' : ['l', 'j'] } ));

//warAlert( g.nodes.g.pathTo( g.nodes.b ) );