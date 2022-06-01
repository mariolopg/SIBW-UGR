<?php

    function samePasswords($pass1, $pass2){
        if($pass1 == $pass2)
            return true;
        return false;
    }

    function nicknameAvailable($mysqli, $nickname){
        $res = $mysqli->prepare("SELECT * FROM usuarios WHERE nickname =?");
        $res->bind_param("s", $nickname);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $available = true;
        if($res->num_rows > 0){
            $available = false;
        }
        return $available;
    }

    function emailAvailable($mysqli, $email){
        $res = $mysqli->prepare("SELECT * FROM usuarios WHERE email=?");
        $res->bind_param("s", $email);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        $available = true;
        if($res->num_rows > 0){
            $available = false;
        }
        return $available;
    }


    function registerUser($mysqli, $nickname, $email, $pass){
        $pass = hashPassword($pass);
        $mysqli->query("INSERT INTO usuarios (nickname, email, password, rol) VALUES('" . $nickname . "','" . $email . "','" . $pass . "', 'default')");
    }

    function checkLogin($mysqli, $nickname, $password){
        $res = $mysqli->prepare("SELECT * FROM usuarios WHERE nickname=?");
        $res->bind_param("s", $nickname);

        if(!$res->execute()){
            echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
        }

        $res = $res->get_result();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $bdPassword = $row['password'];
            if(password_verify($password, $bdPassword)){
                return true;
            }
        }

        return false;
    }

    function actualizarDatos($mysqli, $nickname, $newData, $column){
        // TODO: si la columna es rol => comprobar que no es superusuario / si es el único no se puede cambiar
        $puedeCambiar = true;
        if($column == "rol"){
            $usuario = getUser($mysqli, $nickname);
            if($usuario['rol'] == "superuser" && numberSuperUsers($mysqli) == 1){
                $puedeCambiar = false;
            }
        }
        if($puedeCambiar){
            $res = $mysqli->prepare("UPDATE usuarios SET " . $column . "=? WHERE nickname=?");
            $res->bind_param("ss", $newData, $nickname);

            if(!$res->execute()){
                echo("Falló la ejecución: (" . $res->errno . ")" . $res->error);
            }
        }
    }

    function numberSuperUsers($mysqli){
        $usuarios = getUsers($mysqli);
        $numSU = 0;
        for($i = 0; $i < count($usuarios); $i++){
            if($usuarios[$i]['rol'] == "superuser"){
                $numSU++;
            }
        }
        return $numSU;
    }

    function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function checkEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function getUsers($mysqli){
        $res = $mysqli->query("SELECT * FROM usuarios");

        $rows = array();

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $rows[] = $row;
            }
        }
        
        return $rows;
    }
?>