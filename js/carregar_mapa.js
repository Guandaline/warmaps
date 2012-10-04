/**
 *Contem a função para carregar o mapa via jquery
 **/

$(document).ready(function(){

    /**
     *Insere o mapa na pagina
     **/
    function inserirMapa(){
    
        var arq = $('input[name=arquivo]').val();
        /*Pega o nome do arquivo*/
        $("#game").svg({      
            /*le o arquivo e insere na div#game*/
            onLoad: function() {       
                var svg;        
                svg = $("#game").svg('get');        
                svg.load('file/mapas/' + arq, {          
                    addTo: true,          
                    changeSize: true       
                })
                
            },      
            settings: {}
        });
        
    } 
    
    inserirMapa();
   
    setTimeout(function(){
        configTerritorio();
        iniciar();
    }, 3000);
    
});