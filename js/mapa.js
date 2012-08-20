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
                        $('#' + val['name']).removeAttr('style');
                        $('#' + val['name']).addClass('territorio')
                                    .attr('id', k)
                                    .attr('name', val['name'].toString().substring(2))
                                    .attr('reg', val['reg']);
                    });
                    console.log('dispara evento');
                    $('a[name=cores]').click();
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
                        l.addClass('label').attr('id', k).attr('name', val);
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
   
    function desselecionar(){
        var e = $('.territorio.selecionado');
        if(e.exists()){
            var name = e.attr('id');
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
            l = $('[name='+ val +'].label');
            t = l.find('tspan');
            var y = l.position().top;
            var x = l.position().left;
            var id = $('[name='+ val.toString().substring(2) +'].territorio').attr('id');
            if(name != id){
                $('<input>').attr('type', 'checkbox')
                .attr('name', name)
                .attr('id', id)
                /*.addClass(id)*/
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
        desselecionar();
        $(this).addClass('selecionado');
        var name = getName($(this), 0);
        var input = getInput(name);
        if(input != null){
            showAll(input);
        }else{
            id = $(this).attr('id');
            adicionarCheckbox(name);
            getListaVizinhos(id);
            console.log('lista vizinhos ' + lista_vizinhos);
            $.each(lista_vizinhos, function(k , val){
                name_vizinho = val;
                console.log('input[name=' + name + '] #' + name_vizinho);
                $('input[name=' + name + '][id=' + name_vizinho + ']').attr('checked', true);
            });
        }
    });
        
    $('.territorio.selecionado').live('click', function(){
        $(this).removeClass('selecionado');
        var name = $(this).attr('id');
        var input = getInput(name);
        if(input != null){
            hiddeAll(input);
        }
    });
    
    $('input[type=checkbox]').live('click', function(){
        var e = $(this);
        var t_id = e.attr('name');
        var v_id = e.attr('id');
        var val = e.is(':checked');
   
        $.ajax({                       
            context: $(this),
            url: "ajax/vizinho.php?func=2&territorio=" + t_id 
            + "&vizinho=" + v_id + '&val=' + val
        });
        
    });
    
});
