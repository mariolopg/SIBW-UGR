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
        $numFilas = $mysqli->query("SELECT name FROM sneakersInfo")->num_rows;
        $info = array();


        for($i = 1; $i <= $numFilas; $i++){
            $name = getInfo($mysqli, $i);
            $images = getImages($mysqli, $i);
            $info[$i] = ['id' => $name['id'], 'nombre' => $name['nombre'], 'image_name' => $images[0]['image_name']];
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
?>