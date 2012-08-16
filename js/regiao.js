$(document).ready(function(){
    var regioes;
    $.ajax({
        
        /*Montar um menu e atualizar toda vez que uma região for alterada*/
        context: $(this),
        url: "ajax/regiao.php?func=1&mapa=30",
        success: function(msg) {
            if(msg){
                msg = JSON.parse(msg);
                regioes = msg;
                $.each(msg, function(k, val){/*percorrer json*/
                    
                    $('<a>' + val +'</a>')
                    .addClass('editar_regiao')
                    .attr('name', val)
                    .attr('id', k)
                    .val(val)
                    .appendTo($('div.regs'));
                    $('<br/>').appendTo($('div.regs'));
                });
            }
        },
        async: false
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
                    // allFields.val( "" ).removeClass( "ui-state-error" );
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    
    $('a.editar_regiao').click(function(){
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
                    // allFields.val( "" ).removeClass( "ui-state-error" );
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    
});