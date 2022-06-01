<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();
    if (isset($_SESSION['user'])) {
        $admin = getUser($mysqli, $_SESSION['user']);
    }

    if($admin['rol'] == "superuser"){
        $users = getUsers($mysqli);
     
        echo $twig->render('usuarios.html', ['user' => $admin, 'users' => $users]);
    }
?>