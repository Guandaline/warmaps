/**
 *Seta as novas definiçoes do jogo do war
 **/

function newDefines(){
    objetivos = defines.objetivos;
    $.ajax({
        context: $(this),
        url: "ajax/territorio.php?func=4",
        success: function(msg) {
            msg = JSON.parse(msg);
            msg.objetivos = objetivos;
            defines = msg;
        },
        async: false
    });
    
}



 newDefines();
    