<?php

declare(strict_types=1);

function isEmpty(string $username, string $password){
    if(empty($username) || empty($password)){
        return true;
    } else {
        return false;
    }
}

function isUsernameExist(bool|array $result){
    if($result){
        return true;
    } else {
        return false;
    }
}

function isPasswordMatch(string $password, string $password_hash){
    // if(password_verify($password, $password_hash)){
    //     return true;
    // } else {
    //     return false;
    // }
    if($password === $password_hash){
        return true;
    } else {
        return false;
    }
}


