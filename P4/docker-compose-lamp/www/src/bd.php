<?php
    function getInfo($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM sneakersInfo WHERE id = ?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $nombre = 'no_name';
        $descripcion = 'no_description';
        $precio = 'no_price';
        $valoraciones = '??';

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $nombre = $row['name'];
            $descripcion = $row['description'];
            $precio = $row['precio'];
            $valoraciones = $row['valoraciones'];
        }

        return ['id' => $id, 'nombre' => $nombre, 'descripcion' => $descripcion, 'precio' => $precio, 'valoraciones' => $valoraciones];
    }

    function getImages($mysqli, $id){
        $res = $mysqli->prepare("SELECT image_name FROM sneakersImages WHERE id_sneaker = ?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $rows = array();
        $info = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
            
            foreach ($rows as $key => $row) {
                $info[$key] = ['image_name' => $row['image_name']];
            }
        }
        
        return $info;
    }

    function getComments($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM sneakersComments WHERE id_sneaker = ? ORDER BY id DESC");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $rows = array();
        $info = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
        }
        
        return $rows;
    }

    function getBadWords($mysqli){
        $res = $mysqli->query("SELECT * FROM badWords");
        $info = array();

        while($row = $res->fetch_assoc())
            $info[] = $row['word'];
        
        return json_encode($info);
    }

    function getGallery($mysqli){
        $res = $mysqli->query("SELECT * FROM sneakersInfo");
        $info = array();
        while($row = $res->fetch_assoc()){
            $name = getInfo($mysqli, $row['id']);
            $images = getImages($mysqli, $row['id']);
            $info[] = ['id' => $name['id'], 'nombre' => $name['nombre'], 'image_name' => $images[0]['image_name']];
        }

        return $info;
    }

    function getUser($mysqli, $user){
        $res = $mysqli->prepare("SELECT * FROM usuarios WHERE nickname = ?");
        $res->bind_param("s", $user);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
        }

        return $row;
    }

    function getRoles($mysqli){
        $res = $mysqli->query("SELECT * FROM roles");

        $rows = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
        }
        
        return $rows;
    }

    function addProduct($mysqli, $name, $description, $price){
        $mysqli->query("INSERT INTO sneakersInfo (name, description, precio, valoraciones) VALUES('" . $name . "','" . $description . "','" . intval($price) . "', 0)");
        $res = $mysqli->query("SELECT * FROM sneakersInfo ORDER BY id DESC LIMIT 0, 1");
        
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $id = $row['id'];
        }

        return $id;
    }
    
    function addImage($mysqli, $id, $nombreImagen){
        $res = $mysqli->prepare("INSERT INTO sneakersImages (id_sneaker, image_name) VALUES(?,?)");
        $res->bind_param("is", $id, $nombreImagen);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res->close();
    }

    function deleteProducto($mysqli, $id){
        $res = $mysqli->prepare("DELETE from sneakersInfo WHERE id=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        return $idSneaker;
    }
?>