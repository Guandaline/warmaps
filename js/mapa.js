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
                    var tspan;
                    //                 console.log(msg);
                    $.each(msg, function(k, val){/*percorrer json*/
                        //console.log(val);
                        l = $('#' + val);
                        tspan = l.find('tspan');
                        tspan.text(' ');
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
        var l;
        $.each(label, function(k, val){/*percorrer json*/
            l = $('#' + val);
            var y = l.position().top;
            var x = l.position().left;
            var id = getName(l, 2);
            // l.hide();
            //console.log(id);
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
        console.log($('input'));
    });
    
    $('input[type=checkbox]').live('click', function(){
        var e = $(this);
        var territorio_name = e.attr('name');
        var vizinho_name = e.attr('id');
        var t_id, v_id;
        
        console.log('click');
        
        $.each(territorios, function(k, val){
          //  console.log(val.substring(2) + ' == ' + territorio_name);
            if(val.substring(2) == territorio_name){
                t_id = k;
                console.log('t =' + t_id);
            }else{
                if(val.substring(2) == vizinho_name){
                    v_id = k;
                    console.log('v =' + v_id);
                }   
            }
            
        });
        //console.log('t =' + t_id + ' v =' + v_id);
    /*
        $.ajax({                       
            context: $(this),
            url: "ajax/ajax.php?controller=territorio&method=getListaTerritorios&parm=30",
            success: function(msg) {
                msg = JSON.parse(msg);
            }
        });
        */
    });
    
});
