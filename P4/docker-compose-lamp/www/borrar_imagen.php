<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/comments.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();

    if (isset($_SESSION['user'])) {
        $admin = getUser($mysqli, $_SESSION['user']);
    }

    if(isset($_GET['id'])){
        $idImagen = $_GET['id'];
    }

    if(($admin['rol'] == "superuser" || $admin['rol'] == "moderador") && $idImagen){
        $id_sneaker = deleteImagen($mysqli, $idImagen);
        $header = "Location: edit_producto.php?id=" . $id_sneaker;
        header($header); 
    }
?>