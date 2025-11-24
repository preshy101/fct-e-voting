<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Cast Successfully - E-Vote Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-blue-600">E-Vote Portal</h1>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <!-- Success Icon -->
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">Vote Cast Successfully!</h1>
                
                <p class="text-lg text-gray-600 mb-6">
                    Thank you for participating in <span class="font-semibold text-gray-900">{{ $election->title }}</span>
                </p>

                <!-- Vote Reference -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6 mb-8">
                    <p class="text-sm text-gray-500 mb-2">Your Vote Reference Number</p>
                    <p class="text-3xl font-bold text-blue-600 tracking-wider">{{ $vote_reference }}</p>
                    <p class="text-sm text-gray-500 mt-4">
                        Please save this reference number for your records. You can use it to verify your vote was counted.
                    </p>
                </div>

                <!-- Important Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 text-left">
                    <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Important Information
                    </h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Your vote has been securely recorded and encrypted</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>You cannot change your vote once submitted</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Election results will be announced after the voting period ends</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>A confirmation email has been sent to your registered email address</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('election.result', $election->id) }}" 
                       class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        View Live Results
                    </a>
                    <a href="/" 
                       class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Return to Home
                    </a>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Questions or concerns? Contact the election administrator.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-6 py-6 text-center text-gray-500">
            <p>&copy; 2025 E-Vote Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
