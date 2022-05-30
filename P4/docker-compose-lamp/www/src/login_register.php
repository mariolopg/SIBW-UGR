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
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $mysqli->query("INSERT INTO usuarios (nickname, email, password, rol) VALUES('" . $nickname . "','" . $email . "','" . $pass . "', 'default')");
    }

    // passwordSuperSeguro
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
?>