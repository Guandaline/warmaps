// /*** class Jogo  */



function insere(tipo,valor1,valor2,valor3,valor4) 
{ 

    //FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX 

    //alert(valor3);

    pagina = window.location.href;

    var str= new String(pagina);

    pagina=str.replace("war.xhtml","scripts/banco.php");

    //alert(pagina);

    //alert(str2);

    url=pagina+"?tipo="+tipo+"&valor1="+valor1+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+valor4; 
    //alert(url);
    ajax(url);

//alert(atacado);

} 



Jogo = function (){
	
    this._init ();

}





Jogo.prototype._init = function (){
    
    //alert('jogoooooo');

    this.baralho = new Array();

    this.monte = new Array();

    this.qtdExercitosTroca = 2;

    this.kabo = false;

    this.jogada = 0;

    this.selecionado = "";

    this.atacado = "";

    this.continentes = new Array();

    this.jogadores = new Array(); 

    this.janelaConfig = "";

    this.config = new Object();

    this.jogadorAtual = new Object();

    this.flag = 0; // variavel que controla o status do jogo (distribuindo, atacando, movendo) 0 = distribuindo; 1 = atacando; 2 = movendo;

    

  //  this.jogadorAtualLabel = document.getElementById('jogadorAtualLabel');

    

    for(continente in defines.continentes)

        this.continentes.push( defines.continentes[ continente ].instancia = new Continente( continente ) );
            
    for(continente in defines.continentes)

        for(pais in defines.continentes[continente].instancia.paises )

            defines.continentes[continente].instancia.paises[pais].relacionarVizinhos();



    this.configuraWindow();

   

    this.grafo = new Grafo();

   

    for( p in defines.paises )

        this.grafo.appendNode( defines.paises[p].instancia );

}



Jogo.prototype.configuraWindow = function (){


    this.janelaConfig = new Janela('configuracao', 'Configurações');

    this.janelaConfig.janela.innerHTML = JANELA_CONFIG;
    
              

}



Jogo.prototype.configura = function (){
    form = document.getElementById('janela_config');
    for( i = 0; i < form.elements.length; i++)
        this.config[ form.elements[i].name ] = form.elements[i].value;
    this.janelaConfig.titulo.innerHMTL = this.config.nomejogador;
    this.janelaConfig.fechar();
    insere(0,0,this.config.qtdjogadores,0,0);
    //alert("jogo");
    for( i = 0; i < CORES.length; i++)
        if( CORES[i] == this.config.cor ){
            CORES.splice(i, 1);
            break;
        }
    humano = new Humano();
    // humano=new AI();
    humano.cor = this.config.cor;
    this.jogadores.push( humano );
    this.jogadores[0].nome = this.config.nomejogador;
    this.jogadores[0].flagDist = 0;
    this.jogadores[0].cartas = new Array();
    this.jogadores[0].conquisteiCarta = false;	
    this.jogadores[0].perfilNome="Indeterminado";	
    this.jogadores[0].minAtaque=1;
    this.jogadores[0].minDefesa=1;
    this.jogadores[0].terminou=1;		
    insere(2,this.jogadores[0].nome,0,0,0); 
    //alert("jogador humano");
    //alert(this.jogadores[0].nome);
    CORES = CORES.aleatory();
    for( i = 1; i < this.config.qtdjogadores; i++){
        this.jogadores.push( new AI() );
        this.jogadores[i].cor = CORES[i-1];		
        this.jogadores[i].perfil_nome ="x" ;				
        this.jogadores[i].nome = NOMES[i-1];
        this.jogadores[i].flagDist = 0;
        this.jogadores[i].conquisteiCarta = false;
        this.jogadores[i].cartas = new Array();		
        this.jogadores[i].perfilNome="Indeterminado";
        this.jogadores[i].minAtaque=1;	
        this.jogadores[i].minDefesa=1;
        insere(2,this.jogadores[i].nome,0,0,0);
    //alert("jogador maquina");
    }
    //this.jogadores = this.jogadores.aleatory();
    //primeiro=this.jogadores[0].nome;
    this.sorteiaTerritorios();
    this.sorteiaObjetivos(); 
    warAlert(" Iniciando o jogo ");		
    this.distribuiExercitosInicio();
}



Jogo.prototype.sorteiaTerritorios = function (){

    this.baralho = new Array();

    jx = 0;   



    for( pais in defines.paises )

        this.baralho[ jx++ ] = defines.paises[ pais ].instancia;

    

    this.baralho = this.baralho.aleatory();

    

    loc = jx = 0;

    

    for( i = 0; i < this.baralho.length; i++ ){

        loc = jx++ % this.jogadores.length;

        if( this.jogadores[ loc ] ){

            this.jogadores[ loc ].paises.push( this.baralho[ i ] );

            this.baralho[ i ].jogador = this.jogadores[ loc ];

            this.baralho[ i ].pintar();

        }

        else confirm('deu pau em -->' + loc);

    }

}



Jogo.prototype.distribuiExercitosInicio = function (){



    if( this.jogada < this.jogadores.length ){

        this.jogadorAtual = this.jogadores[ this.jogada ];

        this.jogadores[ this.jogada++ ].distribuiExercitosInicio();

    }

    else

        this.jogar();

}



Jogo.prototype.jogar = function (){

    /*	
     for (h=0;h<this.jogadores.length;h++)
	 	{
		 alert(this.jogadores[h].paises.length);
		 for(c=0;c<this.jogadores[h].paises.length;c++)
		 	{
			  	alert(this.jogadores[h].nome + " => "+this.jogadores[h].paises[c].nome+" = "+this.jogadores[h].paises[c].qtdExercitos);
			}
		}*/
    if( !this.kabo ){

        idx = this.jogada++ % this.jogadores.length;
        //alert(this.jogadores[idx].paises.length);
        /*
		if( this.jogadores[idx].paises.length < 1 )
					{

					warAlert( "Jogador " + this.atacado.jogador.cor + " esta eliminado do jogo ");

					this.eliminarJogador();
					idx = this.jogada++ % this.jogadores.length;

					}
		*/			
        //alert(idx);
        //alert("jogador="+this.jogadores[idx].nome+"primeiro="+primeiro);
        if(idx==0)

        { 
            //alert("rodada");

            //warAlert("Nova rodada");
            //alert (primeiro+"2");
            this.jogadores[0].terminou=0;
            insere(3,0,0,0,0);
            // while(this.jogadores[idx].terminou!=0)
            insere(5,0,0,0,0);	

        }

        this.jogadorAtual = this.jogadores[ idx ];

       // this.jogadorAtualLabel.textContent = this.jogadorAtual.nome +"  ->  "+ this.jogadorAtual.cor +" -> " +this.jogadorAtual.perfilNome; 

		

        /* for para gerar um espaçamento entre as jogados (somente para facilitar a verificação da jogada / deve ser retirado )*/

        for( i = 0; i < 10; i++ )

            warAlert( ' ' );

		

        this.jogadores[ idx ].flagDist = 0;

        this.jogadores[ idx ].idxCont = 0;

        this.jogadores[ idx ].conquisteiCarta = false;

        //alert( this.jogadores[ idx ].cor + " vai jogar" );

        this.jogadores[ idx ].jogar();

    }

    else{

        this.finaliza();

    }



}



Jogo.prototype.eliminarJogador = function(){

    //pos = this.jogada++ % this.jogadores.length;
    //warAlert("Entrou");
    for(pos=0;pos<this.jogadores.length;pos++)
    {
        //warAlert(pos);	
        if(this.jogadores[pos].paises.length<1)
        {
            warAlert("Excluindo o = "+ this.jogadores[pos].nome+"da cor = "+this.jogadores[pos].cor+" da posicao = "+ pos );
            //warAlert("jogadores = "+this.jogadores.length);
            this.jogadores.splice(pos,1);
        //warAlert("jogadores = "+this.jogadores.length);
        }
    }

}





Jogo.prototype.atacar = function(){

    atk = ( this.selecionado.qtdExercitos > 3 ) ? 3 : this.selecionado.qtdExercitos -1;

    def = ( this.atacado.qtdExercitos > 3 ) ? 3 : this.atacado.qtdExercitos;



    this.batalha(atk,def);

}



Jogo.prototype.batalha = function(ataque, defesa){

    // 	warAlert( this.selecionado.jogador.cor + " " + this.selecionado.nome + " ataca com " + ataque + '\n' + this.atacado.jogador.cor + " " + this.atacado.nome + " defende com " + defesa );

    var j;

    dadosAtaque = new Array();

    dadosDefesa = new Array();

	

    for(j = 0; j < ataque; j++)

        dadosAtaque.push( Math.floor(Math.random() * 6) + 1); 

    

    for(j = 0; j < defesa; j++)

        dadosDefesa.push( Math.floor(Math.random() * 6) + 1);



    dadosAtaque.sort().reverse();

    dadosDefesa.sort().reverse();

		

    //alert( " Ataque " + this.selecionado.jogador.cor + " -> " + this.selecionado.nome + " <--> " + [dadosAtaque] + '\n' + " Defesa " + this.atacado.jogador.cor +" -> " + this.atacado.nome +  " <--> " + [dadosDefesa] );

    //insere(this.selecionado.jogador.nome,this.atacado.jogador.nome,0,0,0,4);

    insere(1,this.selecionado.jogador.nome,this.atacado.jogador.nome,this.selecionado.qtdExercitos,this.atacado.qtdExercitos);
    insere(5,0,0,0,0);	
   // this.jogadorAtualLabel.textContent = this.jogadorAtual.nome +"  ->  "+ this.jogadorAtual.cor +"->" +this.jogadorAtual.perfilNome; 
       
	   
    a = ((ataque - defesa) > 0) ? defesa: ataque ;

		

    //warAlert( " this.selecionado.jogador.nome" );

    //warAlert( " this.atacado.jogador.nome" );

	

	 

    /*for(i=0;i<6;i++)

	 	{

			

	 		if(jogo.jogadorAtual.isMyContinente( jogo.continentes[i]))

				{

					y++;

					x[y]=(jogo.continentes[i].nome);

					

				}

		}*/

		

    //alert("exercitos="+numero_exercitos+" paises="+numero_paises+" continetes="+numero_continetes);

    warAlert( " " );

    warAlert( this.atacado.nome + " DEFENDE com  >> " + dadosDefesa );

    warAlert( this.selecionado.nome + " ATACA com >> " + dadosAtaque );

    //warAlert( this.selecionado.jogador.nome);

    //warAlert( this.atacado.jogador.nome);

    //warAlert( dadosAtaque);

    warAlert( " " );

    warAlert( " " );

    warAlert( " " );

    warAlert( " " );

    warAlert( " " );





    for( j = 0; j < a; j++ ){

        if( dadosAtaque[j] > dadosDefesa[j] ){

            this.atacado.qtdExercitos--;

			

            if( this.atacado.qtdExercitos == 0)
            { //atacado perdeu territorio


                if( !this.jogadorAtual.conquisteiCarta )
                {

                    this.darCarta();
                } 

				

                if( this.jogadorAtual.tipo == "Humano")
                {
                    do
                    {
                        transfere = parseInt( prompt("Digite a quantidade de ex�rcitos que deseja mover para o território conquistado | máximo = " + ataque ) );

                    }
                    while(transfere > ataque || transfere < 1 || isNaN( transfere ));

                }

                else
                    transfere = ataque;

                this.selecionado.jogador.paises.push( this.atacado );

                for( k = 0; k < this.atacado.jogador.paises.length; k++ )
                {
                    if( this.atacado.jogador.paises[k] == this.atacado )
                    {
                        //warAlert("Eliminado pais");
                        this.atacado.jogador.paises.splice( k , 1);
                        break;
                    }
                }	
			 
			 
                if( this.atacado.jogador.paises.length < 1 )
                {
                    warAlert( "Jogador " + this.atacado.jogador.cor + " esta eliminado do jogo ");
                    this.eliminarJogador();
                    warAlert("Jogador");
                }
                this.atacado.jogador = this.jogadorAtual;
                this.atacado.qtdExercitos = transfere;
                this.selecionado.qtdExercitos-= transfere;
                this.atacado.pintar();
            }

        }

        else

            this.selecionado.qtdExercitos--;


		
        this.atacado.atualizaExercitosMapa();

        this.selecionado.atualizaExercitosMapa();

    }
	
    numero_paises=this.selecionado.jogador.paises.length;
				
    numero_exercitos=this.calc_exercitos();

    numero_continetes=this.calc_continentes();
		
    //alert("exercitos="+numero_exercitos+" paises="+numero_paises+" continetes="+numero_continetes);	
    insere(4,numero_exercitos,numero_paises,numero_continetes,this.selecionado.jogador.nome);

}



Jogo.prototype.calc_exercitos=function()
{

    total_exercitos=0;	

    for(i=0;i<this.selecionado.jogador.paises.length;i++)

    {

            total_exercitos+=this.selecionado.jogador.paises[i].qtdExercitos;

        //alert(total_exercitos+"pais="+this.selecionado.jogador.paises[i].nome);

        }

		

    return 	total_exercitos;

}





Jogo.prototype.calc_continentes = function()

{

        var x= new Array();

        var y=0;

        for(i=0;i<6;i++)

        {

			

                if(jogo.jogadorAtual.isMyContinente( jogo.continentes[i]))

                {

					

                    x[y]=(jogo.continentes[i].nome);

                    y++;

					

                }

            }

        return y;

    }



Jogo.prototype.darCarta = function(){

    if( this.baralho.length == 0 ){

        this.baralho = this.monte.aleatory();

        this.monte = new Array();

    }

    this.jogadorAtual.conquisteiCarta = true;

    this.jogadorAtual.cartas.push( this.baralho[ this.baralho.length - 1 ] );

    this.baralho.splice( this.baralho.length - 1, 1);

}



Jogo.prototype.sorteiaObjetivos = function(){

    defines.objetivos = defines.objetivos.aleatory();

    this.objetivos = new Array();

	

    for( i = 0; i < this.jogadores.length; i++ ){

        this.objetivos[i] = this.jogadores[i].objetivo = new Objetivo( defines.objetivos[i] );
        
        // console.log('l = ' + this.jogadores.length + ' i = '+ i + ' = ' + this.jogadores[i].objetivo );
        
        if( this.jogadores[i].tipo == "Humano" ){
            //   console.log('Seu objetivo á a conquista!');
            obj = " Seu objetivo é " + this.jogadores[i].objetivo.defs.name ;
        } 
        
    }
    
    alert( obj);


}



Jogo.prototype.finaliza = function(){

    confirm( "Aqui acabou o jogo de verdade " + [ this.jogadorAtual.cor, this.jogadorAtual.nome ]	+ "  Venceu o objetivo " + this.jogadorAtual.objetivo.defs.name );
    window.location=window.location.href;

    this._init();

}