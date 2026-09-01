<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Vote Cast Successfully E-Voting Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .btn-brand {
            background: linear-gradient(135deg, #008751 0%, #005a36 100%);
            transition: all 0.25s ease;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #00a865 0%, #006b40 100%);
            box-shadow: 0 10px 25px -5px rgba(0, 135, 81, 0.4);
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

    <div class="flex-grow container mx-auto px-6 py-12">
        <div class="max-w-xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-2xl p-8 md:p-10 text-center">
                <div class="mx-auto w-18 h-18 bg-emerald-100 rounded-full flex items-center justify-center mb-6 p-4">
                    <svg class="w-10 h-10 text-[#008751]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#00683e] text-xs font-bold uppercase tracking-wider mb-3">
                    Certified Ballot
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">Vote Cast Successfully!</h1>

                <p class="text-xs md:text-sm text-slate-600 mb-6">
                    Thank you for casting your vote in <strong class="text-slate-900">{{ $election->title }}</strong>
                </p>

                <!-- Vote Reference -->
                <div class="bg-emerald-50/70 border-2 border-emerald-200 rounded-2xl p-6 mb-8">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cryptographic Vote Reference Number</p>
                    <p class="text-2xl md:text-3xl font-black text-[#008751] font-mono tracking-widest">{{ $vote_reference }}</p>
                    <p class="text-[11px] text-slate-500 mt-3">
                        Please save this reference number for your audit records.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('election.result', $election->id) }}"
                       class="px-6 py-3 btn-brand text-white text-xs font-bold rounded-xl shadow-md transition">
                        View Election Results
                    </a>
                    <a href="/"
                       class="px-6 py-3 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-200 transition">
                        Return to Home
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
