<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ballots Cast Successfully — E-Voting Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .theme-gradient {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        }
        .btn-brand {
            background: linear-gradient(135deg, #008751 0%, #005a36 100%);
            transition: all 0.25s ease;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #00a865 0%, #006b40 100%);
            box-shadow: 0 10px 25px -5px rgba(0, 135, 81, 0.4);
        }
        @keyframes checkmark {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
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
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-emerald-100 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="36" height="36" alt=" Logo" class="h-9 w-auto">
                    <span class="text-lg font-extrabold text-slate-900">E-Voting System</span>
                </a>
            </div>
        </nav>
    </header>

    <div class="flex-grow container mx-auto px-6 py-12 md:py-16">
        <div class="max-w-2xl mx-auto">
            
            <!-- Success Card -->
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-2xl p-8 md:p-12 text-center">
                <!-- Checkmark Animation -->
                <div class="mb-6">
                    <svg class="w-24 h-24 mx-auto" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" stroke="#008751" stroke-width="3"/>
                        <path class="checkmark" fill="none" stroke="#008751" stroke-width="4" stroke-linecap="round" d="M14 27l7.5 7.5L38 18"/>
                    </svg>
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#00683e] text-xs font-bold uppercase tracking-wider mb-3">
                    Ballot Submission Certified
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Vote Successfully Cast!</h1>
                <p class="text-xs md:text-sm text-slate-600 mb-8 max-w-md mx-auto">
                    Thank you for participating in the democratic election. Your votes have been securely and cryptographically recorded.
                </p>

                <!-- Vote Confirmation Box -->
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-2xl p-6 mb-8 text-left space-y-3 text-xs">
                    <div class="flex justify-between items-center pb-2 border-b border-emerald-100">
                        <span class="text-slate-500 font-medium">Contests Voted:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $votesCount }} Contests</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-emerald-100">
                        <span class="text-slate-500 font-medium">Timestamp:</span>
                        <span class="font-semibold text-slate-800">{{ now()->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Confirmation Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-200 text-[#005a36]">
                            <span class="w-1.5 h-1.5 bg-[#008751] rounded-full mr-1.5"></span>
                            Encrypted & Confirmed
                        </span>
                    </div>
                </div>

                <!-- Email Notice -->
                @if(isset($memberEmail))
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-8 text-left flex items-start text-xs text-slate-600">
                    <svg class="w-4 h-4 text-[#008751] mr-2.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p>A digital receipt and confirmation email has been dispatched to <strong>{{ $memberEmail }}</strong>.</p>
                </div>
                @endif

                <!-- Ballots List -->
                @if(isset($votes) && count($votes) > 0)
                <div class="text-left mb-8">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Your Ballots Breakdown:</h3>
                    <div class="space-y-2.5">
                        @foreach($votes as $vote)
                        <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                            <div>
                                <p class="font-bold text-slate-900">{{ $vote['election_title'] }}</p>
                                <p class="text-slate-500 text-[11px]">Selected: <strong class="text-[#008751]">{{ $vote['candidate_name'] }}</strong></p>
                            </div>
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-[#008751] flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('election') }}"
                       class="px-8 py-3.5 btn-brand text-white font-bold text-xs rounded-xl shadow-md transition">
                        Return to Elections
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6">
        <div class="container mx-auto px-6 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }}  E-Voting Portal. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
