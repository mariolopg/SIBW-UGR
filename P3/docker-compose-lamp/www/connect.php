<?php

    function conectar(){
        $mysql = new mysqli("mysql", "admin", "SIBW2022", "sneakers");
        if($mysqli->connect_errno) {
            echo("Fallo al conectar: " . $mysqli->connect_error);
        }
        return $mysql;
    }
    
?>
