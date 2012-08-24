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
<div>
    <?php
        echo 'Id mapa = '.Session::getVal('nome');
    ?>
</div>
<div id="game" style="width: 95%; height: 90%; border: solid 1px #000; text-align: center; background-color: #4567BA;"></div>
<div id="inputs"></div>
<div id="dialog-form"></div>