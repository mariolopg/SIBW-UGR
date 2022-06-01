<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("src/connect.php");
    include("src/bd.php");
    include("src/comments.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    session_start();

    $mysqli = conectar();

    if (isset($_SESSION['user'])) {
        $user = getUser($mysqli, $_SESSION['user']);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comment = json_decode(file_get_contents('php://input'));

        if($user){
            addComment($mysqli, $comment[0], $comment[1], $comment[2], $comment[3]);
        }
    }
?>