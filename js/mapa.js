$(document).ready(function(){
    
    jQuery.fn.exists = function (){
        return jQuery(this).length > 0 ? true : false;
    };
    
    var territorios;
    var label;
    var lista_vizinhos;
    function getListaIdTerritorios(){
        setTimeout(function(){
        
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaTerritorios&parametros=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    territorios = msg;
                    // console.log(msg);
                    $.each(msg, function(k, val){/*percorrer json*/
                        // console.log(val);
                        $('#' + val).removeAttr('style');
                        $('#' + val).addClass('territorio');
                    });
                },
                async: false
            });
            
        }, 1500);
    }
    
    
    
    function getListaLabels(){
            $.ajax({                       
                context: $(this),
                url: "ajax/ajax.php?controller=territorio&method=getListaLabels&parametros=30",
                success: function(msg) {
                    msg = JSON.parse(msg);
                    label = msg;
                    var l;                    //                 console.log(msg);
                    $.each(msg, function(k, val){/*percorrer json*/
                        l = $('#' + val);
                        span = l.find('tspan');
                        span.text(' ');
                    });
                },
                async: false
            });            
    }
    
    function getListaVizinhos(territorio_id){
        var res;    
        $.ajax({                       
            context: $(this),
            url: "ajax/vizinho.php?func=1&territorio=" + territorio_id,
            success: function(msg) {
                lista_vizinhos = JSON.parse(msg);
            },
            async: false
        });
    }
    
    function inserirMapa(name){
        
        $("#game").svg({      
            
            onLoad: function() {       
                var svg;        
                svg = $("#game").svg('get');        
                svg.load('file/mapas/mapa2.svg', {          
                    addTo: true,          
                    changeSize: true       
                })
                
            },      
            settings: {}
        });
        
    } 
    
    function getTerritorioIdByName(name){
        var res;
        $.each(territorios, function(k, val){
            if(val.substring(2) == name){
                res =  k;
            }            
        });
        return res;
    }
    
    function getTerritorioNameById(id){
        var r = null;
        $.each(territorios, function(k, val){
            //  console.log(val.substring(2) + ' == ' + territorio_name);
            if(id == k){
                r = val.substring(2);
            }            
        });
        return r;
        
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
        var e = $('.territorio.selecionado');
        if(e.exists()){
            var name = getName(e, 2);
            var input = getInput(name);
            if(input != null){
                hiddeAll(input);
            }
            e.removeClass('selecionado');
        }
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
                .attr('id', id)
                .css({
                    position: 'absolute', 
                    top: y, 
                    left: x
                })
                .appendTo('div#inputs');
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
            id = getTerritorioIdByName(name);
            adicionarCheckbox(name);
            getListaVizinhos(id);
            console.log('lista vizinhos ' + lista_vizinhos);
            $.each(lista_vizinhos, function(k , val){
                name_vizinho = getTerritorioNameById(val);
                $('input[name=' + name + ']#' + name_vizinho).attr('checked', true);
            });
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
    
    $('input[type=checkbox]').live('click', function(){
        var e = $(this);
        var territorio_name = e.attr('name');
        var vizinho_name = e.attr('id');
        var t_id, v_id, val;
        val = e.is(':checked');
        $.each(territorios, function(k, val){
            //  console.log(val.substring(2) + ' == ' + territorio_name);
            if(val.substring(2) == territorio_name){
                t_id = k;
            }else{
                if(val.substring(2) == vizinho_name){
                    v_id = k;
                }   
            }
            
        });
        //console.log('t =' + t_id + ' v =' + v_id);
    
        $.ajax({                       
            context: $(this),
            url: "ajax/vizinho.php?func=2&territorio=" + t_id 
            + "&vizinho=" + v_id + '&val=' + val
        });
        
    });
    
});
