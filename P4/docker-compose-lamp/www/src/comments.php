<?php
    function parseComment($comment){

    }

    function addComment($mysqli, $id_sneaker, $nickname, $email, $comment, $fecha){
        $res = $mysqli->prepare("INSERT INTO sneakersComments (id_sneaker, user, email, fecha, comment, editado) VALUES('" . $id_sneaker . "','" . $nickname . "','" . $email . "','" . $fecha . "','" . $comment . "', 'false')");
        $res->bind_param("sssss", $id_sneaker, $nickname, $email, $fecha, $comment);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();
    }
?>