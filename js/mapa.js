$(document).ready(function(){
    
    var territorios;
    var label;
    
    function getListaIdTerritorios(){
        setTimeout(function(){
        
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaTerritorios&parm=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    territorios = msg;
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
    
    function getListaLabels(){
        setTimeout(function(){
        
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaLabels&parm=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    label = msg;
                // console.log(msg);
                //                    $.each(msg, function(k, val){/*percorrer json*/
                //                         console.log(val);
                //                    });
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
        console.log('addando...');
        $.each(label, function(k, val){/*percorrer json*/
            var y = $('text#' + val).position().top;
            var x = $('text#' + val).position().left;
           // console.log($('text#' + val).position().top);
            //console.log($('text#' + val).position().left);
            $('<input>').attr('type', 'checkbox')
            .attr('name', 'nome')
            .attr('value', val)
            .css({position: 'absolute', top: y, left: x})
            .appendTo('#inputs');
        });
    }

    inserirMapa(name);
    getListaIdTerritorios();
    getListaLabels();
    
       
    $('path[class=territorio]').live('click', function(){
        desselecinar();
        $(this).addClass('selecionado');
        adicionarCheckbox();
    });
        
    $('path[class=territorio selecionado]').live('click', function(){
        $(this).removeClass('selecionado');
    });
    
    
    
});
