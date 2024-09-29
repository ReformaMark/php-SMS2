<?php

declare(strict_types=1);

function  isUsernameRegistered (object $pdo, string $username){
    if(getUsername($pdo, $username)){
        return true;
    }else{
        return false;
    }
}

function createUser (object $pdo, string $username, string $password){
    setUser($pdo, $username, $password);
}

