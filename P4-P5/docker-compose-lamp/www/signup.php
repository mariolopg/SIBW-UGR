<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/user.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mysqli = conectar();

    $errores = array();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_POST['signup-nickname'];
        $email = $_POST['signup-email'];
        $password1 = $_POST['signup-password1'];
        $password2 = $_POST['signup-password2'];

        if(!empty($nickname) && !empty($email) && !empty($password1) && checkEmail($email)){

            $nickAvailable = nicknameAvailable($mysqli, $nickname);
            $emailAvailable = emailAvailable($mysqli, $email); 
            $passwordCorrect = samePasswords($password1, $password2);

            if($nickAvailable && $emailAvailable && $passwordCorrect){
                registerUser($mysqli, $nickname, $email, $password1);
                session_start();
                $_SESSION['user'] = $nickname;
                
                header("Location: index.php");
                exit();
            }
            else {
                if(!$nicknameAvailable)
                    $errores['username'] = "Nombre de usuario no disponible";

                if(!$emailAvailable)
                    $errores['email'] = "Nombre de usuario no disponible";

                if(!$passwordCorrect)
                    $errores['passwords'] = "Las contraseñas no coinciden";
            }
        }
        else{
            if(empty($nickname))
                $errores['username'] = "El campo no puede estar vacío";

            if(empty($email))
                $errores['email'] = "El campo no puede estar vacío";

            if(empty($password1))
                $errores['password1'] = "El campo no puede estar vacío";

            if(empty($password2))
                $errores['password2'] = "El campo no puede estar vacío";
        }
    }

    echo $twig->render('signup.html', ['errores' => $errores, 'username' => $nickname, 'email' => $email]);
?>