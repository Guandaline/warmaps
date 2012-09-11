function newDefines(){
    objetivos = defines.objetivos;
    $.ajax({
        context: $(this),
        url: "ajax/territorio.php?func=4",
        success: function(msg) {

        },
        async: false
    });
    
}

