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
        $images = array();
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

    // function getRudeWords($mysqli){
    //     $res = $mysqli->query("SELECT * FROM badWords");

    //     $badWords = array();
    //     $info = array();

    //     if($res->num_rows > 0){
    //         while($row = $res->fetch_assoc()){
    //             $rows[] = $row;
    //         }
            
    //         foreach ($rows as $key => $row) {
    //             $info[$key] = ['word' => base64_encode($row['word'])];
    //         }
    //     }
        
    //     return $info;
    // }

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