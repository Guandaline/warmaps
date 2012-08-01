$(document).ready(function(){
    
    jQuery.fn.exists = function (){
        return jQuery(this).length > 0 ? true : false;
    };
    
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
                        $('#' + val).removeAttr('style');
                        $('#' + val).addClass('territorio');
                    });
                }
            });
            
        }, 1500);
    }
    
    function getListaLabels(){
        setTimeout(function(){
            console.log('text');
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaLabels&parm=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    label = msg;
                    var l;
                    var span;
                    //                 console.log(msg);
                    $.each(msg, function(k, val){/*percorrer json*/
                        //console.log(val);
                        l = $('#' + val);
                        span = l.find('tspan');
                        span.text(' ');
                        console.log(span);
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
    
    function getName(element, pos){
        return element.attr('id').toString().substring(pos);
    }
    
    function getInput(name){
        var input = $('input[name=' + name + ']');
        if(input[0]){
            //console.log(input);
            return input;
        }
        return null
    }
    
    function hiddeAll(element){
        element.each(function(){
            $(this).hide();
        });
    }
    
    function showAll(element){
        element.each(function(){
            $(this).show();
        });
    }
    
    function toggleAll(element){
        element.each(function(){
            $(this).toggle();
        });
    }
   
    function desselecinar(){
        
        $('path').each(function(){
            var classe = $(this).attr('class');
            if(classe == 'territorio selecionado'){
                var name = getName($(this), 2);
                console.log(name);
                var input = getInput(name);
                if(input != null){
                    hiddeAll(input);
                }
                $(this).removeClass('selecionado');
            }
        });
        
    }
    
    function adicionarCheckbox(name){
        var l, t;
        $.each(label, function(k, val){/*percorrer json*/
            l = $('#' + val);
            t = l.find('tspan');
            var y = l.position().top;
            var x = l.position().left;
            var id = getName(l, 2);
            if(name != id){
                $('<input>').attr('type', 'checkbox')
                .attr('name', name)
                .attr('value', id)
                .css({
                    position: 'absolute', 
                    top: y, 
                    left: x
                })
                .appendTo('#inputs');
            }
        });
    }

    inserirMapa(name);
    getListaIdTerritorios();
    getListaLabels();
    
       
    $('.territorio').live('click', function(){
        desselecinar();
        $(this).addClass('selecionado');
        var name = getName($(this), 2);
        var input = getInput(name);
        if(input != null){
            showAll(input);
        }else{
            adicionarCheckbox(name);
        }
    });
        
    $('.territorio.selecionado').live('click', function(){
        $(this).removeClass('selecionado');
        var name = getName($(this), 2);
        var input = getInput(name);
        if(input != null){
            hiddeAll(input);
        }
    });
    
    
    
});
