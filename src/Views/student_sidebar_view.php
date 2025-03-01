<?php

declare(strict_types=1);

// Student Dashboard
$dashboardClass = (basename($_SERVER['PHP_SELF']) === 'student_dashboard.php') 
    ? 'bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white' 
    : 'pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white';

echo '<a href="' . BASE_URL . '/src/layouts/student_dashboard.php" class="w-full flex items-center gap-x-3 ' . $dashboardClass . ' transition-all duration-500 ease-linear font-normal text-lg p-1">
        <svg class="size-5" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="white" d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2zm0 26C9.373 28 4 22.627 4 16S9.373 4 16 4s12 5.373 12 12-5.373 12-12 12z"/><path d="M22.707 10.293a1 1 0 00-1.414 0L16 15.586l-5.293-5.293a1 1 0 00-1.414 1.414l6 6a1 1 0 001.414 0l6-6a1 1 0 000-1.414z"/></svg>
        Student Dashboard
    </a>';

// Student Profile
$profileClass = (basename($_SERVER['PHP_SELF']) === 'profile.php') 
    ? 'bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white' 
    : 'pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white';

echo '<a href="' . BASE_URL . '/src/layouts/student/profile.php" class="w-full flex items-center gap-x-3 ' . $profileClass . ' transition-all duration-500 ease-linear font-normal text-lg p-1">
        <svg class="size-5" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="white" d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2zm0 26C9.373 28 4 22.627 4 16S9.373 4 16 4s12 5.373 12 12-5.373 12-12 12z"/><path d="M16 8a4 4 0 110 8 4 4 0 010-8zm0 10c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z"/></svg>
        Profile
    </a>';

// Student Courses
$coursesClass = (basename($_SERVER['PHP_SELF']) === 'student_ledger.php') 
    ? 'pl-3 bg-blue-500 text-white rounded-l-full'
    : 'pl-3';

echo '<div class="relative w-full">';
echo '<button id="coursesButton" aria-expanded="false" onclick="toggleAccordion()" class="px-3 cursor-pointer w-full flex justify-between items-center gap-x-3 transition-all duration-500 ease-linear font-normal text-lg p-1">
        <div class="flex gap-x-3 items-center">        
            <svg class="size-5" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="white" d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2zm0 26C9.373 28 4 22.627 4 16S9.373 4 16 4s12 5.373 12 12-5.373 12-12 12z"/><path d="M10 10h12v2H10zm0 4h12v2H10zm0 4h12v2H10z"/></svg>
            Courses
        </div>
       <svg id="caretCourses" class="size-5" height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon points="396.6,160 416,180.7 256,352 96,180.7 115.3,160 256,310.5 "/></svg>
    </button>';

echo '<div id="coursesAccordion" class="overflow-hidden transition-all duration-300 max-h-0 mt-1 bg-white border border-gray-200 rounded-md ">';
echo '<a href="' . BASE_URL . '/src/layouts/student_ledger.php" class="block px-4 py-2 ' . $coursesClass . ' hover:bg-blue-500 hover:text-white" style="background-color: #212529;">Student Ledger</a>';
echo '</div>';
echo '</div>';


?>

<script>
    const coursesButton = document.getElementById('coursesButton');
    const coursesAccordion = document.getElementById('coursesAccordion');
    const caretIcon = document.getElementById('caretCourses');

    function toggleAccordion() {
        const isExpanded = coursesButton.getAttribute('aria-expanded') === 'true';
        coursesButton.setAttribute('aria-expanded', !isExpanded);
        
        // Toggle max-height for smooth accordion effect
        if (isExpanded) {
            coursesAccordion.style.maxHeight = '0';
            caretIcon.style.transform = 'rotate(0deg)'; 
        } else {
            coursesAccordion.style.maxHeight = coursesAccordion.scrollHeight + 'px';
            caretIcon.style.transform = 'rotate(180deg)';
          
        }
    }

 
</script>