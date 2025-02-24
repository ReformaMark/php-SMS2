<?php
require_once "../config_session.php";
require_once "../dbh.php";
require_once "../Models/admin_model.php";

// Restrict access to SuperAdmin only
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'SuperAdmin') {
    header("Location: ../../index.php");
    die();
}

function getRoleBadgeClass($role) {
    $classes = [
        'SuperAdmin' => 'px-2 py-1 rounded-full bg-purple-100 text-purple-800 text-xs',
        'Admin' => 'px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs',
        'Student' => 'px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs',
        'Faculty' => 'px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs',
        'Staff' => 'px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs'
    ];
    
    return $classes[$role] ?? 'px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs';
}

$dashboardData = getDashboardStats($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard</title>
    <link href="../../output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Navigation bar -->
    <?php 
        $imageSrc = '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
    ?>
    
    <div class="flex flex-col lg:flex-row pt-20">
        <!-- Sidebar -->
        <?php include('../../public/templates/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="flex-1 p-4">
            <h1 class="text-2xl font-bold mb-6">System Overview</h1>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Users</p>
                            <p class="text-2xl font-bold"><?= $dashboardData['stats']['total_users'] ?? 0 ?></p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292V4.354zM15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197L15 21z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Admin Count Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Administrators</p>
                            <p class="text-2xl font-bold"><?= $dashboardData['stats']['admin_count'] ?? 0 ?></p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Student Count Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Students</p>
                            <p class="text-2xl font-bold"><?= $dashboardData['stats']['student_count'] ?? 0 ?></p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Archived Users Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Archived Users</p>
                            <p class="text-2xl font-bold"><?= $dashboardData['stats']['archived_users'] ?? 0 ?></p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow p-6 mt-3">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Recent Activities</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full shadow-lg border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-xs lg:text-sm leading-normal">
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Student ID</th>
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">First Name</th>
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Last Name</th>
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Role</th>
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Date Added</th>
                            <th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dashboardData['recent_activities'] as $activity): ?>
                            <tr class="border-b hover:bg-gray-50 text-sm lg:text-base">
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <?= htmlspecialchars($activity['username']) ?>
                                </td>
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <?= htmlspecialchars($activity['first_name']) ?>
                                </td>
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <?= htmlspecialchars($activity['last_name']) ?>
                                </td>
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <span class="<?= getRoleBadgeClass($activity['role']) ?>">
                                        <?= htmlspecialchars($activity['role']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <?= date('M d, Y', strtotime($activity['created_at'])) ?>
                                </td>
                                <td class="py-3 px-3 lg:px-6 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs <?= $activity['is_archived'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= $activity['is_archived'] ? 'Archived' : 'Active' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</body>
</html>