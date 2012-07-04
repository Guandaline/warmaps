<script>
   $(document).ready(function(){
    
    

        console.log("Inicio.....");
        $("#game").svg({      
        onLoad: function() {       
            console.log("leu.....");
            var svg;        
            svg = $("#game").svg('get');        
            svg.load('file/mapas/mapa2.svg', {          
                addTo: true,          
                changeSize: false        
            });      
        },      
        settings: {}    });
    
    
    
   });
</script>

<pre>
<?php
    print_r($lista_territorios);
?>
</pre>

<div id="game" style="width: 95%; height: 90%; border: solid 1px #000; text-align: center;">
  
</div>

  <?php
  /*
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
    }*/
  echo '';
    ?>