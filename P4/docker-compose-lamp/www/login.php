<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/login_register.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_POST['login-nickname'];
        $password = $_POST['login-password'];

        if(checkLogin($mysqli, $nickname, $password) && !empty($nickname) && !empty($password)){
            session_start();
            $_SESSION['user'] = $nickname;
            
            header("Location: index.php");
            exit();
        }
    }
     
    echo $twig->render('login.html');
?>