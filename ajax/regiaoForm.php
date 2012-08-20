<script type="text/javascript">
    $(document).ready(function(){
        $('form[name=form_regiao]').submit(function(e){
            e.preventDefault();
            var params = $(this).serialize();
            $.ajax({
                type: 'post',
                data: params,
                url: "ajax/regiao.php?func=2&mapa=30",
                success: function(msg){
                    //console.log('Salvou?');
                    //console.log(msg);
                    $( "#dialog-form" ).dialog("close");
                },
                async: false
            });
        });
        
        function edit(){
            input = $('input[name=id]');
            if(input[0]){
                id = input.val();
                 console.log(id);
                $.ajax({
                    context: $(this),
                    url: "ajax/regiao.php?func=3&id=" + id,
                    success: function(msg) {
                        msg = JSON.parse(msg);
                        console.log(msg);
                        if(msg){
                            $('input[name=nome]').val(msg[0].nome);
                            $('input[name=estrategico]').val(msg[0].valor_estrategico);
                            $('input[name=exercitos]').val(msg[0].exercitos);
                        }
                    },
                    async: false
                });
            }
        }
        
        edit();
    });
</script>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : NULL;
?>

<div>
    <form name="form_regiao" method="post" action="">
        <?php
        if ($id !== NULL) {
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <?php
        }
        ?>
        Nome: <input name="nome" type="text"/>
        <br/>
        Cor: 
        <select name="cor">
            <option value="verde">Verde</option>
            <option value="amarelo">Amarelo</option>
            <option value="vermelho">Vermelho</option>
            <option value="azul">Azul</option>
            <option value="branco">Branco</option>
            <option value="preto">Preto</option>
        </select>
        <br/>
        Valor estratégico
        <input name="estrategico" type="text"/>
        <br/>
        Exércitos: 
        <input name="exercitos" type="text"/>
        <br/>
        <input type="submit" name="enviar" value="enviar"/>
    </form>
</div>