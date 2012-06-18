<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/default.css"/>
        <link rel="stylesheet" type="text/css" href="css/w1_style.css"/>
        <title><?php echo $titulo; ?></title>
    </head>
    <body>
        <div id="menu">
            <?php
            include_once 'element/menu.php';
            ?>
        </div>

        <div id="conteudo">
            <?php
            include $this->page;
            ?>
        </div>
    </body>
</html>

