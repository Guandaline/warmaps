$(document).ready(function(){
    var regioes;
    $.ajax({
        context: $(this),
        url: "ajax/regiao.php?func=1&mapa=30",
        success: function(msg) {
            msg = JSON.parse(msg);
            regioes = msg;
            $.each(msg, function(k, val){/*percorrer json*/
                $('<a>').addClass('regiao')
                        .attr('name', val)
                        .attr('id', k)
                        .val(val)
                        .appendTo($('div.regs'));
            });
        }
    });
});