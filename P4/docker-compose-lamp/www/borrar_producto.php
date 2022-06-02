<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();

    if (isset($_SESSION['user'])) {
        $admin = getUser($mysqli, $_SESSION['user']);
    }

    if(isset($_GET['id'])){
        $idProducto = $_GET['id'];
    }

    if(($admin['rol'] == "superuser" || $admin['rol'] == "gestor") && $idProducto){
        $id_sneaker = deleteProducto($mysqli, $idProducto);
        header("Location: index.php"); 
    }
?>