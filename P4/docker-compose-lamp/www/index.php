<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");

    session_start();

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();
    
    $gallery = getGallery($mysqli);
    
    echo $twig->render('portada.html', ['gallery' => $gallery]);
?>