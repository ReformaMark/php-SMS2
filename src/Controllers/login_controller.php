<?php

declare(strict_types=1);

function isUsernameEmpty(string $username){
    if(empty($username)){
        return true;
    } else {
        return false;
    }
}
function isPasswordEmpty(string $password){
    if(empty($password)){
        return true;
    } else {
        return false;
    }
}

function isUsernameExist(object $pdo, string $username){
    $result = getUsername($pdo, $username);
    
    if($result){
        return true;
    } else {
        return false;
    }
}

function isPasswordMatch(string $password, string $password_hash){
    if(password_verify($password, $password_hash)){
        return true;
    } else {
        return false;
    }
}


