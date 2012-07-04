<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/default.css"/>
        <link rel="stylesheet" type="text/css" href="css/w1_style.css"/>
        <link rel="stylesheet" type="text/css" href="js/jquery.svg.css"/>
        <script type="text/javascript" src="js/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="js/jquery.svg.package-1.4.5/jquery.svg.js"></script>
        <script type="text/javascript" src="js/jquery.svg.package-1.4.5/jquery.svgdom.js"></script>
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

