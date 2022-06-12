<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();

    $id = -1;
    $link = 'producto.html';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    };

    if(isset($_GET['imprimir'])){
        $link = 'producto_imprimir.html';
    };

    $info = getInfo($mysqli, $id);
    $images = getImages($mysqli, $id);
    $comments = getComments($mysqli, $id);
    $tags = getTags($mysqli, $id);

    if (isset($_SESSION['user'])) {
        $user = getUser($mysqli, $_SESSION['user']);
    }

    $usuarios = getUsers($mysqli);

    echo $twig->render($link, ['info' => $info, 'images' => $images, 'comments' => $comments, 'user' => $user, 'usuarios' => $usuarios, 'tags' => $tags]);
?>