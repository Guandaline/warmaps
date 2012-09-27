
<div id="form">
    <div>
        <h1>
            Novo Mapa
        </h1>
    </div>
    <div class="subtitulo">
        <strong>Enviar mapa pronto!</strong>
    </div>
    <p>Escolha um mapa para inserir no jogo: </p>
    <form name="mapa" method="post" ENCTYPE="multipart/form-data" action="index.php?view=mapa&method=salvar&action=config">
       
        <label>Enviar Mapa: </label><input id="submitfile" name="mapafile" type="file"/><br/>
        <label>Tipo do mapa: </label>
        <select name="tipo">
            <option value=""></option>
            <?php 
                foreach ($tipos as $val){
                    ?>
                <option value="<?php echo $val['id'];?>"><?php echo $val['descr'];?></option>
                    <?php
                }
            ?>
        </select><br/>
        <div>
            <input type="submit" value="Enviar"/>
        </div>
        
    </form>
    <div class="nota">
        Texto Aqui!
    </div>
</div>
