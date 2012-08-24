$(document).ready(function(){
    
    var cores, reg;
    
    
    function getCores(){
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=4&mapa=30",
            success: function(msg) {
                msg = JSON.parse(msg);
                cores = msg;
            },
            async: false
        });
    }
   
    
    function setCores(){
        console.log('cores em territorios' );
        $('.territorio').each(function(){
            console.log($(this).attr('name'))
            reg = $(this).attr('reg');
            $(this).addClass(cores[reg]);
        });        
    }
   
    function getRegs(){
        $.ajax({
        
            /*Montar um menu e atualizar toda vez que uma região for alterada*/
            context: $(this),
            url: "ajax/regiao.php?func=1&mapa=30",
            success: function(msg) {
                if(msg){
                    msg = JSON.parse(msg);
                    regioes = msg;
                    $('div.regs').html('');
                    $.each(msg, function(k, val){/*percorrer json*/
                        $('<a>' + val +'</a>')
                        .addClass('editar_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo($('div.regs'));
                        
                        $('<span> | </span>').appendTo($('div.regs'));
                        
                        $('<a>Excluir</a>')
                        .addClass('excluir_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo($('div.regs'));
                        
                        $('<span> | </span>').appendTo($('div.regs'));
                        $('<a>Territorios</a>')
                        .addClass('territorios_regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo($('div.regs'));
                       
                        
                        $('<br/>').appendTo($('div.regs'));
                        $('<hr/>').appendTo($('div.regs'));
                    });
                }
            },
            async: false
        });
    }
    

   
    
    getRegs();
    
   $('a[name=cores]').click(function(){
        getCores();
        setCores();
   });
    
    $('.regiao').live('click', function(){
        t = $(this);
        var territorio = t.attr('id');
        t.attr('class', 'regiao');
        t.attr('reg', reg);
        t.addClass(cores[reg]);
        $.ajax({
            context: this,
            url: "ajax/territorio.php?func=1&regiao=" + reg + "&territorio=" + territorio,
            success: function(data){
                
            } 
        });
    });
    
    $('a.territorios_regiao').live('click', function(){
        $('a.mod_regioes').click();
        /*chamar função de esconder o menu lateral*/
        reg = $(this).attr('id');
        
    });
        
      
    $('a.nova_regiao').click(function(){
        $('a.mod_regioes').click();
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?mapa=30",
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
                        getRegs();
                    // allFields.val( "" ).removeClass( "ui-state-error" );
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    
    $('a.editar_regiao').live('click',function(){
        $('a.mod_regioes').click();
        var id = $(this).attr('id');
        $.ajax({
            context: this,
            url: "ajax/regiaoForm.php?mapa=30&id=" + id,
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
                        getRegs();
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            },
            async: false
        });
    });
    
    $('a.excluir_regiao').live('click', function(){
        
    });
    
});