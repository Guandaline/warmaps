

<script type="text/javascript">

    $(document).ready(function(){
        /*Coloca os dados do mapa na session*/
        $('.mapas').click(function(e){
            
            var nome = $(this).attr('name');
            var mapa = $(this).attr('id');
            $.ajax({
                url: 'ajax/session.php?mapa=' + mapa + '&nome=' + nome,
                success: function(msg){
                },
                assync: false
            });
            
        });
        
        /*Exclui um mapa*/
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
<?php


?>
<br/>   
<div style="text-align: center; border-bottom: solid 1px #000; font-weight: bold; font-size: 26px; margin: 1px; width: 95%;">
            Lista de mapas
    </div>
<br/>
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
                <a class="mapas" href="index.php?view=mapa&action=config&id_mapa=<?php echo $val['id'];?>&nome=<?php echo $val['nome'];?>" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Editar
                </a>
                |
                 <a class="mapas" href="index.php?view=war&id_mapa=<?php echo $val['id'];?>&nome=<?php echo $val['nome'];?>" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Jogar
                </a>
                |
                 <a class="excluir" href="" name="<?php echo $val['nome']; ?>" id="<?php echo $val['id']; ?>">
                    Excluir
                </a>
            </div>

            <?php
        }
        ?>
    </div>