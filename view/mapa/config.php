<script src="js/mapa.js"></script>
<script src="js/lateral.js"></script>
<script src="js/regiao.js"></script>

<div class="lateral">
    <div class="mostrar">  </div>
    <div class="options">
        <div>
            <a class="mod_territorios" href="#">
                Indicar Vizinhos
            </a>
        </div>
        <hr/>
        <div>
            <a class="nova_regiao" href="#">
                Nova região
            </a>
        </div>
        <div style="display: none;">
            <a class="mod_regioes" href="#">
                Indicar Regiões
            </a>
            <a name="cores"> cores</a>
        </div>
           <hr/>
           <br/>
           <strong>Editar regiões</strong>
           <br/>
           <br/>
        <div class="regs">
        </div>
        
    </div>
</div>   

<input type="hidden" value="<?php echo $nome?>" name="arquivo"/>
<div id="game" style=""></div>
<div id="inputs"></div>
<div id="dialog-form"></div>

<form name="form_path" method="post" action="">
</form>