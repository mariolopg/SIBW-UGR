<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("connect.php");
    include("bd.php");

    session_start();

    $mysqli = conectar();


    if(isset($_GET['search'])){
        $search = $_GET['search'];
    };

    header('Content-Type: application/json');

    if (isset($_SESSION['user'])) {
        $user = getUser($mysqli, $_SESSION['user']);
    }

    echo(searchItem($mysqli, $user, $search));
?>