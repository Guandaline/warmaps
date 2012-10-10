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
            msg.objetivos[1] = objetivos;
            msg.objetivos[2] = objetivos;
            defines = msg;
            console.log(defines.objetivos);
        },
        async: false
    });
    
}



 newDefines();
    