<?php

require_once '../Models/student_model.php';

function getStudents($pdo, $isArchived, $filter, $offset, $limit) {
    return fetchStudents($pdo, $filter, $offset, $limit, $isArchived);
}
