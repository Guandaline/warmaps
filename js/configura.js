/**
 *Pega a lista de territórios e os configura no mapa
 **/
function configTerritorio(){
    /*pega os dados do território via ajax*/
    $.ajax({                       
        context: $(this),
        url: "ajax/territorio.php?func=2",
        success: function(msg) {
            msg = JSON.parse(msg);
            $.each(msg, function(k, val){/*percorrer json*/
                $('#' + val['name']).removeAttr('style');/*Remove o atributo Style*/
                $('#' + val['name']).attr('name', val['name'].toString().substring(2))
                .attr('reg', val['reg']);/*atribui nome e região ao território*/
                
            });
        },
        async: false
    });
}

