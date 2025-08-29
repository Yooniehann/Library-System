@extends('dashboard.admin.index')

@section('title', 'Notifications')

@section('content')

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Notifications</h1>
                        <p class="text-gray-400">Manage all system notifications</p>
                    </div>
                    <a href="{{ route('admin.notifications.create') }}" class="bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Send New Notification
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-900 bg-opacity-30 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Notification Message Modal -->
                <div id="notificationModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
                    <div class="bg-slate-800 rounded-lg w-11/12 md:w-2/3 lg:w-1/2 max-h-96 overflow-hidden flex flex-col">
                        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white" id="modalTitle">Notification Message</h3>
                            <button id="closeModal" class="text-gray-400 hover:text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="p-6 overflow-y-auto flex-grow">
                            <p class="text-white whitespace-pre-wrap" id="modalMessage"></p>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-700 bg-slate-900 flex justify-end">
                            <button id="modalCloseButton" class="bg-slate-600 text-white px-4 py-2 rounded hover:bg-slate-500 transition-colors">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h2 class="text-lg font-semibold text-white">All Notifications</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-700">
                            <thead class="bg-slate-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Sent Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-slate-800 divide-y divide-slate-700">
                                @foreach($notifications as $notification)
                                <tr class="hover:bg-slate-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-mono">
                                        #{{ $notification->notification_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $notification->user->fullname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($notification->notification_type)
                                            @case('due_reminder')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-300">Due Reminder</span>
                                                @break
                                            @case('overdue')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300">Overdue</span>
                                                @break
                                            @case('fine')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-300">Fine</span>
                                                @break
                                            @case('reservation_ready')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Reservation Ready</span>
                                                @break
                                            @case('general')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">General</span>
                                                @break
                                            @default
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">{{ ucfirst($notification->notification_type) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-sm text-white">
                                        {{ $notification->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($notification->delivery_method)
                                            @case('email')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-900 text-purple-300">Email</span>
                                                @break
                                            @case('sms')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-900 text-indigo-300">SMS</span>
                                                @break
                                            @case('system')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">System</span>
                                                @break
                                            @default
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">{{ ucfirst($notification->delivery_method) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $notification->sent_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button onclick="viewNotification('{{ addslashes($notification->title) }}', `{{ addslashes($notification->message) }}`)" 
                                                class="text-blue-400 hover:text-blue-300">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <form action="{{ route('admin.notifications.destroy', $notification->notification_id) }}" 
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="text-red-400 hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to delete this notification?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-slate-700 bg-slate-900">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-400">
                                Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} results
                            </div>
                            <div class="flex space-x-2">
                                @if($notifications->onFirstPage())
                                    <span class="px-3 py-1 rounded bg-slate-700 text-gray-500 text-sm">Previous</span>
                                @else
                                    <a href="{{ $notifications->previousPageUrl() }}" class="px-3 py-1 rounded bg-slate-600 hover:bg-slate-500 text-white text-sm">Previous</a>
                                @endif
                                
                                @if($notifications->hasMorePages())
                                    <a href="{{ $notifications->nextPageUrl() }}" class="px-3 py-1 rounded bg-slate-600 hover:bg-slate-500 text-white text-sm">Next</a>
                                @else
                                    <span class="px-3 py-1 rounded bg-slate-700 text-gray-500 text-sm">Next</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        function viewNotification(title, message) {
            // Decode any escaped characters
            const decodedMessage = message.replace(/\\'/g, "'")
                                         .replace(/\\"/g, '"')
                                         .replace(/\\\\/g, '\\');
            
            // Set modal content
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = decodedMessage;
            
            // Show modal
            document.getElementById('notificationModal').classList.remove('hidden');
        }
        
        // Close modal functionality
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('notificationModal').classList.add('hidden');
        });
        
        document.getElementById('modalCloseButton').addEventListener('click', function() {
            document.getElementById('notificationModal').classList.add('hidden');
        });
        
        // Close modal when clicking outside content
        document.getElementById('notificationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('notificationModal').classList.add('hidden');
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('notificationModal').classList.contains('hidden')) {
                document.getElementById('notificationModal').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
@endsection