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
        if(isset($_GET['id'])){
            $userAEditar = getUserById($mysqli, $_GET['id']);
        };

        $roles = getRoles($mysqli);
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $newNickname = $_POST['new-nickname'];
            $newEmail = $_POST['new-email'];
            $newRol = $_POST['new-rol'];
            
            $userAEditar = getUserById($mysqli, $_POST['user-id']);
    
            if(!empty($newNickname) || !empty($newEmail) || ($newRol != $userAEditar['rol'])){
                if(nicknameAvailable($mysqli, $newNickname) && !empty($newNickname)){
                    if($userAEditar['nickname'] == $user['nickname']){
                        $_SESSION['user'] = $newNickname;
                    }
                    $modificacion = true;
                    actualizarDatosById($mysqli, $userAEditar['id'], $newNickname, "nickname");
                }
    
                if(emailAvailable($mysqli, $newEmail) && !empty($newEmail) && checkEmail($newEmail)){
                    $modificacion = true;
                    actualizarDatosById($mysqli, $userAEditar['id'], $newEmail, "email");
                }
    
                if($newRol != $userAEditar['rol']){
                    $modificacion = true;
                    actualizarDatosById($mysqli, $userAEditar['id'], $newRol, "rol");
                }
    
                if($modificacion){
                    header("Location: editar_usuario.php?id=" . $userAEditar['id']);
                    exit();
                }
            }
        }
         
        echo $twig->render('editar_usuarios.html', ['user' => $user, 'userAEditar' => $userAEditar, 'roles' => $roles]);
    }
?>