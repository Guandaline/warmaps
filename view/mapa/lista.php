

<script type="text/javascript">

    $(document).ready(function(){
        
        $('.mapas').click(function(e){
            var nome = $(this).attr('name');
            var mapa = $(this).attr('id');
            $.ajax({
                url: 'ajax/session.php?mapa=' + mapa + '&nome=' + nome,
                success: function(msg){
                    console.log(msg);
                    console.log(mapa);
                },
                assync: false
            });
            
        });
        
         $('.excluir').click(function(e){
            var mapa = $(this).attr('id');
            $.ajax({
                url: 'ajax/mapa.php?func=1&mapa=' + mapa,
                success: function(msg){
                    console.log(msg);
                },
                assync: false
            });
            
        });
    });


</script>


<fieldset>
    <legend>
        <h1>
            Lista de Mapas
        </h1>
    </legend>

    <div class="box-mapas">
        <?php
        foreach ($mapas as $k => $val) {
            ?>
            <div class="botao-mapa">

                <img src="image/globo.png" width="50" height="50">

                <br/>
                <?php echo $val['nome']; ?>
                <br/>
                <hr>
                <a class="mapas" href="index.php?view=mapa&action=config" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Editar
                </a>
                |
                 <a class="mapas" href="index.php?view=war" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Jogar
                </a>
                |
                 <a class="excluir" href="" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Excluir
                </a>
            </div>

            <?
        }
        ?>
    </div>
</fieldset>