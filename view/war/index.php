<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>Jogo De WAR</title>

        <link rel="stylesheet" type="text/css" href="view/war/estilos/estilo.css" />
        <link rel="stylesheet" type="text/css" href="view/war/estilos/game.css" />

        <script src="view/war/scripts/defines.js"></script>
        <script src="js/new_define.js"></script>
        <script src="js/configura.js"></script>
        
        <script src="view/war/scripts/AI.js"></script>
        <script src="view/war/scripts/Carta.js"></script>
        <script src="view/war/scripts/Continente.js"></script>
        <script src="view/war/scripts/Humano.js"></script>
        <script src="view/war/scripts/Janela.js"></script>
        <script src="view/war/scripts/Jogador.js"></script>
        <script src="view/war/scripts/Jogo.js"></script>
        <script src="view/war/scripts/Mapa.js"></script>
        <script src="view/war/scripts/Monte.js"></script>
        <script src="view/war/scripts/Objetivo.js"></script>
        <script src="view/war/scripts/Jogada.js"></script>
        <script src="view/war/scripts/Pais.js"></script>
        <script src="view/war/scripts/script.js"></script>
        <script src="view/war/scripts/grafo.js"></script>

        <script src="js/carregar_mapa.js"></script>
        
         <script src="view/war/scripts/main.js"></script>

    </head>

  
    <body id="body">
        <input type="hidden" value="<?php echo $nome; ?>" name="arquivo"/>
        <div style="text-align: center;">
                <button id="setaCartas">Trocar Cartas</button> 
                <button id="setaMover">Mover Tropas</button>
                <button id="setaAvancar">Terminar turno</button>
            </div>

        <div id="terminal" class="prompt" 
             style="position:fixed; bottom: 0px; left: 0px; width: 20%; height: 35%; 
             background-color: black; color: white; padding: 5px; overflow:auto;" >

            Terminal.

            <hr />

        </div>

        <div  class="page redondo" >
            <div id="game" >

            </div>
            
        </div>

    </body>

</html>