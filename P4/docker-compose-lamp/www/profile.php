<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $newNickname = $_POST['new-nickname'];
        $newEmail = $_POST['new-email'];
        $password1 = $_POST['new-password1'];
        $password2 = $_POST['new-password2'];

        $user = $_SESSION['user'];

        if(!empty($newNickname) || !empty($newEmail) || (!empty($password1) && !empty($password2))){
            if(nicknameAvailable($mysqli, $nickname) && !empty($newNickname)){
                $modificacion = true;
                actualizarNickname($mysqli, $user, $newNickname);
                session_start();
                $_SESSION['user'] = $newNickname;
            }

            if(emailAvailable($mysqli, $newEmail) && !empty($newEmail)){
                $modificacion = true;
                actualizarEmail($mysqli, $user, $newEmail);
            }

            if(samePasswords($password1, $password2) && !empty($password1)){
                $modificacion = true;
                actualizarPassword($mysqli, $user, $password1);
            }

            if($modificacion){
                header("Location: index.php");
                exit();
            }
        }
    }
     
    echo $twig->render('profile.html');
?>