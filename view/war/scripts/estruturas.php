<?php
include "valores.php";
$a[0]=1;
$a[1]=2;
$a[2]=3;
$a[3]=4;
$b[0]=1;
$b[1]=2;
$b[3]=3;
$c[0][0]=&$a;
$c[0][cluster]=1;
$c[1][0]=&$b;
$c[1][cluster]=2;
$w=new valores(2,$c[0][0],$c[1][0],$c,$d,$e,$f);

$w->aumenta_valor();

echo $w->distancia_pontos($c[0][0],$c[1][0]);

?>