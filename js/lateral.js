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
       alert("Utilize a barra lateral para Criar novas Regiões ou Novos Objetivos!");
   
   /*Muda para o modo de indicar vizinhos quando um território é clicado*/
    $('a.mod_territorios').click(function(){
        /*muda de classe regiao para territorio*/
        $('.regiao').each(function(){/*percorre todos os territorios*/
            $(this).removeClass('regiao'); /*remove a classe regiao*/
            $(this).removeClass('selecionado'); /*remove a classe selecionado caso exista algum selecionado*/
            $(this).addClass('territorio'); /*adciona a classe territorio*/
        });
        $('input').each(function(){/*esconde todos os inputs*/
            $(this).hide();
        });
        alert("Clique nos Territórios para indicar seus vizinhos!");
    });
    
   
    /*
     *Muda para o mode de indicar quais territórios pertence a qual religião
     **/
    $('a.mod_regioes').click(function(){
        /**/
        /*muda de territorio para regiao*/
        $('.territorio').each(function(){
            $(this).removeClass('territorio');
            $(this).removeClass('selecionado');
            $(this).addClass('regiao');
        });
        $('input').each(function(){/*esconde todos os inputs*/
            $(this).hide();
        });
        alert("Clique nos Territórios para indicar sua Região.");
    });
    
});

