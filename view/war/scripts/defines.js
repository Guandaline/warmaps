JANELA_CONFIG = '<form id="janela_config" onsubmit="jogo.configura(); return false;"> <label>Nome</label> <input type="text" name="nomejogador" /> <br /> <label>Jogadores</label> <select name="qtdjogadores"><option value="3">Três</option> <option value="4">Quatro</option><option value="5">Cinco</option><option value="6">Seis</option> </select> <br /> <label>Cor</label> <select name="cor"> <option value="amarelo">Amarelo</option> <option value="azul">Azul</option> <option value="preto">Preto</option> <option value="verde">Verde</option> <option value="vermelho">Vermelho</option> <option value="branco">Branco</option> </select> <br /> <hr /> <br /> <input type="submit" value="War"/> </form>';



JANELA_ATAQUE = '<form> <label>Exércitos</label> <select name="qtd_jogadores"> <option value="3">Tres</option> <option value="2">Dois</option> <option value="1">Um</option> </select> <br />    <br /> <input type="button" value="Atacar" onclick="jogo.atacar(); this.fechar();"/> </form>'



JANELA_TROCA = '<form> <div> <fieldset class="redondo" > <legend align="center">Escolha as cartas para trocar</legend> <select multiple="multiple" size="5" style="width:100%;" id="select_troca_cartas"></select> </fieldset> </div> <input type="button" value="Trocar" onclick="jogo.jogadorAtual.trocarCartas();"/> </form>';



CORES = ["azul", "amarelo", "vermelho", "preto", "verde", "branco"];



NOMES = ["AI_1", "AI_2", "AI_3", "AI_4", "AI_5"];



// constantes utilizadas para troca de cartas

const QUADRADO = 0, TRIANGULO = 1, CIRCULO = 2;

const cartas_name = new Array('Quadrado', 'Triângulo', 'Circulo');

const DIFERENTES = 1, IGUAIS = 2;



// constantes utilizadas para controlar as etapas da jogada

const DISTRIBUIR = 0, ATACAR = 1, MOVER = 2;





Array.prototype.sequence = function( i , j ){

	for( i = 0; i < j; i++ )

		this.push(i);

}



Array.prototype.aleatory = function (){

  interval = this.length;



  arr = new Array();

  alt = new Array();

  ret = new Array();



  for(i = 0; i < interval; i++)

    arr[ i ] = i;



    while( arr.length ){

      idx = Math.round((Math.random()* (arr.length -1) ));

      alt.push( arr[idx] );

      arr.splice( idx, 1 );

    }



  for(i = 0; i < interval; i++)

    ret[ alt[i] ] = this[i];
	
	
  return ret;
  
  
  

}





function extende(obj, classe){

    for( property in classe.prototype )

	if( !(property in obj) )

	    obj [ property ] = classe.prototype[ property ];

}









var defines = {



// *******************************************************************************************************************



  "continentes" : {

      "africa" : {

	  'valorEstrategico' : 3,

	  'exercitos' : 4,

	  'qtdPaises': 6,

	  'paises' : ['congo', 'sudao', 'egito', 'madagascar', 'argelia', 'africaSul']

      },



      "americaNorte" : {

	  'valorEstrategico' : 4,

	  'exercitos' : 7,

	  'qtdPaises': 10,

	  'paises' : ['alaska', 'vancouver', 'mexico', 'novaYork', 'groenlandia', 'mackenzie', 'ottawa', 'labrador', 'california', 'cuba']

      },



      "americaSul" : {

	  'valorEstrategico' : 2,

	  'exercitos' : 3,

	  'qtdPaises': 4,

	  'paises' : ['uruguai', 'brasil', 'bolivia', 'colombia']

    },



      "asia": {

	  'valorEstrategico' : 1,

	  'exercitos' : 10,

	  'qtdPaises': 12,

	  'paises' : ['aral', 'china', 'india', 'tchita', 'japao', 'vladivostok', 'orienteMedio', 'mongolia', 'vietna', 'dudinka', 'omsk', 'siberia']  

    },



      "europa": {

	  'valorEstrategico' : 4,

	  'exercitos' : 7,

	  'qtdPaises': 7,

	  'paises' : ['inglaterra', 'islandia', 'alemanha', 'suecia', 'polonia', 'moscou', 'franca']

    },



      "oceania": {

	  'valorEstrategico' : 1,

	  'exercitos' : 2,

	  'qtdPaises': 4,

	  'paises' : ['australia', 'sumatra', 'novaGuine', 'borneo']

   }

  },









// *******************************************************************************************************************

// paises

   "paises" : {



// america do sul

      "uruguai": {

	'valorEstrategico' : 2,

	'vizinhos': ['brasil', 'bolivia'],

	'figura' : QUADRADO

      },



      "brasil": {

	'valorEstrategico' : 5,

	'vizinhos': ['uruguai', 'bolivia', 'colombia', 'argelia'],

	'figura' : CIRCULO

      },
      
      "cuba": {

	'valorEstrategico' : 4,

	'vizinhos': ['colombia', 'mexico', 'novaYork'],

	'figura' : CIRCULO

      },



      "bolivia": {

	'valorEstrategico' : 2,

	'vizinhos': ['uruguai', 'colombia', 'brasil'],

	'figura' : TRIANGULO

      },



      "colombia": {

	'valorEstrategico' : 2,

	'vizinhos': ['mexico', 'bolivia', 'brasil', 'cuba'],

	'figura' : TRIANGULO

      },



// // america do norte

      "alaska": {

	'valorEstrategico' : 2,

	'vizinhos': ['vladivostok', 'vancouver', 'mackenzie'],

	'figura' : TRIANGULO

      },



      "vancouver" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['alaska', 'mackenzie', 'ottawa', 'california'],

	'figura' : TRIANGULO

      },



      "mexico" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['novaYork', 'california', 'colombia', 'cuba'],

	'figura' : QUADRADO

      },



      "novaYork" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['california', 'mexico', 'ottawa', 'labrador', 'cuba'],

	'figura' : QUADRADO

      },



      "california" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['vancouver', 'mexico', 'novaYork', 'ottawa'],

	'figura' : QUADRADO

      },



      "groenlandia" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['labrador', 'mackenzie', 'islandia'],

	'figura' : CIRCULO

      }, 



      "mackenzie" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['alaska', 'ottawa', 'vancouver', 'groenlandia'],

	'figura' : CIRCULO

      },



      "ottawa" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['vancouver', 'california', 'novaYork', 'labrador', 'mackenzie'],

	'figura' : CIRCULO

      },



      "labrador" : {

	'valorEstrategico' : 2,

	'vizinhos' : ['ottawa', 'groenlandia', 'novaYork'],

	'figura' : QUADRADO

      },





// africa

      "congo": {

	'valorEstrategico' : 2,

	'vizinhos': ['argelia', 'africaSul', 'sudao'],

	'figura' : QUADRADO

      },



      "sudao": {

	'valorEstrategico' : 2,

	'vizinhos': ['egito', 'africaSul', 'madagascar', 'argelia', 'congo'],

	'figura' : QUADRADO

      },



      "egito": {

	'valorEstrategico' : 2,

	'vizinhos': ['argelia', 'sudao', 'polonia', 'orienteMedio'],

	'figura' : TRIANGULO

      },

      

      "madagascar": {

	'valorEstrategico' : 2,

	'vizinhos': ['sudao', 'africaSul'],

	'figura' : CIRCULO

      },



      "argelia": {

	'valorEstrategico' : 2,

	'vizinhos': ['brasil', 'congo', 'egito', 'sudao', 'franca'],

	'figura' : CIRCULO

      },



      "africaSul": {

	'valorEstrategico' : 2,

	'vizinhos': ['congo', 'sudao', 'madagascar'],

	'figura' : TRIANGULO

      },



// europa

      "inglaterra": {

	'valorEstrategico' : 2,

	'vizinhos': ['islandia', 'franca', 'suecia', 'alemanha'],

	'figura' : CIRCULO

      },



      "islandia": {

	'valorEstrategico' : 2,

	'vizinhos': ['groenlandia', 'inglaterra', 'suecia'],

	'figura' : TRIANGULO

      },



      "alemanha": {

	'valorEstrategico' : 2,

	'vizinhos': ['suecia', 'franca', 'polonia', 'moscou', 'inglaterra'],

	'figura' : CIRCULO

      },



      "suecia": {

	'valorEstrategico' : 2,

	'vizinhos': ['islandia', 'inglaterra', 'alemanha', 'moscou'],

	'figura' : CIRCULO

      },



      "polonia": {

	'valorEstrategico' : 2,

	'vizinhos': ['egito', 'moscou', 'alemanha', 'franca', 'orienteMedio'],

	'figura' : QUADRADO

      },



      "moscou": {

	'valorEstrategico' : 2,

	'vizinhos': ['aral', 'omsk', 'orienteMedio', 'polonia', 'alemanha', 'suecia'],

	'figura' : TRIANGULO

      },



      "franca": {

	'valorEstrategico' : 2,

	'vizinhos': ['argelia', 'alemanha', 'polonia', 'inglaterra'],

	'figura' : QUADRADO

      },





// oceania

      "australia": {

	'valorEstrategico' : 2,

	'vizinhos': ['borneo', 'novaGuine', 'sumatra'],

	'figura' : TRIANGULO

      },



      "sumatra": {

	'valorEstrategico' : 2,

	'vizinhos': ['india', 'australia'],

	'figura' : QUADRADO

      },



      "novaGuine": {

	'valorEstrategico' : 2,

	'vizinhos': ['australia', 'borneo'],

	'figura' : CIRCULO

      },



      "borneo": {

	'valorEstrategico' : 2,

	'vizinhos': ['australia', 'vietna', 'novaGuine'],

	'figura' : QUADRADO

      },



// asia

      "aral": {

	'valorEstrategico' : 2,

	'vizinhos': ['orienteMedio', 'moscou', 'omsk', 'china', 'india'],

	'figura' : TRIANGULO

      },



      "china": {

	'valorEstrategico' : 2,

	'vizinhos': ['aral', 'omsk', 'dudinka', 'mongolia', 'india', 'vietna'],

	'figura' : CIRCULO

      },



      "india": {

	'valorEstrategico' : 2,

	'vizinhos': ['orienteMedio', 'aral', 'vietna', 'china', 'sumatra'],

	'figura' : QUADRADO

      },



      "tchita": {

	'valorEstrategico' : 2,

	'vizinhos': ['dudinka', 'siberia', 'vladivostok', 'mongolia'],

	'figura' : TRIANGULO

      },



      "japao": {

	'valorEstrategico' : 2,

	'vizinhos': ['vladivostok', 'mongolia'],

	'figura' : QUADRADO

      },



      "vladivostok": {

	'valorEstrategico' : 2,

	'vizinhos': ['siberia', 'japao', 'mongolia', 'tchita', 'alaska'],

	'figura' : CIRCULO

      },



      "orienteMedio": {

	'valorEstrategico' : 2,

	'vizinhos': ['india', 'egito', 'aral', 'moscou', 'polonia'],

	'figura' : QUADRADO

      },



      "mongolia": {

	'valorEstrategico' : 2,

	'vizinhos': ['japao', 'dudinka', 'tchita', 'china', 'vladivostok'],

	'figura' : CIRCULO

      },



      "vietna": {

	'valorEstrategico' : 2,

	'vizinhos': ['borneo', 'china', 'india'],

	'figura' : TRIANGULO

      },



      "dudinka": {

	'valorEstrategico' : 2,

	'vizinhos': ['siberia', 'tchita', 'omsk', 'china', 'mongolia'],

	'figura' : CIRCULO

      },



      "omsk": {

	'valorEstrategico' : 2,

	'vizinhos': ['moscou', 'aral', 'dudinka', 'china'],

	'figura' : QUADRADO

      },



      "siberia": {

	'valorEstrategico' : 2,

	'vizinhos': ['dudinka', 'vladivostok', 'tchita'],

	'figura' : TRIANGULO

      }

   } 

}





/************************************** OBJETIVOS   *******************************************/



defines.objetivos = [

		{'name' : "destruir amarelos",

		 'tipo' : "eliminaJogador",    /*Objetivo.ganheiTeste[ destruir_jogador ]( parametro );*/

		 'parametro': 'amarelo',

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},		 

		

		{'name' : "destruir azuis",

		  'tipo' : "eliminaJogador",

		  'parametro' : "azul",

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},





		{'name' : "destruir brancos",

		  'tipo' : "eliminaJogador",

		  'parametro' : "branco",

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},		 



		{'name' : "destruir verdes",

		  'tipo' : "eliminaJogador",

		  'parametro' : "verde",

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},





		{'name' : "destruir vermelhos",

		  'tipo' : "eliminaJogador",

		  'parametro' : "vermelho",

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},		 

		

		{'name' : "destruir pretos",

		  'tipo' : "eliminaJogador",

		  'parametro' : "preto",

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},



/*

		{'name' : "conquistar asia e africa",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["asia"], ["africa"] ],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},		 

		

		{'name' : "conquistar americaNorte e oceania",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["americaNorte"], ["oceania"] ],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},





		{'name' : "conquistar americaNorte e africa",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["americaNorte"], ["africa"] ],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},		 

		

		{'name' : "conquistar asia e americaSul",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["asia"], ["americaSul"] ],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},





		{'name' : "conquistar europa americaSul e outro",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["europa"], ["americaSul"], ["americaNorte","africa","asia","oceania"]],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},

		

		{'name' : "conquistar europa oceania e outro",

		  'tipo' : "conquistaContinentes",

		  'parametro' : [ ["europa"], ["oceania"], ["americaNorte","africa","asia","americaSul"]],

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},*/

		

		{'name' : "conquistar 18 territorios com 2 exercitos",

		  'tipo' : "conquistaTerritorios",

		  'parametro' : 18,

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},

		

		{'name' : "conquistar 24 territórios",

		  'tipo' : "conquistaTerritorios",

		  'parametro' : 24,

		'classificacoes' : {

			'conquistarcontinente' : 0.5,

			'conquistafacil' : 0.9,

			'tomarcontinente' : 0.5

		}},

]

