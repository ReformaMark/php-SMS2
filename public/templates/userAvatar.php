<div class="relative">
        <button id="avatar" aria-expanded="false" aria-haspopup="true" class="flex items-center gap-x-3 bg-white p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="relative flex size-10 shrink-0 overflow-hidden rounded-full bg-blue-600">
                <span class="flex items-center justify-center h-full w-full text-white font-medium text-lg">
                    <?php echo strtoupper($_SESSION['user_name'][0]) . strtoupper($_SESSION['user_lastname'][0]); ?>
                </span>
            </div>
            <span class="text-gray-700 font-medium">
                <?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_lastname']; ?>
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        
        <div id="dropdown" class="absolute right-0 mt-3 w-72 bg-white border border-gray-200 rounded-md shadow-xl z-10 hidden opacity-0 transform -translate-y-2 dropdown-transition">
    <div class="lg:flex">

        <?php if ($_SESSION['user_role'] === 'Student'): ?>
            <p class="text-sm font-semibold text-gray-600">Signed in as Student</p>
        <?php else: ?>
            <p class="text-sm font-semibold text-gray-600">Signed in as Admin</p>
        <?php endif; ?>

        <?php if ($_SESSION['user_role'] === 'Student'): ?>
            <p class="text-sm font-medium text-gray-800"><?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_lastname']; ?></p>
        <?php else: ?>
            <p class="text-sm font-medium text-gray-500"><?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_lastname']; ?></p>
        <?php endif; ?>
 
        <?php if ($_SESSION['user_role'] === 'Student'): ?>
            <p class="text-xs text-gray-500">Student ID: <?php echo $_SESSION['user_username']; ?></p>
        <?php endif; ?>

    </div>
    <div class="py-2">
    
        <a href="<?php echo ($_SESSION['user_role'] === 'Student') ?  BASE_URL .'/src/layouts/student_dashboard.php' : BASE_URL .'/src/layouts/dashboard.php'; ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            Home
        </a>
        <?php if ($_SESSION['user_role'] === 'Student'): ?>
            <a href="<?= BASE_URL . '/src/layouts/student/profile.php' ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
            </svg>
                Manage Profile
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/>
                </svg>
                Transactions
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL . '/src/layouts/transactions.php' ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/>
                </svg>
                Transactions
            </a>
            <a href="<?= BASE_URL . '/src/layouts/enrollments.php' ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                <path d="M17 16v2H7v-2H5v4h14v-4H17z"/>
            </svg>
                Enrollments
            </a>
            <a href="<?= BASE_URL . '/src/layouts/bi_reports.php' ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14h2v-2h-2v2zm0-4h2V7h-2v5z"/>
                </svg>
                BI Reports
            </a>
            <a href="<?= BASE_URL . '/src/layouts/payment.php' ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm-1-9h2v2h-2V7zm0 4h2v4h-2v-4z"/>
                </svg>
                Payments
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                User Management
            </a>
        <?php endif; ?>
    </div>
    <div class="border-t border-gray-200 py-2">
        <a href="<?= BASE_URL . '/src/logout.php'?>" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
            </svg>
            Logout
        </a>
    </div>
</div>
    </div>

    <style>
        .dropdown-transition {
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
    </style>

    <script>
        const avatar = document.getElementById('avatar');
        const dropdown = document.getElementById('dropdown');
        dropdown.style.width = '288px'; // This ensures the width is exactly 72 (w-72 class equivalent)

        function toggleDropdown() {
            const isExpanded = avatar.getAttribute('aria-expanded') === 'true';
            avatar.setAttribute('aria-expanded', !isExpanded);
            dropdown.classList.toggle('hidden');
             
            // Add a small delay to ensure the display change happens before the transition
            setTimeout(() => {
                dropdown.classList.toggle('opacity-0');
                dropdown.classList.toggle('-translate-y-2');
            }, 20);
        }

        avatar.addEventListener('click', (event) => {
            event.stopPropagation();
            toggleDropdown();
        });

        document.addEventListener('click', (event) => {
            if (!avatar.contains(event.target) && !dropdown.contains(event.target)) {
                avatar.setAttribute('aria-expanded', 'false');
                dropdown.classList.add('hidden', 'opacity-0', '-translate-y-2');
            }
        });

        // Close dropdown on Escape key press
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !dropdown.classList.contains('hidden')) {
                toggleDropdown();
            }
        });
    </script>