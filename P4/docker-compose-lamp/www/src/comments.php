<?php
    function addComment($mysqli, $id_sneaker, $user_id, $comment, $fecha){
        $res = $mysqli->prepare("INSERT INTO sneakersComments (id_sneaker, user_id, fecha, comment, editado) VALUES('" . $id_sneaker . "','" . $user_id . "','" . $fecha . "','" . $comment . "', 'false')");
        $res->bind_param("ssss", $id_sneaker, $user_id, $fecha, $comment);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();
    }

    function getComment($mysqli, $id){
        $res = $mysqli->prepare("SELECT * from sneakersComments WHERE id=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $row = array();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
        }

        return $row;
    }

    function deleteComment($mysqli, $id){
        $idSneaker = getComment($mysqli, $id)['id_sneaker'];

        $res = $mysqli->prepare("DELETE from sneakersComments WHERE id=?");
        $res->bind_param("i", $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        return $idSneaker;
    }

    function updateComment($mysqli, $id, $newData, $column){
        $res = $mysqli->prepare("UPDATE sneakersComments SET " . $column . "=? WHERE id=?");
        $res->bind_param("si", $newData, $id);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }
    }
?>