<?php
ini_set('display_errors', 1);
include_once 'element/includes.php';

//$link = mysql_connect('localhost', 'root', '021190');

$errmsg = null;

//Utils::mysql_install_db('warmaps', 'bd/warmaps.sql', $errmsg);

$view = isset($_GET['view']) ? $_GET['view'] : 'install';
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
$method = isset($_GET['method']) ? $_GET['method'] : NULL;
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

$data = NULL;

if ($method != NULL) {
    if ($_POST)
        $data['post'] = $_POST;
    if ($_FILES)
        $data['file'] = $_FILES;
}
//if(empty($_FILES)) $file = $_FILES;

Utils::incluirMC($view);

$obj = new View($view, $action, $method, $data);

if ($msg != '') {
    ?>

        <div style="background: #F1F1F1; 
             border: solid 1px #000; 
             width: 400px; height: 100px; 
             border-radius: 4px;
             text-align: cente;
             color: red;
             margin-left: 35%;
             padding: 5px;
             ">
            <?php
            echo $msg;
            ?>
        </div>

    <?php
}
?>
