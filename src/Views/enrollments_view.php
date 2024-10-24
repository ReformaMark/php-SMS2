<?php

declare(strict_types=1);

if (!function_exists('displayStudents')) {
    function displayStudents(array|null $students): void {
        if ($students !== null) {
            foreach ($students as $student) {
                echo '<tr class="border-b border-gray-200 hover:bg-gray-100">';
                echo '<td class="py-3 px-6 text-center whitespace-nowrap">' . htmlspecialchars((string)$student['username']) . '</td>';
                echo '<td class="py-3 px-6 text-center">' . htmlspecialchars((string)$student['last_name']) . ', ' . htmlspecialchars((string)$student['first_name']) . '</td>';
                echo '<td class="py-3 px-6 text-center">' . htmlspecialchars((string)$student['email']) . '</td>';
                echo '<td class="py-3 px-6 text-center">' . htmlspecialchars((string)$student['phone_number']) . '</td>';
                echo '<td class="py-3 px-6 text-center">' . htmlspecialchars((string)$student['enrollment_date']) . '</td>';
                
                // Style the status
                $statusClass = '';
                switch ($student['status']) {
                    case 'Active':
                        $statusClass = 'bg-green-200 text-green-600';
                        break;
                    case 'Inactive':
                        $statusClass = 'bg-red-200 text-red-600';
                        break;
                    case 'Graduated':
                        $statusClass = 'bg-blue-200 text-blue-600';
                        break;
                    case 'On Leave':
                        $statusClass = 'bg-yellow-200 text-yellow-600';
                        break;
                    default:
                        $statusClass = 'bg-gray-200 text-gray-600';
                        break;
                }
                echo '<td class="py-3 px-6 text-center"><span class="py-1 px-3 rounded-full text-xs ' . $statusClass . '">' . htmlspecialchars((string)$student['status']) . '</span></td>';
                
                // Add action buttons
                echo '<td class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">';
                
                // Conditional button for archive/recover
                if ($student['is_archived']) {
                    echo '<div class="w-4 mr-2 transform hover:text-green-500 hover:scale-110 cursor-pointer recover-btn" data-student-id="' . $student['user_id'] . '">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>';
                } else {
                    echo '<div class="w-4 mr-2 transform hover:text-rose-500 hover:scale-110 cursor-pointer archive-btn" data-student-id="' . $student['user_id'] . '">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>';
                }
                
                echo '</div></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7" class="py-3 px-6 text-center">No students found!</td></tr>';
        }
    }
}
