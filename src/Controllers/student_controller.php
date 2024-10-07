<?php

declare(strict_types=1);

function isEmpty(array $result) {
    // Check if the array is not empty
    if (empty($result)) {
        return true;
    } else {
        return false; 
    }
};

function createStudent (object $pdo, string $firstName, string $lastName, string $birthDate,string $gender, string $email,string $phoneNumber,string $enrollmentDate,string $status ){
    setStudent( $pdo,  $firstName,  $lastName,$birthDate, $gender, $email, $phoneNumber, $enrollmentDate, $status );
}