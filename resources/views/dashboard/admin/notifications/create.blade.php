@extends('dashboard.admin.index')

@section('title', 'Send Notification')

@section('content')
    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top Navigation (Mobile) -->
        <div class="md:hidden flex items-center justify-between px-4 py-3 bg-black border-b border-slate-700">
            <button class="text-primary-orange focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
            <span class="text-primary-orange text-lg font-bold">Admin Dashboard</span>
            <div class="w-6"></div>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="mb-6">
                <a href="{{ route('admin.notifications.index') }}"
                    class="inline-flex items-center text-yellow-500 hover:text-yellow-700 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
                <h1 class="text-2xl font-bold text-white">Send Notification</h1>
                <p class="text-gray-400">Create and send a new notification to users</p>
            </div>

            <div class="bg-slate-800 rounded-lg shadow p-6">
                <form action="{{ route('admin.notifications.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Recipient User -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Recipient User</label>
                            <select name="user_id"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange"
                                required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->fullname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Notification Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Notification Type</label>
                            <select name="notification_type"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange"
                                required>
                                <option value="due_reminder">Due Reminder</option>
                                <option value="overdue">Overdue</option>
                                <option value="fine">Fine</option>
                                <option value="reservation_ready">Reservation Ready</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Delivery Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Delivery Method</label>
                            <select name="delivery_method"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange"
                                required>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="system">System</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                            <input type="text" name="title"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange"
                                maxlength="100" required>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <textarea name="message"
                            class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange"
                            rows="4" required></textarea>
                    </div>

                    <button type="submit"
                        class="bg-yellow-400 text-black px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i> Send Notification
                    </button>
                </form>
            </div>
        </main>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.querySelector('select[name="user_id"]');
            const notificationTypeSelect = document.querySelector('select[name="notification_type"]');
            const messageTextarea = document.querySelector('textarea[name="message"]');
            const titleInput = document.querySelector('input[name="title"]');

            // Store user data for auto-fill
            const users = {
                @foreach ($users as $user)
                    '{{ $user->user_id }}': {
                        fullname: '{{ $user->fullname }}',
                        username: '{{ $user->username }}'
                    },
                @endforeach
            };

            // Auto-fill message when user or notification type changes
            function autoFillMessage() {
                const userId = userSelect.value;
                const notificationType = notificationTypeSelect.value;

                if (!userId || !notificationType) return;

                const user = users[userId];
                if (!user) return;

                let message = '';
                let title = '';

                switch (notificationType) {
                    case 'due_reminder':
                        title = 'Book Due Reminder';
                        message =
                            `Dear ${user.fullname},\n\nThis is a reminder that your borrowed book "[BOOK_TITLE]" is due on [DUE_DATE]. Please return it on time to avoid fines.\n\nThank you,\nLibrary Staff`;
                        break;
                    case 'overdue':
                        title = 'Overdue Book Notice';
                        message =
                            `Dear ${user.fullname},\n\nThe book "[BOOK_TITLE]" you borrowed is now overdue. Please return it as soon as possible to avoid accumulating fines.\n\nCurrent fine: $[AMOUNT]\nPlease check 'Fines & Payment' tab for more information.\n\nThank you,\nLibrary Staff`;
                        break;
                    case 'fine':
                        title = 'Library Fine Notice';
                        message =
                            `Dear ${user.fullname},\n\nYou have accumulated a fine of $[AMOUNT] for [REASON]. Please settle this amount at your earliest convenience.\n\nThank you,\nLibrary Staff`;
                        break;
                    case 'reservation_ready':
                        title = 'Reservation Ready for Pickup';
                        message =
                            `Dear ${user.fullname},\n\nYour reserved book "[BOOK_TITLE]" is now available for pickup. Please collect it within the next 3 days.\n\nThank you,\nLibrary Staff`;
                        break;
                    case 'general':
                        title = 'Library Notification';
                        message = `Dear ${user.fullname},\n\n[YOUR_MESSAGE_HERE]\n\nThank you,\nLibrary Staff`;
                        break;
                }

                // Only auto-fill title if empty
                if (title || !titleInput.value) {
                    titleInput.value = title;
                }

                // Only auto-fill message if empty
                if (message || !messageTextarea.value) {
                    messageTextarea.value = message;
                }
            }

            userSelect.addEventListener('change', autoFillMessage);
            notificationTypeSelect.addEventListener('change', autoFillMessage);

            // Auto-fill immediately if values are already selected
            if (userSelect.value && notificationTypeSelect.value) {
                autoFillMessage();
            }
        });
    </script>

    </body>

    </html>
@endsection
