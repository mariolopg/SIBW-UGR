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
        $user = getUser($mysqli, $_SESSION['user']);
    }

    if(isset($_GET['id'])){
        $idComentario = $_GET['id'];
    }

    if(($user['rol'] == "superuser" || $user['rol'] == "moderador")){
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $newComment = $_POST['new-comment'];
            $idComentario = $_POST['id-comment'];
            
            if(!empty($newComment)){
                updateComment($mysqli, $idComentario, $newComment, "comment");
                updateComment($mysqli, $idComentario, "true", "editado");
                header("Location: index.php");
                exit();
            }
        }
        else if($idComentario){
            $comment = getComment($mysqli, $idComentario);
            echo $twig->render('edit_comment.html', ['user' => $user, 'comment' => $comment]);
        }
         
    }
?>