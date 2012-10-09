/**
 *Rregião
 *
 *Contém os metodos e funções para definição de regiões
 **/

$(document).ready(function(){
    
    var cores, reg;
    
    /**
     *Pega a lista de cores do mapa
     **/
    function getCores(){
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=4",
            success: function(msg) {
                msg = JSON.parse(msg);
                cores = msg;
            },
            async: false
        });
    }
   
    /**Muda a cor de um território*/
    function setCores(){
        $('.territorio').each(function(){
            reg = $(this).attr('reg');
            $(this).addClass(cores[reg]);
        });        
    }
   
   /**
    *Pega todas a regiões do mapa e coloca o menu lateral
    **/
    function getRegs(){
        var dreg = $('div.regs');
        $.ajax({
            /*Montar um menu e atualizar toda vez que uma região for alterada*/
            context: $(this),
            url: "ajax/regiao.php?func=1",
            success: function(msg) {
                if(msg){
                    msg = JSON.parse(msg);
                    regioes = msg;
                    dreg.html('');
                    $.each(msg, function(k, val){/*percorrer json*/
                        $('<a>' + val +'</a>')
                        .addClass('editar_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo(dreg);
                        
                        $('<span> | </span>').appendTo(dreg);
                        
                        $('<a>Excluir</a>')
                        .addClass('excluir_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo(dreg);
                        
                        $('<span> | </span>').appendTo(dreg);
                        $('<a>Territorios</a>')
                        .addClass('territorios_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo(dreg);
                       
                        
                        $('<br/>').appendTo(dreg);
                        $('<hr/>').appendTo(dreg);
                    });
                }
            },
            async: false
        });
         $('a[name=cores]').click();
    }
    

   
    
    getRegs();
    
    $('a[name=cores]').click(function(){
        getCores();
        setCores();
    });
    
    /**Adiciona região no território clicado**/
    $('.regiao').live('click', function(){
        t = $(this);
        var territorio = t.attr('id');
        t.attr('class', 'regiao');
        t.attr('reg', reg);
        t.addClass(cores[reg]);
        /*Salva região no banco*/
        $.ajax({
            context: this,
            url: "ajax/territorio.php?func=1&regiao=" + reg + "&territorio=" + territorio,
            success: function(data){
                
            } 
        });
    });
    
    /*
     *Altera o "Mode de configuração"
     *Ao clicar em um territorio 
     **/
    $('a.territorios_regiao').live('click', function(){
        $('a.mod_regioes').click();    
        reg = $(this).attr('id');
        
    });
        
      /*Criar nova região*/
    $('a.nova_regiao').click(function(){
        /*Insere o form via ajax*/
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?",
            success: function(data){
                $('#dialog-form').html(data);
                $( "#dialog-form" ).dialog({
                    title: 'Nova Região',
                    autoOpen: false,
                    width: 500,
                    height: 350,
                    position: [200, 80],
                    modal: true,
                    zIndex: 1500,
                    buttons: {
                        Fechar: function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                        getRegs(); /*Atualiza menu latera com com as novas configurações de regição*/
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    /*
     * Formulario para editar uma região
     **/
    $('a.editar_regiao').live('click',function(){
       /*Pega os dados da região*/
       var id = $(this).attr('id');
        var name = $(this).attr('name');
       
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?id=" + id,
            success: function(data){
                $('#dialog-form').html(data);
                $( "#dialog-form" ).dialog({
                    title: 'Nova Região',
                    autoOpen: false,
                    width: 500,
                    height: 350,
                    position: [200, 80],
                    modal: true,
                    zIndex: 1500,
                    buttons: {
                        Fechar: function() {
                            $( this ).dialog( "close" );

                        }
                    },
                    close: function() {
                        getRegs();/*atualiza menu lateral*/
                        /*Insere no mapa as alterações da região
                         *Troca a cor dos seus territorios caso tenha sido altera na edição
                         **/
                        $('[reg='+ id +']').attr('class', 'regiao').addClass(cores[id]);
                        $('a[name='+ name + '].territorios_regiao').click();
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            },
            async: false
        });

    });
    
    
    /*exclui uma região*/
    $('a.excluir_regiao').live('click', function(){
        var id = $(this).attr('id');
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=5&id=" + id,
            success: function(msg) {
                getRegs();
                /*remove a região do mapa*/
                $('[reg='+ id +']').attr('class', 'regiao');
            },
            async: false
        });
        
        $('a.mod_territorios').click();
    });
    
});