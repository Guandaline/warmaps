
<div id="form">
<div style="text-align: center; border-bottom: solid 1px #000; font-weight: bold; font-size: 26px; margin: 1px; width: 95%;">
            Novo Mapa
    </div>
    <div class="subtitulo">
        <strong>Enviar mapa pronto!</strong>
    </div>
    <p>Escolha um mapa para inserir no jogo: </p>
    <form name="mapa" method="post" ENCTYPE="multipart/form-data" action="index.php?view=mapa&action=config&method=salvar">
       
        <input id="submitfile" name="mapafile" type="file"/><br/>
        <div>
            <input type="submit" value="Enviar"/>
        </div>
        
    </form>
    <br/>
    <div class="nota">
        Ao enviar um mapa já existente o mesmo será atualizado.
    </div>
</div>
