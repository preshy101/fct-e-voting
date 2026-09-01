<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Results: {{ $election->title }} — E-Voting Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .theme-gradient {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-emerald-100 shadow-sm sticky top-0 z-40">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('election') }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#008751]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Elections</span>
                </a>

                <a href="/" class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="36" height="36" alt=" Logo" class="h-9 w-auto">
                    <span class="text-lg font-extrabold text-slate-900"> <span class="text-[#008751]">E-Voting</span></span>
                </a>

                <span class="text-xs font-bold text-[#008751] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Live Tally
                </span>
            </div>
        </nav>
    </header>

    <div class="flex-grow container mx-auto px-6 py-8 max-w-5xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#008751] bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100 mb-2 inline-block">
                    Official Election Results
                </span>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">{{ $election->title }}</h1>
            </div>
            <span class="inline-flex items-center text-xs font-bold text-slate-500 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#008751] mr-2 animate-ping"></span>
                Auto-Updating
            </span>
        </div>

        {{-- ===== Summary Cards ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Members</p>
                <p class="text-3xl font-black text-slate-900" id="total-registered">
                    {{ number_format($membersCount ?? 0) }}
                </p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm">
                <p class="text-xs font-bold text-[#008751] uppercase tracking-wider mb-1">Total Votes Cast</p>
                <p class="text-3xl font-black text-[#008751]" id="total-cast">
                    {{ number_format($election->candidates->sum('votes_count')) }}
                </p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Current Leader</p>
                <p class="text-2xl font-bold text-slate-900 truncate" id="current-leader">
                    {{ $election->candidates->sortByDesc('votes_count')->first()->full_name ?? 'No Votes Yet' }}
                </p>
            </div>
        </div>

        {{-- ===== Current Leader Banner ===== --}}
        @php
            $leader = $election->candidates->sortByDesc('votes_count')->first();
            $leaderVotes = $leader?->votes_count ?? 0;
            $totalVotes = max($election->candidates->sum('votes_count'), 1);
            $leaderPercent = round(($leaderVotes / $totalVotes) * 100, 1);
        @endphp

        <div class="theme-gradient text-white p-6 md:p-8 rounded-3xl mb-8 shadow-xl flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            <div class="relative z-10 text-center sm:text-left">
                <div class="inline-flex items-center gap-1 text-xs font-bold text-emerald-200 uppercase tracking-wider mb-1">
                    <span>👑</span>
                    <span>Leading Candidate</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-black">{{ $leader?->first_name.' '.$leader?->last_name ?? 'No Votes Yet' }}</h2>
                <p class="text-sm text-emerald-100 mt-1 font-medium">{{ number_format($leaderVotes) }} votes ({{ $leaderPercent }}% of votes cast)</p>
            </div>
            @if($leader)
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl font-black text-white border border-white/30 shadow-inner flex-shrink-0">
                    {{ strtoupper(substr($leader->first_name ?? 'C', 0, 1) . substr($leader->last_name ?? '', 0, 1)) }}
                </div>
            @endif
        </div>

        {{-- ===== Candidate Cards Breakdown ===== --}}
        <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            @foreach ($election->candidates->sortByDesc('votes_count') as $candidate)
                @php
                    $percentOfTotal = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0;
                @endphp
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl theme-gradient flex items-center justify-center font-bold text-white text-base flex-shrink-0 shadow-sm overflow-hidden">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->full_name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-bold text-slate-900 truncate">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </h3>
                                <p class="text-xs text-slate-500">{{ $percentOfTotal }}% of votes cast</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-slate-900" id="votes-{{ $candidate->id }}">
                                    {{ number_format($candidate->votes_count) }}
                                </span>
                                <span class="block text-[11px] text-slate-400 font-medium">Votes</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-700 ease-out {{ $loop->first ? 'bg-[#008751]' : 'bg-emerald-400' }}"
                                style="width: {{ $percentOfTotal }}%;"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6">
        <div class="container mx-auto px-6 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
