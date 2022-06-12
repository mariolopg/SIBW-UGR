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

    $errores = array();

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
            
            if($estado == "sin publicar"){
                updateProducto($mysqli, $sneakerId, $estado, "estado");
                updateProducto($mysqli, $sneakerId, $sneakerName, "name");
                updateProducto($mysqli, $sneakerId, $sneakerDescription, "description");
                updateProducto($mysqli, $sneakerId, $sneakerPrice, "precio");
                
                if($imageSize > 0 && in_array($imageExtension, $extensions)){
                    $file_tmp = $_FILES['sneaker-images']['tmp_name'];
                    move_uploaded_file($file_tmp, "static/image/" . $imageName);
                    addImage($mysqli, $sneakerId, $imageName);
                }
                
                header("Location: producto.php?id=" . $idProducto);
                exit();

            }
            else if(!empty($sneakerName) && !empty($sneakerDescription) && !empty($sneakerPrice)){
                updateProducto($mysqli, $sneakerId, $estado, "estado");
                updateProducto($mysqli, $sneakerId, $sneakerName, "name");
                updateProducto($mysqli, $sneakerId, $sneakerDescription, "description");
                updateProducto($mysqli, $sneakerId, $sneakerPrice, "precio");

                if($imageSize > 0 && in_array($imageExtension, $extensions)){
                    $file_tmp = $_FILES['sneaker-images']['tmp_name'];
                    move_uploaded_file($file_tmp, "static/image/" . $imageName);
                    addImage($mysqli, $sneakerId, $imageName);
                }

                header("Location: producto.php?id=" . $idProducto);
                exit();
            }
            else {
                $producto['name'] = $sneakerName;
                $producto['description'] = $sneakerDescription;
                $producto['price'] = $sneakerPrice;

                if(empty($sneakerName))
                    $errores['sneakerName'] = "El campo no puede estar vacío";

                if(empty($sneakerDescription))
                    $errores['sneakerDescription'] = "El campo no puede estar vacío";

                if(empty($sneakerPrice))
                    $errores['sneakerPrice'] = "El campo no puede estar vacío";
            }

        }
        
        

        echo $twig->render('edit_producto.html', ['user' => $user, 'producto' => $producto, 'images' => $images, 'errores' => $errores]);
    }
     
?>