<?php
require_once "../config_session.php";
require_once "../dbh.php";
require_once "../Models/admin_model.php";

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'SuperAdmin') {
    header("Location: ../../index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Administrators</title>
    <link href="../../output.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Header -->
    <?php 
        $imageSrc = '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
    ?>
    
    <div 
        style="display: flex; height: 100vh; padding-top: 70px;"
    >
        <!-- Sidebar -->
        <?php include('../../public/templates/sidebar.php');?>
        
        <!-- Main content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Manage Administrators</h1>
            
            <!-- Add Admin Button -->
            <button id="addAdminBtn" class="bg-blue-500 text-white px-4 py-2 rounded mb-6 hover:bg-blue-600">
                Add New Administrator
            </button>
            
            <!-- Admin List -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="overflow-x-auto">
                    <table class="w-full shadow-lg border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-xs lg:text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Username</th>
                                <th class="py-3 px-6 text-center">Name</th>
                                <th class="py-3 px-6 text-center">Email</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $admins = getAllAdmins($pdo);
                            foreach ($admins as $admin): 
                            ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-6 text-center"><?= htmlspecialchars($admin['username']) ?></td>
                                <td class="py-3 px-6 text-center"><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></td>
                                <td class="py-3 px-6 text-center"><?= htmlspecialchars($admin['email']) ?></td>
                                <td class="py-3 px-6 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs <?= $admin['is_archived'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= $admin['is_archived'] ? 'Archived' : 'Active' ?>
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="edit-admin text-blue-600 hover:text-blue-800" data-admin-id="<?= $admin['user_id'] ?>">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button class="toggle-status text-<?= $admin['is_archived'] ? 'green' : 'red' ?>-600 hover:text-<?= $admin['is_archived'] ? 'green' : 'red' ?>-800" data-admin-id="<?= $admin['user_id'] ?>">
                                            <?php if ($admin['is_archived']): ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                </svg>
                                            <?php endif; ?>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="adminModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mx-auto mt-[10vh]">
                        <form id="adminForm" class="p-5">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Add New Administrator</h3>
                                <button type="button" id="cancelBtn" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-2">
                                <!-- Username field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                    <input type="text" name="username" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>

                                <!-- Name fields -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" name="first_name" required 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" name="last_name" required 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    </div>
                                </div>

                                <!-- Email field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>

                                <!-- Password field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" name="password" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <p class="mt-1 text-sm text-gray-500">Minimum 8 characters</p>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div class="mt-5 flex gap-5">
                                <button type="submit" 
                                    class="flex-1 justify-center py-2 px-4 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    Save
                                </button>
                                <button type="button" id="closeBtn"
                                    class="flex-1 justify-center py-2 px-4 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('adminModal');
                const addBtn = document.getElementById('addAdminBtn');
                const cancelBtn = document.getElementById('cancelBtn');
                const closeBtn = document.getElementById('closeBtn');
                const adminForm = document.getElementById('adminForm');
                const modalTitle = document.getElementById('modalTitle');
                let isEditing = false;
                let editingAdminId = null;

                // Show modal function
                const showModal = (title = 'Add New Administrator') => {
                modalTitle.textContent = title;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                const passwordField = adminForm.querySelector('[name="password"]');
                const passwordLabel = passwordField.previousElementSibling;
                
                if (isEditing) {
                    passwordField.required = false;
                    passwordLabel.innerHTML = 'Password (Leave blank to keep current password)';
                } else {
                    passwordField.required = true;
                    passwordLabel.innerHTML = 'Password';
                }
            };

                // Hide modal function
                const hideModal = () => {
                    modal.classList.add('hidden');
                    adminForm.reset();
                    document.body.style.overflow = 'auto';
                    isEditing = false;
                    editingAdminId = null;
                    
                    // Reset password field to required
                    const passwordField = adminForm.querySelector('[name="password"]');
                    const passwordLabel = passwordField.previousElementSibling;
                    passwordField.required = true;
                    passwordLabel.textContent = 'Password';
                };



                // Show modal for new admin
                addBtn.addEventListener('click', () => {
                    isEditing = false;
                    editingAdminId = null;
                    showModal('Add New Administrator');
                });

                // Hide modal triggers
                cancelBtn.addEventListener('click', hideModal);
                closeBtn.addEventListener('click', hideModal);

                modal.addEventListener('click', (e) => {
                    if (e.target === modal) hideModal();
                });

                // Handle edit admin
                document.querySelectorAll('.edit-admin').forEach(btn => {
                    btn.addEventListener('click', async () => {
                        const adminId = btn.dataset.adminId;
                        try {
                            const response = await fetch('../Controllers/admin_controller.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    action: 'get',
                                    admin_id: adminId
                                })
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const result = await response.json();
                            if (result.success && result.data) {
                                isEditing = true;
                                editingAdminId = adminId;
                                
                                // Populate form
                                const admin = result.data;
                                Object.keys(admin).forEach(key => {
                                    const input = adminForm.querySelector(`[name="${key}"]`);
                                    if (input && key !== 'user_id') {
                                        input.value = admin[key];
                                    }
                                });
                                
                                // Make password optional for editing
                                adminForm.querySelector('[name="password"]').required = false;
                                
                                showModal('Edit Administrator');
                            } else {
                                throw new Error(result.message || 'Failed to load administrator data');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            // Check if the row still exists before showing error
                            if (document.querySelector(`[data-admin-id="${adminId}"]`)) {
                                alert('Failed to load administrator data');
                            }
                        }
                    });
                });

                adminForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(adminForm);
                    
                    if (isEditing && editingAdminId) {
                        formData.append('action', 'update');
                        formData.append('admin_id', editingAdminId);
                    } else {
                        formData.append('action', 'create');
                    }

                    try {
                        const response = await fetch('../Controllers/admin_controller.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();
                        
                        if (result.success) {
                            hideModal();
                            // Add small delay to ensure notification is created before reload
                            setTimeout(() => {
                                location.reload();
                            }, 100);
                        } else {
                            const errorMessage = result.errors ? 
                                Object.values(result.errors).join('\n') : 
                                result.message || 'Error processing request';
                            alert(errorMessage);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                });

                // Toggle admin status
                document.querySelectorAll('.toggle-status').forEach(btn => {
                    btn.addEventListener('click', async () => {
                        const adminId = btn.dataset.adminId;
                        const currentStatus = btn.closest('tr').querySelector('span').textContent.trim();
                        const action = currentStatus === 'Active' ? 'archive' : 'activate';
                        
                        if (confirm(`Are you sure you want to ${action} this administrator?`)) {
                            try {
                                const response = await fetch('../Controllers/admin_controller.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        action: 'toggle_status',
                                        admin_id: adminId
                                    })
                                });

                                const result = await response.json();
                                if (result.success) {
                                    // Add small delay to ensure notification is created before reload
                                    setTimeout(() => {
                                        location.reload();
                                    }, 100);
                                } else {
                                    throw new Error(result.message || 'Failed to update administrator status');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                alert('Failed to update administrator status');
                            }
                        }
                    });
                });
            });
        </script>

    </div>
</body>
</html>