
<div style="width: 95%; height: 90%; border: solid 1px #000;">
    <?php
    $arquivo = fopen($dir, "r");

    if ($arquivo == NULL)
        echo 'nao é esse o caminho';
    else {
        ?>
        <svg style="width: 100%; height: 100%; border: solid 1px #000;">
            <?php
            while (!feof($arquivo)) {
                $linha = fgets($arquivo);
                echo $linha;
            }
            ?>
        </svg>
        <?php
    }
    ?>

</div>