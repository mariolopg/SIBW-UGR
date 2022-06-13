<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $mysqli = conectar();

    $errores = array();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $newNickname = $_POST['new-nickname'];
        $newEmail = $_POST['new-email'];
        $password1 = $_POST['new-password1'];
        $password2 = $_POST['new-password2'];

        $user = $_SESSION['user'];

        if(!empty($newNickname) || !empty($newEmail) || (!empty($password1) && !empty($password2))){
            if(nicknameAvailable($mysqli, $newNickname) && !empty($newNickname)){
                $modificacion = true;
                actualizarDatos($mysqli, $user, $newNickname, "nickname");
                session_start();
                $_SESSION['user'] = $newNickname;
            }
            else if(!nicknameAvailable($mysqli, $newNickname) && !empty($newNickname))
                $errores['username'] = "Nombre de usuario no disponible";

            if(emailAvailable($mysqli, $newEmail) && !empty($newEmail) && checkEmail($newEmail)){
                $modificacion = true;
                actualizarDatos($mysqli, $user, $newEmail, "email");
            }
            else if(!emailAvailable($mysqli, $newEmail) && !empty($newEmail) && checkEmail($newEmail))
                $errores['email'] = "Correo electrónico no disponible";

            if(samePasswords($password1, $password2) && !empty($password1)){
                $modificacion = true;
                $newPassword = hashPassword($password1);
                actualizarDatos($mysqli, $user, $newPassword, "password");
            }
            else if(!samePasswords($password1, $password2) && !empty($password1))
                $errores['password'] = "Las contraseñas son distintas";

            if($modificacion){
                header("Location: index.php");
                exit();
            }
        }
    }

    if (isset($_SESSION['user'])) {
        $user = getUser($mysqli, $_SESSION['user']);
    }
     
    echo $twig->render('profile.html', ['user' => $user, 'errores' => $errores]);
?>