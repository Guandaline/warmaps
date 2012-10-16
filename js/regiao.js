/**
 *Rregião
 *
 *Contém os metodos e funções para definição de regiões
 **/

$(document).ready(function(){
    mapa = $("#id_mapa").val();
    var cores, reg;
    
    /**
     *Pega a lista de cores de cada região
     **/
    function getCores(){
        /*pega lista via ajax*/
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=4&id_mapa="+mapa,
            success: function(msg) {
                msg = JSON.parse(msg);
                cores = msg; /*guarda as cores*/
            },
            async: false
        });
    }
   
    /**Muda a cor dos territórios*/
    function setCores(){
        $('.territorio').each(function(){/*percorre os territorios*/
            reg = $(this).attr('reg'); /*pega a regiap*/
            $(this).addClass(cores[reg]); /*adiciona a cor referente a sua região*/
        });        
    }
   
   /**
    *Pega todas a regiões do mapa e coloca o menu lateral
    **/
    function getRegs(){
        var dreg = $('div.regs');/* div onde são listada as regioes*/
        $.ajax({
            /*Montar um menu e atualizar toda vez que uma região for alterada*/
            context: $(this),
            url: "ajax/regiao.php?func=1&id_mapa="+mapa,
            success: function(msg) {
                if(msg){
                    msg = JSON.parse(msg);
                    regioes = msg;
                    dreg.html('');
                    $.each(msg, function(k, val){/*percorrer json*/
                        /*cria o link para editar uma regiao*/
                        $('<a>' + val +'</a>')
                        .addClass('editar_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo(dreg);
                        
                        $('<span> | </span>').appendTo(dreg);
                        /*cria o link para excluir uma regiao*/
                        $('<a>Excluir</a>')
                        .addClass('excluir_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo(dreg);
                        
                        $('<span> | </span>').appendTo(dreg);
                        /*cria link para marcar os territórios que pertencem a uma regiao*/
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
        $('a[name=cores]').click(); /*atualiza cores dos territorios casa tenha sido trocada a cor de uma região*/
    }
    

   
    
    getRegs();
    
    $('a[name=cores]').click(function(){
        getCores();
        setCores();
    });
    
    /**Adiciona região no território clicado**/
    $('.regiao').live('click', function(){
        t = $(this);
        var territorio = t.attr('id'); /*pega o id do territorio*/
        t.attr('class', 'regiao');
        t.attr('reg', reg);
        t.addClass(cores[reg]);
        /*Salva região no banco*/
        $.ajax({
            context: this,
            url: "ajax/territorio.php?func=1&regiao=" + reg + "&territorio=" + territorio + "&id_mapa=" + mapa,
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
        reg = $(this).attr('id');/*pega o id da regiao que vai ser adicionado*/
        
    });
        
      /*Criar nova região*/
    $('a.nova_regiao').click(function(){
        /*Insere o form via ajax*/
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?id_mapa=" + mapa,
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
       /*abre o formulario via ajax*/
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?id=" + id + "&id_mapa="+mapa, /*passa o id da regiao a ser editada*/
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
                $( "#dialog-form" ).dialog( "open" ); /*abre janela*/
            },
            async: false
        });

    });
    
    
    /*exclui uma região*/
    $('a.excluir_regiao').live('click', function(){
        var id = $(this).attr('id');
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=5&id=" + id + "&id_mapa="+mapa,
            success: function(msg) {
                getRegs();
                /*remove a região do mapa*/
                $('[reg='+ id +']').attr('class', 'regiao');
            },
            async: false
        });
        
        $('a.mod_territorios').click(); /*muda para o mode de indicação de vizinhos*/
        alert("Região excluida!");
    });
    
});