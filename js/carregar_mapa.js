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
    inserirMapa();
   
    setTimeout(function(){
        configTerritorio();
        iniciar();
    }, 2000);
    
});