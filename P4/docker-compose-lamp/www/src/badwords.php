<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("connect.php");
    include("bd.php");

    $mysqli = conectar();
    echo(getBadWords($mysqli));
?>