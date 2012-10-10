$(document).ready(function(){
    /*
     *
     *Esse codigo abaixo ainda pretendo arrumar
     *Se for possivel

    function esconder(){
        $('div.options').hide();
        $('.lateral.large').removeClass('large');
        $('div.lateral').addClass('small');
        $('div.mostrar').show();
        console.log('q papo é esse?');
    }
    
    $('div.lateral').addClass('small');

    $('.lateral.small').click(function(){
        $(this).removeClass('samll');
        $(this).addClass('large');
        $('div.options').show();
        $('div.mostrar').hide();
    });
    
    $('div#game').click(function(){
        esconder();
    });
    */
   
   /*Muda para o modo de indicar vizinhos quando um território é clicado*/
    $('a.mod_territorios').click(function(){
        $('.regiao').each(function(){
            $(this).removeClass('regiao');
            $(this).removeClass('selecionado');
            $(this).addClass('territorio');
        });
        $('input').each(function(){
            $(this).hide();
        });
        //esconder();
    });
    
   
    /*
     *Muda para o mode de indicar quais territórios pertence a qual religião
     **/
    $('a.mod_regioes').click(function(){
        $('.territorio').each(function(){
            $(this).removeClass('territorio');
            $(this).removeClass('selecionado');
            $(this).addClass('regiao');
        });
        $('input').each(function(){
            $(this).hide();
        });
      //  esconder();
    });
    
});

