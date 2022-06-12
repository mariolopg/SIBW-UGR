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
        $idProducto = $_GET['id'];
    }

    if(($user['rol'] == "superuser" || $user['rol'] == "moderador") && $idProducto){

        $producto = getInfo($mysqli, $idProducto);
        $images = getImages($mysqli, $idProducto);
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $sneakerName = $_POST['sneaker-name'];
            $sneakerDescription= $_POST['sneaker-description'];
            $sneakerPrice = $_POST['sneaker-price'];
            $sneakerImages = $_FILES['sneaker-images'];
            $sneakerId = $_POST['sneaker-id'];
            $estado = $_POST['estado'];

            $imageName = $_FILES['sneaker-images']['name'];
            $imageSize = $_FILES['sneaker-images']['size'];
            $fileExtension = $_FILES['sneaker-images']['type'];
            $imageExtension = strtolower(end(explode(".", $imageName)));
            $extensions = array("jpeg", "jpg", "png");

            $cambio = false;

            if($producto['estado'] != $estado)
                $cambio = true;
            
            if(!empty($sneakerName) || !empty($sneakerDescription) || !empty($sneakerPrice) || ($imageSize > 0 && in_array($imageExtension, $extensions)) || $cambio){
                
                updateProducto($mysqli, $sneakerId, $estado, "estado");
                
                if(!empty($sneakerName)){
                    updateProducto($mysqli, $sneakerId, $sneakerName, "name");
                }

                if(!empty($sneakerDescription)){
                    updateProducto($mysqli, $sneakerId, $sneakerDescription, "description");
                }

                if(!empty($sneakerPrice)){
                    updateProducto($mysqli, $sneakerId, $sneakerPrice, "precio");
                }

                if($imageSize > 0 && in_array($imageExtension, $extensions)){
                    $file_tmp = $_FILES['sneaker-images']['tmp_name'];
                    move_uploaded_file($file_tmp, "static/image/" . $imageName);
                    addImage($mysqli, $sneakerId, $imageName);
                }
                
                header("Location: producto.php?id=" . $idProducto);
                exit();
            }
        }
        
        

        echo $twig->render('edit_producto.html', ['user' => $user, 'producto' => $producto, 'images' => $images]);
    }
     
?>