<script src="js/mapa.js"></script>
<script src="js/lateral.js"></script>
<script src="js/regiao.js"></script>
<script src="js/objetivo.js"></script>

<div class="lateral">
    <div class="mostrar">  
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
        <hr/>
        <div>
            <a class="objetivos" href="#">
                Objetivos
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
</div>   

<div>
    <?php
        $mapa = isset($_GET['id_mapa']) ? $_GET['id_mapa'] : 0; /*pega o id do mapa*/
        $nome = isset($_GET['nome']) ? $_GET['nome'] : 0; /*pega o id do mapa*/
        $viz = isset($_GET['viz']) ? $_GET['viz'] : 0;
    ?>
</div>
<input type="hidden" value="<?php echo $viz;?>" name="findviz" id="findviz"/>
<input type="hidden" value="<?php echo $nome;?>" name="arquivo"/>
<input type="hidden" value="<?php echo $mapa; ?>" name="id_mapa" id="id_mapa"/>
<div id="game" style=""></div>
<div id="inputs"></div>
<div id="dialog-form"></div>
