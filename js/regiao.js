$(document).ready(function(){
    var regioes;
    $.ajax({
        context: $(this),
        url: "ajax/regiao.php?func=1&mapa=30",
        success: function(msg) {
            msg = JSON.parse(msg);
            regioes = msg;
            $.each(msg, function(k, val){/*percorrer json*/
                $('<a>' + val +'</a>').addClass('regiao')
                .attr('name', val)
                .attr('id', k)
                .val(val)
                .appendTo($('div.regs'));
            });
        }
    });
    
    $('a.nova_regiao').click(function(){
        console.log('nova');
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
    
    $('form[name=form_regiao]').submit(function(e){
        e.preventDefault();
        var params = $(this).serialize();
        $.ajax({
            type: 'post',
            data: params,
            url: "ajax/regiao.php?func=1&mapa=30",
            success: function(data){
                
            },
            async: false
        });
    });
    
});