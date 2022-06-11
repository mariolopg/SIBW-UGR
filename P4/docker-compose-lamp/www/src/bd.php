<?php
    function getInfo($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM sneakersInfo WHERE id = ?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
        }

        return $row;
    }

    function getImages($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM sneakersImages WHERE id_sneaker = ?");
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
            $sneaker = getInfo($mysqli, $row['id']);
            $images = getImages($mysqli, $row['id']);
            $info[] = ['sneaker' => $sneaker, 'image_name' => $images[0]['image_name']];
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

    function addProduct($mysqli, $name, $description, $price, $estado){
        $mysqli->query("INSERT INTO sneakersInfo (name, description, precio, estado, valoraciones) VALUES('" . $name . "','" . $description . "','" . intval($price) . "','" . $estado . "', 0)");
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

    function updateProducto($mysqli, $idProducto, $newData, $column){
        $res = $mysqli->prepare("UPDATE sneakersInfo SET " . $column . "=? WHERE id=?");

        $res->bind_param("ss", $newData, $idProducto);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }
    }

    function getTags($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM tags WHERE id_sneaker=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $rows = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
        }

        return $rows;
    }

    function addTag($mysqli, $id, $tag){
        if(tagAvailable($mysqli, $id, $tag)){
            $res = $mysqli->prepare("INSERT INTO tags (id_sneaker, tag) VALUES(?,?)");
            $res->bind_param("is", $id, $tag);

            if(!$res->execute()){
                echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
            }

            $res->close();
        }
    }

    function tagAvailable($mysqli, $id, $tag){
        $res = $mysqli->prepare("SELECT * FROM tags WHERE id_sneaker=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                if($row['tag'] == $tag)
                    return false;
            }
        }

        return true;
    }

    function deleteImagen($mysqli, $id){
        $res = $mysqli->prepare("SELECT * FROM sneakersImages WHERE id=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $id_sneaker = ($res->get_result())->fetch_assoc()['id_sneaker'];

        $res = $mysqli->prepare("DELETE FROM sneakersImages WHERE id=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        return $id_sneaker;
    }
?>