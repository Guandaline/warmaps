<?php 
{
    $arq = new DOMDocument();
    $arq->loadXML('file/mapas/mapa1.svg');

    

    $itens = $arq->getElementsByTagName('*')->item(0);
    
    $e = $arq->getElementsByTagNameNS('path','path');
    
    
    //$itemsq->getElementsByTagName('*');
    //print_r($items);

    echo '<br/>';

    foreach ($itens as $item) {
        
    }

    echo '<pre>';
    for ($i = 0; $i < $itens->length; $i++) {
        $itens->item($i)->nodeValue;
    }
/*
    echo '</pre>';
    foreach ($nodes as $nd) {
        echo '<pre>';
        print_r($nd);
        echo '</pre>';
    }*/
}
?>