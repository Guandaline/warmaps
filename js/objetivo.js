$(document).ready(function(){
    
    
    $('a.objetivos').click(function(){
        /*Insere o form via ajax*/
        $.ajax({
            context: this,
            url: "ajax/objetivoForm.php",
            success: function(data){
                $('#dialog-form').html(data);
                $( "#dialog-form" ).dialog({
                    title: 'Novo Objetivo',
                    autoOpen: false,
                    width: 700,
                    height: 450,
                    position: [200, 80],
                    modal: true,
                    zIndex: 1500,
                    buttons: {
                        Fechar: function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                      
                    }
                });
                $( "#dialog-form" ).dialog( "open" ); 
            }            
        });
    });
    
    
      $('a.excluir').live('click', function(){
        var id = $(this).attr('id');
        $.ajax({
            context: $(this),
            url: "ajax/objetivo.php?func=2&id=" + id,
            success: function(msg) {
                /*remove a região do mapa*/
                $('a.objetivos').click();
            },
            async: false
        });        
    });
    
     
});