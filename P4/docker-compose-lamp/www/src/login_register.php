<?php

    function samePasswords($pass1, $pass2){
        if($pass1 == $pass2)
            return 1;
        return 0;
    }

    function nicknameAviable($mysqli, $nickname){
        $nickname = $mysqli->real_escape_string($nickname);
        $res = $mysqli->query("SELECT * FROM usuarios WHERE nickname=" . $nickname);
        $aviable = 1;
        if($res->num_rows > 0){
            $aviable = 0;
        }
        return $aviable;
    }

    function emailAviable($mysqli, $email){
        $email = $mysqli->real_escape_string($email);
        $res = $mysqli->query("SELECT * FROM usuarios WHERE email=" . $email);
        $aviable = 1;
        if($res->num_rows > 0){
            $aviable = 0;
        }
        return $aviable;
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
        $res = $mysqli->query("SELECT * FROM usuarios WHERE nickname=" . $nickname);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $bdPassword = $row['password'];
            if(password_verify($password, $bdPassword)){
                return 1;
            }
        }

        return 0;
    }
?>