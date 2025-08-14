<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Library System</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #f59e0b;
            --primary-hover: #d97706;
            --dark: #0f172a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: var(--primary);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }

        .auth-link {
            color: var(--primary);
            transition: all 0.2s ease;
        }

        .auth-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
        }

        .role-selector input[type="radio"]:checked + label {
            border-color: var(--primary);
            background-color: rgba(245, 158, 11, 0.1);
        }

        .gender-option {
            transition: all 0.2s ease;
        }

        .gender-option input[type="radio"]:checked + label {
            border-color: var(--primary);
            background-color: rgba(245, 158, 11, 0.1);
        }
    </style>
</head>

<body class="bg-slate-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl glass-card p-8 animate__animated animate__fadeIn">
            <div class="md:flex md:space-x-8">
                <!-- Left Column - Illustration/Info -->
                <div class="hidden md:block md:w-1/2 p-6">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <div class="w-20 h-20 bg-yellow-300 rounded-full flex items-center justify-center text-black mb-6 mx-auto pulse-animation">
                                <i class="fas fa-book-open text-2xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-white text-center mb-4">Join Our Library</h2>
                            <p class="text-white text-center mb-6">
                                Become a member and unlock access to thousands of books, resources, and exclusive content.
                            </p>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3 glass-card p-4 rounded-lg">
                                    <div class="w-10 h-10 bg-yellow-300/20 rounded-full flex items-center justify-center text-yellow-300 mt-1">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white">Extensive Collection</h4>
                                        <p class="text-sm text-slate-400">Access thousands of books across all genres</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3 glass-card p-4 rounded-lg">
                                    <div class="w-10 h-10 bg-yellow-300/20 rounded-full flex items-center justify-center text-yellow-300 mt-1">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white">Learning Resources</h4>
                                        <p class="text-sm text-slate-400">Educational materials for all ages</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3 glass-card p-4 rounded-lg">
                                    <div class="w-10 h-10 bg-yellow-300/20 rounded-full flex items-center justify-center text-yellow-300 mt-1">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white">Events & Workshops</h4>
                                        <p class="text-sm text-slate-400">Join our community activities</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 text-center">
                            <p class="text-sm text-white">
                                Already have an account?
                                <a href="{{ route('login') }}" class="auth-link font-medium">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Registration Form -->
                <div class="md:w-1/2">
                    <div class="text-center md:text-left">
                        <div class="flex justify-center md:justify-start">
                            <div class="w-16 h-16 bg-yellow-300 rounded-full flex items-center justify-center text-black mb-4 pulse-animation md:hidden">
                                <i class="fas fa-book-open text-xl"></i>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-white">Create Account</h2>
                        <p class="mt-2 text-white">Join our library community today</p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 bg-red-500/20 text-red-200 p-4 rounded-lg">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div>
                            <label for="fullname" class="block text-sm font-medium text-white mb-1">Full Name *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-slate-400"></i>
                                </div>
                                <input id="fullname" name="fullname" type="text" required
                                    class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                    placeholder="John Doe" value="{{ old('fullname') }}">
                            </div>
                            @error('fullname')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-white mb-1">Email *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-slate-400"></i>
                                </div>
                                <input id="email" name="email" type="email" required
                                    class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                    placeholder="your@email.com" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-white mb-1">Date of Birth *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-birthday-cake text-slate-400"></i>
                                    </div>
                                    <input id="date_of_birth" name="date_of_birth" type="date" required
                                        class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                        value="{{ old('date_of_birth') }}"
                                        max="{{ date('Y-m-d') }}">
                                </div>
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Gender *</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="gender-option">
                                        <input type="radio" id="male" name="gender" value="male" class="hidden" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                        <label for="male" class="block w-full text-white text-center py-2 px-3 border border-yellow-300 rounded-lg cursor-pointer bg-slate-800/50 hover:bg-yellow-400 hover:text-black">
                                            <i class="fas fa-mars mr-2"></i> Male
                                        </label>
                                    </div>
                                    <div class="gender-option">
                                        <input type="radio" id="female" name="gender" value="female" class="hidden" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                        <label for="female" class="block w-full text-white text-center py-2 px-3 border border-yellow-300 rounded-lg cursor-pointer bg-slate-800/50 hover:bg-yellow-400 hover:text-black">
                                            <i class="fas fa-venus mr-2"></i> Female
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-white mb-1">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-slate-400"></i>
                                    </div>
                                    <input id="phone_number" name="phone_number" type="tel"
                                        class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                        placeholder="+1 (555) 123-4567" value="{{ old('phone_number') }}">
                                </div>
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-white mb-1">Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-slate-400"></i>
                                    </div>
                                    <input id="address" name="address" type="text"
                                        class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                        placeholder="123 Library St" value="{{ old('address') }}">
                                </div>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-white mb-1">Password *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-slate-400"></i>
                                    </div>
                                    <input id="password" name="password" type="password" required
                                        class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                        placeholder="Create a password">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <div class="mt-2 text-xs text-yellow-300">
                                    <p>Password must contain:</p>
                                    <ul class="list-disc list-inside pl-3">
                                        <li data-requirement="length">At least 8 characters</li>
                                        <li data-requirement="uppercase">One uppercase letter</li>
                                        <li data-requirement="number">One number</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Confirm Password *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-slate-400"></i>
                                    </div>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required
                                        class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-black placeholder-slate-400 input-field"
                                        placeholder="Confirm your password">
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden role field that will be set by JavaScript -->
                        <input type="hidden" name="role" id="role" value="{{ old('role', 'member') }}">

                        <div class="flex items-start mt-4">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-4 w-4 text-yellow-300 focus:ring-yellow-300 border-slate-700 rounded bg-slate-800/50">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-white">
                                    I agree to the <a href="{{ route('terms') }}" class="auth-link font-medium">Terms of Service</a>
                                    and <a href="{{ route('privacy') }}" class="auth-link font-medium">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:-translate-y-1 btn-primary">
                                Create Account
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center md:hidden">
                        <p class="text-sm text-slate-400">
                            Already have an account?
                            <a href="{{ route('login') }}" class="auth-link font-medium">
                                Sign in
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const requirements = {
                length: document.querySelector('[data-requirement="length"]'),
                uppercase: document.querySelector('[data-requirement="uppercase"]'),
                number: document.querySelector('[data-requirement="number"]')
            };

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const value = this.value;

                    // Check each requirement
                    requirements.length.classList.toggle('text-green-400', value.length >= 8);
                    requirements.uppercase.classList.toggle('text-green-400', /[A-Z]/.test(value));
                    requirements.number.classList.toggle('text-green-400', /\d/.test(value));
                });
            }

            // Calculate age based on date of birth and set role accordingly
            const dobInput = document.getElementById('date_of_birth');
            const roleInput = document.getElementById('role');

            if (dobInput) {
                dobInput.addEventListener('change', function() {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }

                    // Set role based on age
                    if (age < 13) {
                        roleInput.value = 'kid';
                    } else {
                        roleInput.value = 'member';
                    }
                });
            }
        });
    </script>
</body>
</html>
