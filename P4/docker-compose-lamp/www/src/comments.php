<?php
    function parseComment($comment){

    }

    function addComment($mysqli, $id_sneaker, $user_id, $comment, $fecha){
        $res = $mysqli->prepare("INSERT INTO sneakersComments (id_sneaker, user_id, fecha, comment, editado) VALUES('" . $id_sneaker . "','" . $user_id . "','" . $fecha . "','" . $comment . "', 'false')");
        $res->bind_param("ssss", $id_sneaker, $user_id, $fecha, $comment);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();
    }
?>