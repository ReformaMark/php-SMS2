<div class="relative">
    <button id="notifications" aria-expanded="false" aria-haspopup="true" 
            class="relative flex items-center p-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span id="notificationCount" class="<?= $unreadCount > 0 ? '' : 'hidden' ?> absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center transition-all duration-300">
            <?= $unreadCount ?>
        </span>
    </button>
    
    <div id="notificationsDropdown" 
         class="absolute right-0 mt-3 w-80 bg-white border border-gray-200 rounded-md shadow-xl z-50 hidden opacity-0 transform -translate-y-2 transition-all duration-300">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
            <?php if ($unreadCount > 0): ?>
                <button id="markAllRead" class="text-sm text-blue-600 hover:text-blue-800">
                    Mark all as read
                </button>
            <?php endif; ?>
        </div>
        <div id="notificationsList" class="max-h-96 overflow-y-auto">
            <?php if ($unreadCount > 0): ?>
                <?php foreach (getUnreadNotifications($pdo, $_SESSION['user_id']) as $notification): ?>
                    <div class="notification-item p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200" 
                         data-id="<?= $notification['notification_id'] ?>"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800"><?= htmlspecialchars($notification['title']) ?></p>
                                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($notification['message']) ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?= date('M d, Y H:i', strtotime($notification['created_at'])) ?></p>
                            </div>
                            <button class="mark-read ml-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-4 text-center text-gray-500">
                    No new notifications
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.notification-transition {
    transition: all 0.3s ease-in-out;
}

.notification-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationsBtn = document.getElementById('notifications');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    const markAllReadBtn = document.getElementById('markAllRead');
    let isOpen = false;

    // Toggle dropdown
    function toggleDropdown() {
        isOpen = !isOpen;
        notificationsBtn.setAttribute('aria-expanded', isOpen);
        
        if (isOpen) {
            notificationsDropdown.classList.remove('hidden');
            // Use setTimeout to ensure transition works
            setTimeout(() => {
                notificationsDropdown.classList.remove('opacity-0', '-translate-y-2');
            }, 10);
        } else {
            notificationsDropdown.classList.add('opacity-0', '-translate-y-2');
            // Wait for transition before hiding
            setTimeout(() => {
                notificationsDropdown.classList.add('hidden');
            }, 300);
        }
    }

    // Click handlers
    notificationsBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown();
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (isOpen && !notificationsDropdown.contains(e.target)) {
            toggleDropdown();
        }
    });

    // Mark single notification as read
    document.querySelectorAll('.mark-read').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.stopPropagation();
            const notificationItem = e.target.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;

            try {
                const response = await fetch('../Controllers/notification_controller.php', {
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
                    notificationItem.remove();
                    updateNotificationCount(-1);
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        });
    });

    // Mark all as read
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', async () => {
            try {
                const response = await fetch('../Controllers/notification_controller.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'mark_all_read'
                    })
                });

                if (response.ok) {
                    document.querySelectorAll('.notification-item').forEach(item => item.remove());
                    updateNotificationCount(-999); // Reset to 0
                    toggleDropdown(); // Close dropdown
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        });
    }

    // Update notification count
    function updateNotificationCount(change) {
        const countElement = document.getElementById('notificationCount');
        let currentCount = parseInt(countElement.textContent);
        
        if (change === -999) { // Reset to 0
            currentCount = 0;
        } else {
            currentCount += change;
        }

        if (currentCount <= 0) {
            countElement.classList.add('hidden');
            document.getElementById('notificationsList').innerHTML = '<div class="p-4 text-center text-gray-500">No new notifications</div>';
        }
        countElement.textContent = currentCount;
    }
});
</script>