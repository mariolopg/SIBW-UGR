<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("connect.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();

    $id = -1;
    $link = 'producto.html';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    };

    if(isset($_GET['imprimir'])){
        $link = 'producto_imprimir.html';
    };

    $info = getInfo($id, $mysqli);
    $images = getImages($id, $mysqli);
    // $rudeWords = getRudeWords($mysqli);

    echo $twig->render($link, ['info' => $info, 'images' => $images]);
    // echo $twig->render('producto.html', ['info' => $info, 'images' => $images, 'rudeWords' => $rudeWords]);
?>