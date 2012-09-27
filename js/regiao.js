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
        $('.territorio').each(function(){
            reg = $(this).attr('reg');
            $(this).addClass(cores[reg]);
        });        
    }
   
    function getRegs(){
        var dreg = $('div.regs');
        $.ajax({
            /*Montar um menu e atualizar toda vez que uma região for alterada*/
            context: $(this),
            url: "ajax/regiao.php?func=1&mapa=30",
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
                        getRegs();
                    // allFields.val( "" ).removeClass( "ui-state-error" );
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    
    $('a.editar_regiao').live('click',function(){
        var id = $(this).attr('id');
        var name = $(this).attr('name');
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
                        $('[reg='+ id +']').attr('class', 'regiao').addClass(cores[id]);
                        $('a[name='+ name + '].territorios_regiao').click();
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            },
            async: false
        });

    });
    
    
    
    $('a.excluir_regiao').live('click', function(){
        var id = $(this).attr('id');
        $.ajax({
            context: $(this),
            url: "ajax/regiao.php?func=5&id=" + id,
            success: function(msg) {
                //msg = JSON.parse(msg);
                getRegs();
                $('[reg='+ id +']').attr('class', 'regiao');
            },
            async: false
        });
        
        $('a.mod_territorios').click();
    });
    
});