<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("connect.php");
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();

    $id = -1;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    };

    // $info = getInfo($id, $mysqli);
    // $images = getImages($id, $mysqli);
    // $rudeWords = getRudeWords($mysqli);

    // echo $twig->render('producto.html', ['info' => $info, 'images' => $images, 'rudeWords' => $rudeWords]);
    
    $gallery = getGallery($mysqli);
    
    echo $twig->render('portada.html', ['gallery' => $gallery]);
?>