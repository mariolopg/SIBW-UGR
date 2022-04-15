<?php

    function getInfo($id, $mysqli){
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

        return ['nombre' => $nombre, 'descripcion' => $descripcion, 'precio' => $precio, 'valoraciones' => $valoraciones];
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

    function getRudeWords($mysqli){
        $res = $mysqli->query("SELECT * FROM badWords");

        $badWords = array();
        $info = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
            
            foreach ($rows as $key => $row) {
                $info[$key] = ['word' => base64_encode($row['word'])];
            }
        }
        
        return $info;

    }

?>