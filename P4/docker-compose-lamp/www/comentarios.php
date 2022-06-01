<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");
    include("src/comments.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();
    if (isset($_SESSION['user'])) {
        $admin = getUser($mysqli, $_SESSION['user']);
    }

    if($admin['rol'] == "superuser" || $admin['rol'] == "moderador"){
        $users = getUsers($mysqli);
        $comments = getAllDBComments($mysqli);
     
        echo $twig->render('comentarios.html', ['user' => $admin, 'comments' => $comments]);
    }
?>