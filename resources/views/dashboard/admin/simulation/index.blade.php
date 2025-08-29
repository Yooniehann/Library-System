@extends('dashboard.admin.index')

@section('title', 'Time Simulation Settings')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Time Simulation Settings</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Simulation Settings Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                    Current Simulation Status
                </h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">Simulation Mode:</span>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $setting->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ $setting->is_active ? 'ACTIVE' : 'INACTIVE' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-300">Current System Date:</span>
                        <p class="text-white font-medium">
                            {{ \App\Models\SimulationSetting::getCurrentDate()->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    @if ($setting->is_active)
                        <div>
                            <span class="text-gray-300">Simulation Date:</span>
                            <p class="text-yellow-400 font-medium">
                                {{ $setting->simulation_date->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    @endif

                    @if ($setting->description)
                        <div>
                            <span class="text-gray-300">Description:</span>
                            <p class="text-white">{{ $setting->description }}</p>
                        </div>
                    @endif
                </div>

                @if ($setting->is_active)
                    <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-400 text-xl mr-3"></i>
                            <div>
                                <h4 class="text-yellow-400 font-semibold">Simulation Active</h4>
                                <p class="text-yellow-300">
                                    The system is using simulated time. All date calculations will use the simulation date
                                    instead of the real current date.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Configuration Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                    Configure Simulation
                </h2>

                <form action="{{ route('admin.simulation.update') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ $setting->is_active ? 'checked' : '' }}
                                class="rounded border-gray-600 text-blue-500 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-gray-300">Enable Time Simulation</label>
                        </div>

                        <div id="simulation-fields" class="{{ $setting->is_active ? '' : 'hidden' }} space-y-4">
                            <div>
                                <label for="simulation_date" class="block text-sm font-medium text-gray-300 mb-1">
                                    Simulation Date
                                </label>
                                <input type="datetime-local" name="simulation_date" id="simulation_date"
                                    value="{{ $setting->simulation_date ? $setting->simulation_date->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}"
                                    class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-1">
                                    Description (Optional)
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    placeholder="e.g., Testing overdue books for September 2025"
                                    class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $setting->description }}</textarea>
                            </div>
                        </div>

                        <div class="flex space-x-3 pt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Save Settings
                            </button>

                            @if ($setting->is_active)
                                <form action="{{ route('admin.simulation.disable') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                        Disable Simulation
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-slate-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                How to Use Time Simulation
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
                <div>
                    <h3 class="font-medium text-white mb-2">For Testing Overdue Books:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Set simulation date to a date after September 5, 2025</li>
                        <li>The system will calculate overdue days based on the simulation date</li>
                        <li>Fines will be calculated automatically</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-medium text-white mb-2">Important Notes:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Simulation affects all date calculations system-wide</li>
                        <li>Remember to disable simulation when done testing</li>
                        <li>Real dates are used when simulation is disabled</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleCheckbox = document.getElementById('is_active');
            const simulationFields = document.getElementById('simulation-fields');

            toggleCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    simulationFields.classList.remove('hidden');
                } else {
                    simulationFields.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
