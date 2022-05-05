<?php

    function getInfo($id, $mysqli){
        $id = $mysqli->real_escape_string($id);
        $res = $mysqli->query("SELECT * FROM sneakersInfo WHERE id=" . $id);

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

    function getImages($id, $mysqli){
        $res = $mysqli->query("SELECT image FROM sneakersImages WHERE id_sneaker=" . $id);

        $rows = array();
        $info = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
            
            foreach ($rows as $key => $row) {
                $info[$key] = ['image' => base64_encode($row['image'])];
            }
        }
        
        return $info;
    }

    function getComments($id, $mysqli){
        $id = $mysqli->real_escape_string($id);
        $res = $mysqli->query("SELECT * FROM sneakersComments WHERE id_sneaker=" . $id);

        $rows = array();
        $info = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
            
            foreach ($rows as $key => $row) {
                $info[$key] = ['user' => $row['user'], 'comment' => $row['comment'], 'date' => date('d/m/Y', strtotime($row['date']))];
            }
        }
        
        return $info;
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
            $name = getInfo($i, $mysqli);
            $images = getImages($i, $mysqli);
            $info[$i] = ['id' => $name['id'], 'nombre' => $name['nombre'], 'images' => $images[0]];
        }

        return $info;
    }

?>