<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].BASE_URL."/src/dbh.php";
    require_once $_SERVER['DOCUMENT_ROOT'].BASE_URL."/src/Models/notification_model.php";
?>

<nav class="z-50 absolute flex justify-between px-5 md:px-40 items-center w-full bg-white py-5 shadow-sm">
    <div class="flex items-center gap-x-2">
        <div class="size-10">
            <a href="#">
                <img src="<?php echo $imageSrc; ?>" alt="BCP logo" class="object-cover size-full" >
            </a>
        </div>
        <h1 class="text-blue-500 font-serif font-semibold text-lg">Bestlink College</h1>
    </div>
  
    <?php if(isset($_SESSION['user_username'])): ?>
        <div class="flex items-center gap-x-4">
            <!-- Notifications Dropdown -->
                <div class="relative">
                    <button id="notificationBtn" class="relative p-2 text-gray-600 hover:text-gray-800 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <?php 
                        require_once $_SERVER['DOCUMENT_ROOT'].BASE_URL."/src/Models/notification_model.php";
                        $unreadCount = count(getUnreadNotifications($pdo, $_SESSION['user_id']));
                        if ($unreadCount > 0): 
                        ?>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?= $unreadCount ?>
                        </span>
                        <?php endif; ?>
                    </button>

                    <div 
                        id="notificationDropdown" 
                        class="hidden absolute right-0 mt-2 bg-white rounded-md shadow-lg z-50"
                        style="width: 20rem; max-height: 480px; /* Fixed maximum height */"
                    >
                        <!-- Header - Fixed at top -->
                        <div class="flex justify-between items-center p-4 border-b bg-white sticky top-0 z-10">
                            <h3 class="text-lg font-semibold">Notifications</h3>
                            <?php if ($unreadCount > 0): ?>
                            <button id="markAllRead" class="text-sm text-blue-600 hover:text-blue-800">
                                Mark all as read
                            </button>
                            <?php endif; ?>
                    </div>

                    <div class="overflow-y-auto" id="notificationList" style="max-height: calc(480px - 65px); /* Subtract header height */">
                        <?php 
                        $notifications = getAllNotifications($pdo, $_SESSION['user_id']);
                        if (count($notifications) > 0):
                            foreach ($notifications as $notification): 
                        ?>
                            <div class="notification-item p-4 border-b hover:bg-gray-50 transition-colors duration-200 <?= !$notification['is_read'] ? 'bg-blue-50' : '' ?>" 
                                data-id="<?= $notification['notification_id'] ?>">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">
                                            <?= htmlspecialchars($notification['title']) ?>
                                            <?php if (!$notification['is_read']): ?>
                                                <span class="ml-2 inline-block w-2 h-2 bg-blue-600 rounded-full"></span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-xs text-gray-400 mt-1"><?= date('M d, Y H:i', strtotime($notification['created_at'])) ?></p>
                                    </div>
                                    <?php if (!$notification['is_read']): ?>
                                        <button class="mark-read ml-2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                                <?php 
                                    endforeach;
                                else:
                                ?>
                                    <div class="p-4 text-center text-gray-500">
                                        No notifications
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            
            <!-- User Avatar -->
            <?php include($_SERVER['DOCUMENT_ROOT'] . BASE_URL.'/public/templates/userAvatar.php'); ?>
        </div>
    <?php endif; ?>
</nav>

<style>
/* Custom scrollbar styling */
#notificationList::-webkit-scrollbar {
    width: 6px;
}

#notificationList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#notificationList::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#notificationList::-webkit-scrollbar-thumb:hover {
    background: #666;
}

/* For Firefox */
#notificationList {
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const markAllReadBtn = document.getElementById('markAllRead');

    // Toggle notifications dropdown
    notificationBtn.addEventListener('click', () => {
        notificationDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });

    // Mark individual notification as read
    document.querySelectorAll('.mark-read').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.stopPropagation();
        const notificationItem = e.target.closest('.notification-item');
        const notificationId = notificationItem.dataset.id;
        
        try {
            const response = await fetch('../../src/Controllers/notification_controller.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'mark_read',
                    notification_id: notificationId
                })
            });
            
            if (response.ok) {
                // Remove unread styling
                notificationItem.classList.remove('bg-blue-50');
                // Remove the blue dot
                notificationItem.querySelector('.bg-blue-600')?.remove();
                // Remove the mark as read button
                btn.remove();
                // Update notification count
                updateNotificationCount();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});

        // Update the markAllRead functionality
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', async () => {
                try {
                    const response = await fetch('../../src/Controllers/notification_controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'mark_all_read'
                        })
                    });
                    
                    if (response.ok) {
                        // Remove unread styling from all items
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.remove('bg-blue-50');
                            item.querySelector('.bg-blue-600')?.remove();
                            item.querySelector('.mark-read')?.remove();
                        });
                        
                        // Update notification count
                        const countBadge = notificationBtn.querySelector('span');
                        countBadge?.remove();
                        markAllReadBtn.remove();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        }

    function updateNotificationCount() {
        const countBadge = notificationBtn.querySelector('span');
        if (countBadge) {
            const currentCount = parseInt(countBadge.textContent) - 1;
            if (currentCount <= 0) {
                countBadge.remove();
                markAllReadBtn?.remove();
            } else {
                countBadge.textContent = currentCount;
            }
        }
    }
});
</script>