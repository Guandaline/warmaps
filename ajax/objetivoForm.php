<script type="text/javascript">
    $(document).ready(function(){
        /*Ao enviar uma região ela é inserida via ajax*/
        $('form[name=form_obj]').submit(function(e){
            /*Cancela o evento*/
            e.preventDefault();
            var params = $(this).serialize();
            /*insere via ajax*/
            $.ajax({
                type: 'post',
                data: params,
                url: "ajax/objetivo.php?func=1",
                success: function(msg){
                    $( "#dialog-form" ).dialog("close");
                },
                async: false
            });
            $('a.objetivos').click();
        });
    
        
    });
</script>

<?php
include_once 'includes.php';
Utils::incluir('regiao', 'controller', '../');
Utils::incluir('regiao', 'model', '../');
Utils::incluir('objetivo', 'controller', '../');
Utils::incluir('objetivo', 'model', '../');
Session::start("warmaps");
$regiao = new regiaoController();
$obj = new objetivoController();

$tipo = "conquistaContinentes";
$conquistarcontinente = 0.5;
$conquistafacil = 0.9;
$tomarcontinente = 0.5;
$outros = false;
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$id_mapa = Session::getVal('mapa');
$regs = $regiao->getListaRegiao($id_mapa);
$objetivos = $obj->getLista($id_mapa);

?>

<div >
    <br/>
    <div class="form-dir">
        <form name="form_obj" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <input type="hidden" name="id_mapa" value="<?php echo $id_mapa; ?>"/>
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>"/>
            <input type="hidden" name="conquistarcontinente" value="<?php echo $conquistarcontinente; ?>"/>
            <input type="hidden" name="conquistafacil" value="<?php echo $conquistafacil; ?>"/>
            <input type="hidden" name="tomarcontinente" value="<?php echo $tomarcontinente; ?>"/>
            Descrição: <input type="text" name="nome" value="<?php echo $nome ?>" >
            <br/>
            Primeiro Continente:
            <select name="reg1">
                <option value=""  selected></option>
<?php
foreach ($regs as $val) {
    ?>
                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                    <?php
                }
                ?>
            </select>
            <br/>
            Segundo Continente:
            <select name="reg2">
                <option value="" selected></option>
<?php
foreach ($regs as $val) {
    ?>
                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                    <?php
                }
                ?>
            </select>
            <br/>
            Terceiro Qualquer:
            <select name="outro">
                <option value="0">Nenhum</option>
                <option value="1" <?php if ($outros) echo 'selected'; ?>>Outros</option>
            </select>
            <br/>
            <input type="submit" name="enviar" value="enviar"/>
        </form>
    </div>
    <hr>
    <div class="lista-lateral">
<?php
foreach ($objetivos as $key => $value) {
    ?>
            <div>
            <?php echo $value . ' ('; ?> 
                <a href="#" class="excluir" id="<?php echo $key; ?>" style="color: red;">
                    Excluir
                </a>)
            </div>    
    <?php
}
?>
    </div>
</div>
