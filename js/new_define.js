/**
 *Seta as novas definiçoes do jogo do war
 **/
$(document).ready(function(){
   
   mapa = $("#id_mapa").val();

function newDefines(){
    /*Pega as novas definições via ajax*/
    
    console.log(mapa);
    $.ajax({
        context: $(this),
        url: "ajax/territorio.php?func=4&id_mapa=" + mapa,
        success: function(msg) {
            msg = JSON.parse(msg);
            defines = msg;/*seta novas definições*/
            //console.log(defines);
        },
        async: false
    });
    
}

newDefines();
}); 