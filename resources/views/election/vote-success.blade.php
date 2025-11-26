<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('./build/assets/fctLogo.png') }}">
    <title>Vote Successful - E-Vote Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 100;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: checkmark 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: checkmark 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.4s forwards;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 text-2xl font-bold text-blue-600">
                    <img src="{{ asset('./build/assets/fctLogo.png') }}" width="50" height="50" alt="FCT Logo" srcset="">
                    <span>FCT e-Voting</span>
                </a>

            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-16">
        <div class="max-w-2xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-2xl p-8 md:p-12 text-center">
                <!-- Success Animation -->
                <div class="mb-8">
                    <svg class="w-32 h-32 mx-auto" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" stroke="#10b981" stroke-width="2"/>
                        <path class="checkmark" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" d="M14 27l7.5 7.5L38 18"/>
                    </svg>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">Vote Successfully Cast!</h1>
                <p class="text-xl text-gray-600 mb-8">
                    Thank you for participating in the democratic process. Your voice matters!
                </p>

                <!-- Vote Details -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-green-900">Vote Confirmation</h3>
                    </div>

                    <div class="space-y-3 text-left max-w-md mx-auto">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Elections Voted:</span>
                            <span class="font-semibold text-gray-900">{{ $votesCount }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Submission Time:</span>
                            <span class="font-semibold text-gray-900">{{ now()->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                Confirmed
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Email Confirmation Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm text-blue-900">
                            A confirmation email has been sent to <strong>{{ $memberEmail }}</strong> with the details of your votes.
                        </p>
                    </div>
                </div>

                <!-- Elections List -->
                <div class="text-left mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Your Votes:</h4>
                    <div class="space-y-3">
                        @foreach($votes as $vote)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $vote['election_title'] }}</p>
                                <p class="text-sm text-gray-600">Candidate: {{ $vote['candidate_name'] }}</p>
                            </div>
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Important Information -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-yellow-900 mb-1">Important:</p>
                            <ul class="text-sm text-yellow-900 space-y-1">
                                <li>• Your vote is confidential and secure</li>
                                <li>• You cannot change your vote once submitted</li>
                                <li>• Keep your confirmation email for your records</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('election') }}"
                       class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                        Return to Home
                    </a>
                    {{-- @if($allowResultPreview == true)
                    <a href="{{ route('election.result', ['id' => $votes[0]['election_id']]) }}"
                       class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-colors">
                        View Results
                    </a>
                    @endif --}}
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>If you have any questions or concerns, please contact the election administrator.</p>
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
