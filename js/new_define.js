/**
 *Seta as novas definiçoes do jogo do war
 **/

function newDefines(){
    /*Pega as novas definições via ajax*/
    $.ajax({
        context: $(this),
        url: "ajax/territorio.php?func=4",
        success: function(msg) {
            msg = JSON.parse(msg);
            defines = msg;
           // console.log(defines);
        },
        async: false
    });
    
}



newDefines();
    