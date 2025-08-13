<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Library System</title>

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
    </style>
</head>

<body class="bg-slate-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full glass-card p-10 animate__animated animate__fadeIn">
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-16 h-16 bg-yellow-300 rounded-full flex items-center justify-center text-black mb-4 pulse-animation">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white">Welcome Back</h2>
                <p class="mt-2 text-white">Sign in to your library account</p>
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

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-1">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-white placeholder-slate-400 input-field"
                                placeholder="your@email.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="w-full pl-10 pr-3 py-3 bg-slate-800/50 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent text-white placeholder-slate-400 input-field"
                                placeholder="Your password">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-yellow-300 focus:ring-yellow-300 border-slate-700 rounded bg-slate-800/50">
                        <label for="remember-me" class="ml-2 block text-sm text-white">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="auth-link font-medium">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:-translate-y-1 btn-primary">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-white">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link font-medium">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Simple password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any client-side interactions here
            console.log('Login page loaded');
        });
    </script>
</body>
</html>
