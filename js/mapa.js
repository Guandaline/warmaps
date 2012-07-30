$(document).ready(function(){
    
    function getListaIdTerritorios(){
        setTimeout(function(){
        
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaTerritorios&parm=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    // console.log(msg);
                    $.each(msg, function(k, val){/*percorrer json*/
                        // console.log(val);
                        $('path#' + val).removeAttr('style');
                        $('path#' + val).addClass('territorio');  
                    });
                }
            });
            
        }, 1500);
    }
    
    function inserirMapa(name){
        
        $("#game").svg({      
            onLoad: function() {       
                var svg;        
                svg = $("#game").svg('get');        
                svg.load('file/mapas/mapa2.svg', {          
                    addTo: true,          
                    changeSize: false        
                })
                
            },      
            settings: {}
        });
        
    } 
   
    function desselecinar(){
        
        $('path').each(function(){
            var classe = $(this).attr('class');
            if(classe == 'territorio selecionado'){
                $(this).removeClass('selecionado');
            }
        });
        
    }
    
    function adicionarCheckbox(){
        
    }

    inserirMapa(name);
    getListaIdTerritorios();
        
       
    $('path[class=territorio]').live('click', function(){
        desselecinar();
        $(this).addClass('selecionado');
    });
        
    $('path[class=territorio selecionado]').live('click', function(){
        $(this).removeClass('selecionado');
    });
    
    
    
});
