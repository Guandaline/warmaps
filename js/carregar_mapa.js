$(document).ready(function(){


    function inserirMapa(){
    
        var arq = $('input[name=arquivo]').val();
        $("#game").svg({      
            
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
    console.log('carregar_mapa');    
    inserirMapa();
   
    setTimeout(function(){
        console.log('iniciar....');
        configTerritorio();
        iniciar();
    }, 2000);
    
});