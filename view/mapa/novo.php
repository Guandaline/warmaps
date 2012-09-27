
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
    <form name="mapa" method="post" ENCTYPE="multipart/form-data" action="index.php?view=mapa&action=config&method=salvar">
       
        <label>Enviar Mapa: </label><input id="submitfile" name="mapafile" type="file"/><br/>
        <div>
            <input type="submit" value="Enviar"/>
        </div>
        
    </form>
    <div class="nota">
        Texto Aqui!
    </div>
</div>
