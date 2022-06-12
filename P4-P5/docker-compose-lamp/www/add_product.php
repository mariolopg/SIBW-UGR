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

    $errores = array();

    if($user['rol'] == "superuser" || $user['rol'] == "gestor"){
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $sneakerName = $_POST['sneaker-name'];
            $sneakerDescription= $_POST['sneaker-description'];
            $sneakerPrice = $_POST['sneaker-price'];
            $estado = $_POST['estado'];
            $sneakerImages = $_FILES['sneaker-images'];

            $imageName = $_FILES['sneaker-images']['name'];
            $imageSize = $_FILES['sneaker-images']['size'];
            $fileExtension = $_FILES['sneaker-images']['type'];
            $imageExtension = strtolower(end(explode(".", $imageName)));
            $extensions = array("jpeg", "jpg", "png");

            $file_tmp = $_FILES['sneaker-images']['tmp_name'];

            if($estado == "sin publicar"){
                $id = addProduct($mysqli, $sneakerName, $sneakerDescription, $sneakerPrice, $estado);
                if($imageSize > 0 && in_array($imageExtension, $extensions)){
                    move_uploaded_file($file_tmp, "static/image/" . $imageName);
                    addImage($mysqli, $id, $imageName);
                }
                header("Location: index.php");
                exit();
            }
            else
                if(!empty($sneakerName) && !empty($sneakerDescription) && !empty($sneakerPrice)){

                    $id = addProduct($mysqli, $sneakerName, $sneakerDescription, $sneakerPrice, $estado);
                    
                    if($imageSize > 0 && in_array($imageExtension, $extensions)){
                        move_uploaded_file($file_tmp, "static/image/" . $imageName);
    
                        $id = addProduct($mysqli, $sneakerName, $sneakerDescription, $sneakerPrice, $estado);
                        addImage($mysqli, $id, $imageName);
                    }

                    header("Location: index.php");
                    exit();
                }
                else{
                    if(empty($sneakerName))
                        $errores['sneakerName'] = "El campo no puede estar vacío";

                    if(empty($sneakerDescription))
                        $errores['sneakerDescription'] = "El campo no puede estar vacío";

                    if(empty($sneakerPrice))
                        $errores['sneakerPrice'] = "El campo no puede estar vacío";
                }
        }
        
        echo $twig->render('add_product.html', ['user' => $user, 'sneakerName' => $sneakerName, 'sneakerDescription' => $sneakerDescription, 'sneakerPrice' => $sneakerPrice, 'errores' => $errores]);
    }
     
?>