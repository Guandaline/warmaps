// JavaScript Document 

// FUNÇÃO RESPONSÁVEL DE CONECTAR A UMA PAGINA EXTERNA NO NOSSO CASO A BUSCA_NOME.PHP 

// E RETORNAR OS RESULTADOS 



function ajax(url) 

	{ 



	 //alert(nick); 

	 //alert(dest); 

	 //alert(msg); 

	 //alert(url);



	 req = null; 

	 // Procura por um objeto nativo (Mozilla/Safari) 

	 if (window.XMLHttpRequest) 

	 	{ 

		 req = new XMLHttpRequest(); 

		 req.onreadystatechange = processReqChange;
			
		 req.open("GET",url,true); 

		 req.send(null);
		  

		 // Procura por uma versão ActiveX (IE) 

		} 

	 else if (window.ActiveXObject) 

	 	{ 

		 req = new ActiveXObject("Microsoft.XMLHTTP"); 

		 if (req) 

		 	{ 

			 req.onreadystatechange = processReqChange; 

			 req.open("GET",url,true); 

			 req.send(); 
			 
			} 

		} 

	} 



function processReqChange() 

	{ 

	// apenas quando o estado for "completado" 
	if (req.readyState == 4)

		{ 
		 //alert("completado");

		// apenas se o servidor retornar "OK" 

		if (req.status ==200) 

			{ 
			//alert("ok");

			// procura pela div id="pagina" e insere o conteudo 

			// retornado nela, como texto HTML
			
			if(req.responseText!="")
				{	
				 //document.getElementById('pagina').innerHTML =req.responseText;
				 var str= new String;
				 str=""+(req.responseText)+"";
				 //alert(str);
				 str=str.split("|");
				 i=1;
				 while(str[i])
				 	{
					 str[i]=str[i].split(",");
					 i=i+2;	
					}
				 for(i=0;i<jogo.jogadores.length;i++)
				 	{
					//alert(jogo.jogadores.length+" i = "+ i);		
					 for(x=1;x<str.length;x+=2)
					 	{
						//alert(str[x][0]+" = "+jogo.jogadores[i].nome+" ï= "+ i);	
						 if(str[x][0]==jogo.jogadores[i].nome)
						 	{		
				 	 	 	 jogo.jogadores[i].perfilNome = str[x][2];
					 	 	 jogo.jogadores[i].minAtaque=   str[x][3];
					 	 	 jogo.jogadores[i].minDefesa=   str[x][4];
							 break;
				 		 	  
							 //alert(str[x][0]);
				 		 	 //alert(str[x][0] );
							}
						}
				 	 //alert(str[i][0]+str[i][1]+str[i][2]+str[i][3]+str[i][4]);
				 	 //document.getElementById('pagina').innerHTML =str[1][1];
					}
					
				} 
				

			jogo.jogadores[0].terminou=1;
			//alert(jogo.jogadores[0].terminou);
			} 

		else 

			{ 

			alert("Houve um problema ao obter os dados:" + req.statusText); 

			} 

		} 

	} 



// JavaScript Document