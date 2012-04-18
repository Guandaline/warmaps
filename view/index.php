<!DOCTYPE html>
<?php
if (isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = 'index';
if (!strstr($page, '.php'))
    $page .= '.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/default.css"/>
        <link rel="stylesheet" type="text/css" href="css/w1_style.css"/>
        <title></title>
    </head>
    <body>
        <div class="tudo">
            <div id="sidebar">
                <img src="img/logo_war.png" alt=""/>
                <?php
                include_once 'element/menu.php';
                ?>
                <img src="img/logo_uemd.png" alt=""/>
            </div>
            <div id="conteudo">
                <?php
                echo $page;
                include 'page/' . $page;
                ?>
            </div>
        </div>
    </body>
</html>

