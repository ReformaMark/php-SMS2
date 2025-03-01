<?php

declare(strict_types=1);

// Student Dashboard
$dashboardClass = (basename($_SERVER['PHP_SELF']) === 'student_dashboard.php') 
    ? 'bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white' 
    : 'pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white';

echo '<a href="' . BASE_URL . '/src/layouts/student_dashboard.php" class="w-full text-white flex items-center gap-x-3 ' . $dashboardClass . ' transition-all duration-500 ease-linear font-normal text-lg p-1">
        <svg class="size-5" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M127.12,60.22,115.46,48.56h0L69,2.05a7,7,0,0,0-9.9,0L12.57,48.53h0L.88,60.22a3,3,0,0,0,4.24,4.24l6.57-6.57V121a7,7,0,0,0,7,7H46a7,7,0,0,0,7-7V81a1,1,0,0,1,1-1H74a1,1,0,0,1,1,1v40a7,7,0,0,0,7,7h27.34a7,7,0,0,0,7-7V57.92l6.54,6.54a3,3,0,0,0,4.24-4.24Z"/>
                </svg>
        Student Dashboard
    </a>';

// Student Profile
$profileClass = (basename($_SERVER['PHP_SELF']) === 'profile.php') 
    ? 'bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white' 
    : 'pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white';

echo '<a href="' . BASE_URL . '/src/layouts/student/profile.php" class="w-full flex text-white items-center gap-x-3 ' . $profileClass . ' transition-all duration-500 ease-linear font-normal text-lg p-1">
         <svg class="size-5" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><path fill="currentColor" d="M226.5,56.4l-96-32a8.5,8.5,0,0,0-5,0l-95.9,32h-.2l-1,.5h-.1l-1,.6c0,.1-.1.1-.2.2l-.8.7h0l-.7.8c0,.1-.1.1-.1.2l-.6.9c0,.1,0,.1-.1.2l-.4.9h0l-.3,1.1v.3A3.7,3.7,0,0,0,24,64v80a8,8,0,0,0,16,0V75.1L73.6,86.3A63.2,63.2,0,0,0,64,120a64,64,0,0,0,30,54.2,96.1,96.1,0,0,0-46.5,37.4,8.1,8.1,0,0,0,2.4,11.1,7.9,7.9,0,0,0,11-2.3,80,80,0,0,1,134.2,0,8,8,0,0,0,6.7,3.6,7.5,7.5,0,0,0,4.3-1.3,8.1,8.1,0,0,0,2.4-11.1A96.1,96.1,0,0,0,162,174.2,64,64,0,0,0,192,120a63.2,63.2,0,0,0-9.6-33.7l44.1-14.7a8,8,0,0,0,0-15.2ZM128,168a48,48,0,0,1-48-48,48.6,48.6,0,0,1,9.3-28.5l36.2,12.1a8,8,0,0,0,5,0l36.2-12.1A48.6,48.6,0,0,1,176,120,48,48,0,0,1,128,168Z"/></svg>
        Profile
    </a>';

// Student Courses
$coursesClass = (basename($_SERVER['PHP_SELF']) === 'student_ledger.php') 
    ? 'pl-3 bg-blue-500 text-white rounded-l-full'
    : 'pl-3';

echo '<div class="relative w-full text-white">';
echo '<button id="coursesButton" aria-expanded="false" onclick="toggleAccordion()" class="px-3 cursor-pointer w-full flex justify-between items-center gap-x-3 transition-all duration-500 ease-linear font-normal text-lg p-1">
        <div class="flex gap-x-3 text-white items-center">        
            <svg class="size-5" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="white" d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2zm0 26C9.373 28 4 22.627 4 16S9.373 4 16 4s12 5.373 12 12-5.373 12-12 12z"/><path d="M10 10h12v2H10zm0 4h12v2H10zm0 4h12v2H10z"/></svg>
            Courses
        </div>
       <svg id="caretCourses" class="size-5" height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon points="396.6,160 416,180.7 256,352 96,180.7 115.3,160 256,310.5 "/></svg>
    </button>';

echo '<div id="coursesAccordion" class="overflow-hidden transition-all duration-300 max-h-0 mt-1  border border-gray-200 rounded-md ">';
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