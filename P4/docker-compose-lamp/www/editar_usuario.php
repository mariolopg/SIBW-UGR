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
        $user = getUser($mysqli, $_SESSION['user']);
    }

    if($user['rol'] == "superuser"){
        if(isset($_GET['nickname'])){
            $userAEditar = getUser($mysqli, $_GET['nickname']);
        };
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $newNickname = $_POST['new-nickname'];
            $newEmail = $_POST['new-email'];
            $newRol = $_POST['new-rol'];
            
            $userNickname = $_POST['user-nickname'];
            $userAEditar = getUser($mysqli, $userNickname);
    
            if(!empty($newNickname) || !empty($newEmail) || ($newRol != $userAEditar['rol'])){
                if(nicknameAvailable($mysqli, $newNickname) && !empty($newNickname)){
                    $modificacion = true;
                    actualizarDatos($mysqli, $userNickname, $newNickname, "nickname");
                }
    
                if(emailAvailable($mysqli, $newEmail) && !empty($newEmail) && checkEmail($newEmail)){
                    $modificacion = true;
                    actualizarDatos($mysqli, $userNickname, $newEmail, "email");
                }
    
                if($newRol != $userAEditar['rol']){
                    $modificacion = true;
                    actualizarDatos($mysqli, $userNickname, $newRol, "rol");
                }
    
                if($modificacion){
                    header("Location: usuarios.php");
                    exit();
                }
            }
        }
         
        echo $twig->render('editar_usuarios.html', ['user' => $user, 'userAEditar' => $userAEditar]);
    }
?>