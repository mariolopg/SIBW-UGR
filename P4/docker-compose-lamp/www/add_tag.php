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

    if(isset($_GET['id'])){
        $idSneaker = $_GET['id'];
    }

    if(($user['rol'] == "superuser" || $user['rol'] == "gestor")){
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $newTag = $_POST['new-tag'];
            $idSneaker = $_POST['sneaker-id'];
            
            if(!empty($newTag)){
                addTag($mysqli, $idSneaker, $newTag);
                header("Location: producto.php?id=" . $idSneaker);
                exit();
            }
        }
        
        echo $twig->render('add_tag.html', ['user' => $user, 'id' => $idSneaker]);
    }
?>