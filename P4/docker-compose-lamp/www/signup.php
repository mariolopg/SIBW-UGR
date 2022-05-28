<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/login_register.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_POST['signup-nickname'];
        $email = $_POST['signup-email'];
        $password1 = $_POST['signup-password1'];
        $password2 = $_POST['signup-password2'];

        $nickAviable = nicknameAviable($mysqli, $nickname);
        $emailAviable = nicknameAviable($mysqli, $email); 
        $passwordCorrect = samePasswords($password1, $password2);

        if($nickAviable && $emailAviable && $passwordCorrect){
            registerUser($mysqli, $nickname, $email, $password1);
            session_start();
            $_SESSION['nickname'] = $nickname;
            
            header("Location: index.php");
            exit();
        }
    }

    echo $twig->render('signup.html');
?>