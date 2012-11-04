$(document).ready(function(){
    
    /**
     *Função para verificar se um elemento existe
     **/
    jQuery.fn.exists = function (){
        return jQuery(this).length > 0 ? true : false;
    };
    mapa = $("#id_mapa").val();
    var territorios; /*lista de dettirórios*/
    var label; /*lista de labels*/
    var lista_vizinhos; /*lista de vizinhos - muda de acordo com o território selecionado*/
    var aut = {};/*lita de territorios com suas posições e dimensões no mapa*/
    var svg; /*SVG*/
    /*Pega lista de Territórios*/
    function getListaIdTerritorios(){
        /*Aguarda um tempo para que o mapa seja carregado*/    
        /*pega os territórios via ajax*/
        $.ajax({                       
            context: $(this),
            url: "ajax/territorio.php?func=2&id_mapa="+mapa,
            success: function(msg) {
                msg = JSON.parse(msg);
                territorios = msg;/*pega o resultado*/
                    
                $.each(msg, function(k, val){/*percorrer json*/
                    /*remove o estulo de todos os territórios*/
                    $('#' + val['name']).removeAttr('style');
                    /*Adciona a classe e as configurações do território*/
                    $('#' + val['name']).addClass('territorio')
                    .attr('id', k) /*adciona o id do territorio*/
                    .attr('name', val['name'].toString()) /*adiciona o nome do territorio*/
                    .attr('reg', val['reg']);/*adiciona a regiao*/
                });
                /*Adiciona as cores das regiões caso exitam*/
                $('a[name=cores]').click();
            },
            async: false
        });
            
         
    }
    
    
    /*Pega a lista de labels dos territórios*/
    function getListaLabels(){
        /*pega os labels via ajax*/
        $.ajax({                       
            context: $(this),
            url: "ajax/territorio.php?func=3&id_mapa="+mapa,
            success: function(msg) {
                msg = JSON.parse(msg);
                label = msg;
                var l;
                $.each(msg, function(k, val){/*percorrer json*/
                    l = $('#' + val);
                    /*remove o estilo a adciona os atributos*/
                    l.addClass('label').attr('id', k).attr('name', val).removeAttr('style');
                    l.text(' ');
                //span.text(' ');/*Esconde o 1*/
                });
            },
            async: false
        });            
    }
    
    
    setTimeout(function(){/*espera o mapa terminar de ser carregado*/
        getListaIdTerritorios(); /*pega lista de territorios*/
    }, 5000);

    setTimeout(function(){
        svg = $('#game').svg('get');
        getTam();/*pega lista de territorios e seus tamanhos*/
        find = $("#findviz").val();
        if(find == 1){
            $.each(aut, function(k, val){/*percorre a lista de terrotorios com suas posições*/ 
                $.each(aut, function(key, value){   /*compara todos com todos*/
                    if(k != key){/*se não for ele mesmo*/
                        calcVizinhos(val, value);/*calcula vizinhos*/
                    }
                });
            });
        }
    }, 5000);
    
    setTimeout(function(){
        getListaLabels();/*pega lsta de labsl*/
    }, 5000);

    /**
     *Pega lista de vizinhos por território via ajax
     **/
    function getListaVizinhos(territorio_id){
        /*pega lista de vizinhos de um territorio*/
        $.ajax({                       
            context: $(this),
            url: "ajax/vizinho.php?func=1&territorio=" + territorio_id +"&id_mapa=" + mapa,
            success: function(msg) {
                /*Guarda lista de vizinhos*/
                lista_vizinhos = JSON.parse(msg);
            },
            async: false
        });
    } 
    
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
                svg = $("#game").svg('get');  /*pega div#game e prepara para inserir o mapa*/
                svg.load('file/mapas/' + arq, {    /*le o arquivo*/      
                    addTo: true,          
                    changeSize: true       
                }) 
            },      
            settings: {}
        });

    }
    
    /**
     *Pega o id do território pelo nome dele
     **/
    function getTerritorioIdByName(name){
        
        var res;
        $.each(territorios, function(k, val){ /*percorre lista de territórios*/
            if(val == name){
                res =  k; /*retorna o id do territorio*/
            }            
        });
        return res;
    }
    
    /**
     *Pega o nome pelo id
     **/
    function getTerritorioNameById(id){
        var r = null;
        $.each(territorios, function(k, val){/*percorre lista de territorios*/
            if(id == k){
                r = val; /*retorna o nome do territorio*/
            }            
        });
        return r;
        
    }
    
    /**
     *Pega o nome a parti do id do elemento
     **/
    function getName(element){
        return element.attr('id').toString() /*retorna o nome do elemento*/
    }
    
    /**
     *Pega os inputs para marcar vizinhos de um territorio, caso existam
     **/
    function getInput(name){
        var input = $('input[name=' + name + ']');/*seleciona os inputs*/
        if(input[0]){
            return input;/*retorna todos os inputs */
        }
        return null
    }
    
    /**
     * Esconde todos os elementos em <b> element<b/>
     **/
    function hiddeAll(element){
        element.each(function(){/*percorre os elementos e os esconde*/
            $(this).hide();
        });
    }
    /**
     *Mostra todos os ementos de element
     **/
    function showAll(element){
        element.each(function(){/*percorre os elementos e os mostra*/
            $(this).show();
        });
    }
    
    /**Esconde ou mostra os elementos*/
    function toggleAll(element){
        element.each(function(){/*percorre todos os elementos*/
            $(this).toggle();/*se tiver escondido mostra se tiver visivel esconde*/
        });
    }
   
    /**Desseleciona território selecionaod*/
    function desselecionar(){
        var e = $('.territorio.selecionado');/*pega o territorio selecionado*/
        if(e.exists()){/*se houver um selecionado*/
            var name = e.attr('id'); /*pega o nome*/
            var input = getInput(name); /*pega todos os inputs refetrentes*/
            if(input != null){
                hiddeAll(input);/*esconde todos os territórios*/
            }
            e.removeClass('selecionado');/*desseleciona o territorio*/
        }
    }
    
    /**Aidciona checkbox em todos os territórios
     */
    function adicionarCheckbox(name){
        var l, t;
        $.each(label, function(k, val){/*percorrer json*/
            l = $('[name='+ val +'].label');/*pega o label do territorio*/
            t = l.find('tspan');/*pega o tspan, elemento dentro do texto*/
            var y = l.position().top;/*pega a posiçao do elemento*/
            var x = l.position().left;
            var id = $('[name='+ val.toString().substring(2) +'].territorio').attr('id');/*pega o ide do territorio*/
            if(name != id){/*adiciona checkbox nos territoris menos no territorio selecionado*/
                /**Cria o checkbox*/               
                $('<input>').attr('type', 'checkbox')
                .attr('name', name)/*nome do input*/
                .attr('id', id) /*id do input*/
                .css({/*possição */
                    position: 'absolute', 
                    top: y, 
                    left: x
                })
                .appendTo('div#inputs');/*adiciona na pagina*/
                
            }
        });
    }

    inserirMapa();/*insere o mapa na pagina*/
    
    
    /*Seleciona um território clicado*/
    $('.territorio').live('click', function(){
        /*Desseleciona territorio caso ja esteja selecionado*/
        desselecionar();
        $(this).addClass('selecionado');
        var name = getName($(this));
        var input = getInput(name);
        if(input != null){
            /*caso ja tenha sido mostrado os inputs não precisa criar novamente apenas se mostra eles*/
            showAll(input); 
        }else{
            /*Caso ainda não tenha sido mostrado cria os inputs*/
            id = $(this).attr('id');
            adicionarCheckbox(name);
            getListaVizinhos(id);
            /*adiciona um checkbox em cada territorio do mapa que não seja o selecionado*/
            $.each(lista_vizinhos, function(k , val){
                name_vizinho = val;
                $('input[name=' + name + '][id=' + name_vizinho + ']').attr('checked', true);
            });
        }
    });
    /*desseleciona território*/
    $('.territorio.selecionado').live('click', function(){
        $(this).removeClass('selecionado');
        var name = $(this).attr('id');
        var input = getInput(name);
        if(input != null){
            /*esconde todos os inputs*/
            hiddeAll(input);
        }
    });
    
    /*Salva vizinhos*/
    $('input[type=checkbox]').live('click', function(){
        var e = $(this);
        var t_id = e.attr('name');
        var v_id = e.attr('id');
        var val = e.is(':checked');
        /*faz a alteração via ajax*/
        $.ajax({                       
            context: $(this),
            url: "ajax/vizinho.php?func=2&territorio=" + t_id + "&id_mapa=" + mapa
            + "&vizinho=" + v_id + '&val=' + val,
            success: function(msg){
           
            }
        });
        
    });
    
    
    function getTam(){
        console.log('Tamanho: ');
        dx = $("#game").position().left;
        dy = $("#game").position().top;
        
        $('.territorio').each(function(){
            w = parseInt($(this)[0].getBoundingClientRect().width);/*largura do territorio*/
            h =  parseInt($(this)[0].getBoundingClientRect().height);/*altura do territorio*/
            x =  parseInt($(this).position().left);/*posição x*/
            y =  parseInt($(this).position().top);  /*posição y*/
            name = $(this).attr('name');/*nome*/
            id = $(this).attr('id');/*id*/
            /*adiciona na lista*/
            aut[name] = {};
            aut[name]['id'] = id;
            aut[name]['w'] = w;
            aut[name]['h'] = h;
            aut[name]['x'] = x;
            aut[name]['y'] = y;
            
        // c_x = x + w / 2 -dx;
        // c_y = y + h / 2 -dy;
        // text = svg.text(c_x, c_y, "1", {name : 'l_'+ name, id: id, 'class': 'label'});
          //  svg.rect(x -dx, y - dy, w, h, {'fill-opacity': 0, 'stroke-width': 2, stroke: 'red'});
        });
    }
    
    /**/
    function calcVizinhos(t1, t2, n1, n2){
        /*posição do territorio 1*/
        id1 = t1['id'];
        p1x = t1['x'];
        p1y = t1['y'];
        p1h = t1['h'] + p1y;
        p1w = t1['w'] + p1x;
        /*posição do territorio 2*/
        id2 = t2['id'];
        p2x = t2['x'];
        p2y = t2['y'];
        p2h = t2['h'] + p2y;
        p2w = t2['w'] + p2x;
 
        /*verifica se algum ponto do territorio2 esta na area do territorio1*/
        if(pertenceConjunto(p1x, p1y, p1w, p1h, p2x, p2y)
            || pertenceConjunto(p1x, p1y, p1w, p1h, p2w, p2y) 
            || pertenceConjunto(p1x, p1y, p1w, p1h, p2x, p2h) 
            || pertenceConjunto(p1x, p1y, p1w, p1h, p2w, p2h) 
            ){
            /*salva o os vizinhos*/
            $.ajax({                       
                context: $(this),
                url: "ajax/vizinho.php?func=3&territorio=" + id1 + "&id_mapa=" + mapa
                + "&vizinho=" + id2 + '&val=' + 'true',
                success: function(msg){
           
                }
            });
        }
        
    }
    
    /*verifica se um ponte pertence a um quadrado*/
    function pertenceConjunto(p1x, p1y, p1w, p1h, p2x, p2y){
        /*compara os pontos*/
        if(((p1x <= p2x) && (p1y <= p2y)) 
            && ((p1w >= p2x) && (p1h >= p2y))
            ){
            return true;
        }
        return false
    }
});





