<?php

declare(strict_types=1);

function displayStudents(array|null $students): void {
   
    if($students !== null){
        foreach ($students as $student) {
            echo '<tr class="text-center even:bg-gray-50">';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['student_id']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['last_name']).', '.htmlspecialchars((string)$student['first_name']). '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['email']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['phone_number']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['enrollment_date']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$student['status']) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        
    } else {
        echo 'No students found!';
    }
}