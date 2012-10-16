<script type="text/javascript">
    $(document).ready(function(){
        /*Ao enviar uma região ela é inserida via ajax*/
        mapa = $("#id_mapa").val();
        $('form[name=form_regiao]').submit(function(e){
            /*Cancela o evento*/
            e.preventDefault();
            var params = $(this).serialize();
            /*insere via ajax*/
            $.ajax({
                type: 'post',
                data: params,
                url: "ajax/regiao.php?func=2&id_mapa="+mapa,
                success: function(msg){
                    $( "#dialog-form" ).dialog("close");
                },
                async: false
            });
        });
        
        function edit(){
            /*Caso exista um id significa que é uma edição de território*/
            input = $('input[name=id]');
            if(input[0]){
                id = input.val();
                /*Pega os dados via ajax*/
                $.ajax({
                    context: $(this),
                    url: "ajax/regiao.php?func=3&id=" + id + "&id_mapa=" + mapa,
                    success: function(msg) {
                        msg = JSON.parse(msg);
                        if(msg){
                            $('input[name=nome]').val(msg[0].nome);
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
$mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : NULL;
?>

<div class="form-reg">
    <form name="form_regiao" method="post" action="">
        <input type="hidden" value="<?php echo $mapa; ?>" name="id_mapa" id="id_mapa"/>
        <?php
        if ($id !== NULL) {
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <?php
        }
        ?>
        <div class="left"> Nome: </div>
        <div class="right">
            <input name="nome" type="text"/>
        </div>
        <br/>
        <div class="left"> Cor: </div>
        <div class="right"> 
            <select name="cor">
                <option value="verde">Verde</option>
                <option value="amarelo">Amarelo</option>
                <option value="vermelho">Vermelho</option>
                <option value="azul">Azul</option>
                <option value="branco">Branco</option>
                <option value="preto">Preto</option>
                <option value="rosa">Rosa</option>
                <option value="laranja">Laranja</option>
            </select>
        </div>
        <br/>
        <div class="left"> Exércitos: </div>
        <div class="right">
            <input name="exercitos" type="text"/>
        </div>
        <br/>
        <div style="text-align: center; margin-top: 5px;"> <input type="submit" name="enviar" value="enviar"/></div>
    </form>
</div>