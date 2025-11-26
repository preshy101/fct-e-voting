<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting System - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-accreditation {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-voting {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .icon-bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
    <!-- Header -->
    <header class="gradient-bg text-white py-6 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    <h1 class="text-3xl font-bold">E-Voting System</h1>
                </div>
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Welcome, {{ Auth::user()->name }}</span>
                    {{-- <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Logout
                        </button>
                    </form> --}}
                </div>
                @else
                <a href="{{ route('login') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-6 py-2 rounded-lg text-sm font-medium transition">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-16">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-gray-800 mb-4">Welcome to the E-Voting Platform</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Choose your action below to participate in the democratic process</p>
        </div>

        <!-- Cards Container -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Accreditation Card -->
            <div class="card-hover bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="gradient-accreditation p-8 text-white text-center">
                    <div class="icon-bounce mb-4 inline-block">
                        <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold mb-2">Accreditation</h3>
                    <p class="text-blue-100">Verify your identity and get accredited to vote</p>
                </div>
                <div class="p-8">
                    <ul class="space-y-3 mb-8 text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Input your Practice ID to verify eligibility</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Obtain your accreditation token after verification</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Use Accreditation Token to cast your vote</span>
                        </li>
                    </ul>
                    <a href="{{ route('accreditation.index') }}" class="block w-full gradient-accreditation text-white text-center py-4 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:scale-105 transition duration-300">
                        Start Accreditation
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Voting Card -->
            <div class="card-hover bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="gradient-voting p-8 text-white text-center">
                    <div class="icon-bounce mb-4 inline-block" style="animation-delay: 0.2s;">
                        <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold mb-2">Cast Your Vote</h3>
                    <p class="text-pink-100">Exercise your democratic right</p>
                </div>
                <div class="p-8">
                    <ul class="space-y-3 mb-8 text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Review available candidates profile</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Make your selection for each election securely</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Use accreditation token for casting vote(s)</span>
                        </li>
                    </ul>
                    <a href="{{ route('election') }}" class="block w-full gradient-voting text-white text-center py-4 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:scale-105 transition duration-300">
                        Go to Voting
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="mt-16 bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-3">How It Works</h3>
                <p class="text-gray-600">Follow these simple steps to participate in the election</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">1</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Get Accredited</h4>
                    <p class="text-gray-600 text-sm">Use your accreditation token to verify your identity</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-pink-600">2</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Cast Your Vote</h4>
                    <p class="text-gray-600 text-sm">Select your preferred candidate in each category</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">3</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Get Confirmation</h4>
                    <p class="text-gray-600 text-sm">Receive confirmation of your vote via email</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} E-Voting System. All rights reserved.</p>
            <p class="text-sm text-gray-500 mt-2">Secure • Transparent • Democratic</p>
        </div>
    </footer>
</body>
</html>
