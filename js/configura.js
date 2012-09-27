function configTerritorio(){
    $.ajax({                       
        context: $(this),
        url: "ajax/territorio.php?func=2",
        success: function(msg) {
            msg = JSON.parse(msg);
             console.log(msg);
            $.each(msg, function(k, val){/*percorrer json*/
                $('#' + val['name']).removeAttr('style');
                $('#' + val['name']).attr('name', val['name'].toString().substring(2))
                .attr('reg', val['reg']);
            });
        },
        async: false
    });
}

