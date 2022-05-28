<?php

    function samePasswords($pass1, $pass2){
        if($pass1 == $pass2)
            return true;
        return false;
    }

    function nicknameAvailable($mysqli, $nickname){
        $nickname = $mysqli->real_escape_string($nickname);
        $res = $mysqli->query("SELECT * FROM usuarios WHERE nickname='" . $nickname . "'");
        $available = true;
        if($res->num_rows > 0){
            $available = false;
        }
        return $available;
    }

    function emailAvailable($mysqli, $email){
        $email = $mysqli->real_escape_string($email);
        $res = $mysqli->query("SELECT * FROM usuarios WHERE email='" . $email . "'");
        $available = true;
        if($res->num_rows > 0){
            $available = false;
        }
        return $available;
    }


    function registerUser($mysqli, $nickname, $email, $pass){
        $nickname = $mysqli->real_escape_string($nickname);
        $email = $mysqli->real_escape_string($email);
        $pass = $mysqli->real_escape_string($pass);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $mysqli->query("INSERT INTO usuarios (nickname email password rol) VALUES(" . $nickname . "," . $email . "," . $pass . ", default)");
    }

    // passwordSuperSeguro
    function checkLogin($mysqli, $nickname, $password){
        $res = $mysqli->query("SELECT * FROM usuarios WHERE nickname='" . $nickname . "'");
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