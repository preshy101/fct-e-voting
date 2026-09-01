<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Live Real-Time Election Results — e-Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .theme-gradient {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        }
        .btn-brand {
            background: linear-gradient(135deg, #008751 0%, #005a36 100%);
            transition: all 0.3s ease;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #00a865 0%, #006b40 100%);
            box-shadow: 0 10px 25px -5px rgba(0, 135, 81, 0.4);
        }
        .pulse-live {
            animation: livePulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(1.15); }
        }
        .progress-bar-fill {
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header Navigation -->
    <header class="bg-white/95 backdrop-blur-md border-b border-emerald-100 sticky top-0 z-50 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="44" height="44" alt="Logo" class="h-10 w-auto object-contain transition group-hover:scale-105">
                    <div>
                        <div class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-1">
                            <span>e</span><span class="text-[#008751]">-Voting System</span>
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium">Real-Time Election Results Portal</div>
                    </div>
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('election') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition">
                        Active Elections
                    </a>
                    <a href="{{ route('accreditation.index') }}" class="px-4 py-2 text-sm font-semibold text-[#008751] hover:bg-emerald-50 rounded-xl transition">
                        Accreditation
                    </a>
                    <a href="{{ route('election.all') }}" class="inline-flex items-center px-4 py-2 btn-brand text-white text-sm font-bold rounded-xl shadow transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Vote Now
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Container -->
    <main class="flex-grow container mx-auto px-6 py-8 md:py-12 max-w-6xl">

        <!-- Header Hero Banner -->
        <div class="bg-white rounded-3xl border border-emerald-100 shadow-md p-6 md:p-10 mb-10 relative overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold uppercase tracking-wider mb-3 border border-rose-200 shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 pulse-live"></span>
                        <span>Live Certified Vote Stream</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                        Real-Time Election Results
                    </h1>
                    <p class="text-sm md:text-base text-slate-600 max-w-2xl leading-relaxed">
                        Watch election votes as they trickle in from accredited voters in real time across all contested categories.
                    </p>
                </div>

                <!-- Status Pill -->
                <div class="flex-shrink-0 bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Live Polling Status</div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008751]">
                        <span class="w-2 h-2 rounded-full bg-[#008751] animate-ping"></span>
                        <span id="live-indicator">Streaming Live Updates</span>
                    </div>
                    <div class="text-[10px] text-slate-400 mt-1" id="last-updated-time">Auto-updating every 4s</div>
                </div>
            </div>

            <!-- Turnout Summary Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 pt-8 border-t border-slate-100">
                <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-4 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#008751] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Eligible Voters</div>
                        <div class="text-2xl font-black text-slate-900" id="total-members-val">{{ number_format($membersCount) }}</div>
                    </div>
                </div>

                <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-4 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl theme-gradient text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#008751] uppercase tracking-wider">Total Ballots Cast</div>
                        <div class="text-2xl font-black text-[#008751]" id="total-votes-overall">{{ number_format($totalVotesAcrossAll) }}</div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Contested Categories</div>
                        <div class="text-2xl font-black text-slate-900">{{ count($elections) }} Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-Time Elections List -->
        <div class="space-y-8" id="elections-container">
            @forelse($elections as $election)
                @php
                    $electionVotesTotal = $election->candidates->sum('votes_count');
                    $leader = $election->candidates->sortByDesc('votes_count')->first();
                    $leaderVotes = $leader?->votes_count ?? 0;
                    $leaderPercent = $electionVotesTotal > 0 ? round(($leaderVotes / $electionVotesTotal) * 100, 1) : 0;
                @endphp

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 md:p-8" id="election-card-{{ $election->id }}">
                    <!-- Card Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#008751] bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                                    {{ $election->category->title ?? 'General' }}
                                </span>
                                @if($election->year)
                                    <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-md">
                                        {{ $election->year }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center text-xs font-semibold text-emerald-700 bg-emerald-100/60 px-2.5 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#008751] mr-1.5 animate-pulse"></span>
                                    Live Stream
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $election->title }}</h2>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <div class="text-xs text-slate-500">Votes Counted</div>
                                <div class="text-xl font-extrabold text-[#008751]" id="election-total-{{ $election->id }}">
                                    {{ number_format($electionVotesTotal) }}
                                </div>
                            </div>
                            <a href="{{ route('election.result', $election->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#008751] font-bold text-xs rounded-xl border border-slate-200 transition">
                                Detailed Tally &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Current Leader Highlight Banner -->
                    <div class="my-6 theme-gradient text-white p-5 rounded-2xl flex items-center justify-between shadow-sm relative overflow-hidden" id="leader-banner-{{ $election->id }}">
                        <div class="flex items-center space-x-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center font-black text-xl border border-white/30 text-white shadow-inner flex-shrink-0" id="leader-avatar-{{ $election->id }}">
                                {{ $leader ? strtoupper(substr($leader->first_name, 0, 1) . substr($leader->last_name, 0, 1)) : '👑' }}
                            </div>
                            <div>
                                <div class="text-xs font-bold text-emerald-200 uppercase tracking-wider flex items-center gap-1">
                                    <span>👑</span>
                                    <span>Current Leading Candidate</span>
                                </div>
                                <div class="text-lg font-black" id="leader-name-{{ $election->id }}">
                                    {{ ($leader && $leaderVotes > 0) ? $leader->first_name . ' ' . $leader->last_name : 'Voting in Progress' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right relative z-10" id="leader-stats-{{ $election->id }}">
                            <div class="text-xl font-extrabold">{{ number_format($leaderVotes) }} Votes</div>
                            <div class="text-xs text-emerald-200 font-medium">{{ $leaderPercent }}% of counted votes</div>
                        </div>
                    </div>

                    <!-- Candidates Breakdown Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="candidates-grid-{{ $election->id }}">
                        @foreach($election->candidates->sortByDesc('votes_count') as $candidate)
                            @php
                                $candidatePercent = $electionVotesTotal > 0 ? round(($candidate->votes_count / $electionVotesTotal) * 100, 1) : 0;
                            @endphp
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between hover:border-emerald-300 transition" id="candidate-card-{{ $candidate->id }}">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl theme-gradient flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm overflow-hidden">
                                                @if($candidate->photo)
                                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->full_name }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-slate-900 text-sm">{{ $candidate->first_name }} {{ $candidate->last_name }}</h3>
                                                <p class="text-[11px] text-slate-500" id="candidate-percent-text-{{ $candidate->id }}">{{ $candidatePercent }}% of votes</p>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <span class="text-lg font-black text-slate-900" id="candidate-votes-{{ $candidate->id }}">
                                                {{ number_format($candidate->votes_count) }}
                                            </span>
                                            <span class="block text-[10px] text-slate-400 uppercase font-semibold">Votes</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                                        <div class="progress-bar-fill h-2.5 rounded-full {{ $loop->first && $candidate->votes_count > 0 ? 'bg-[#008751]' : 'bg-emerald-400' }}"
                                             id="candidate-bar-{{ $candidate->id }}"
                                             style="width: {{ $candidatePercent }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">No Active Elections Currently</h3>
                    <p class="text-xs text-slate-500">Live vote previews will stream here once election polling begins.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-3">
                <img src="{{ asset('images/federal_logo.jpeg') }}" width="32" height="32" alt="Logo" class="h-8 w-auto">
                <span class="font-bold text-slate-800">e-Voting System</span>
            </div>
            <p class="text-xs text-slate-500">&copy; {{ date('Y') }} E-Voting Portal. Certified cryptographic democratic voting system.</p>
        </div>
    </footer>

    <!-- Real-Time Auto Polling JavaScript -->
    <script>
        async function fetchLiveResults() {
            try {
                const response = await fetch("{{ route('api.elections.all.results') }}");
                if (!response.ok) return;

                const data = await response.json();
                if (!data.success) return;

                // Update total turnout counters
                const totalVotesEl = document.getElementById('total-votes-overall');
                if (totalVotesEl) {
                    totalVotesEl.innerText = Number(data.total_votes_overall).toLocaleString();
                }

                const totalMembersEl = document.getElementById('total-members-val');
                if (totalMembersEl) {
                    totalMembersEl.innerText = Number(data.total_members).toLocaleString();
                }

                // Update each election
                data.elections.forEach(election => {
                    // Update total election votes
                    const electionTotalEl = document.getElementById(`election-total-${election.id}`);
                    if (electionTotalEl) {
                        electionTotalEl.innerText = Number(election.total_votes).toLocaleString();
                    }

                    // Update leader banner
                    const leaderNameEl = document.getElementById(`leader-name-${election.id}`);
                    const leaderStatsEl = document.getElementById(`leader-stats-${election.id}`);
                    const leaderAvatarEl = document.getElementById(`leader-avatar-${election.id}`);

                    if (election.leader) {
                        if (leaderNameEl) leaderNameEl.innerText = election.leader.name;
                        if (leaderAvatarEl) leaderAvatarEl.innerText = election.leader.initials;
                        if (leaderStatsEl) {
                            leaderStatsEl.innerHTML = `
                                <div class="text-xl font-extrabold">${Number(election.leader.votes).toLocaleString()} Votes</div>
                                <div class="text-xs text-emerald-200 font-medium">${election.leader.percent}% of counted votes</div>
                            `;
                        }
                    }

                    // Update candidate vote numbers and progress bars
                    election.candidates.forEach((candidate, idx) => {
                        const votesEl = document.getElementById(`candidate-votes-${candidate.id}`);
                        const barEl = document.getElementById(`candidate-bar-${candidate.id}`);
                        const percentTextEl = document.getElementById(`candidate-percent-text-${candidate.id}`);

                        if (votesEl) votesEl.innerText = Number(candidate.votes_count).toLocaleString();
                        if (barEl) {
                            barEl.style.width = `${candidate.percent}%`;
                            if (idx === 0 && candidate.votes_count > 0) {
                                barEl.classList.remove('bg-emerald-400');
                                barEl.classList.add('bg-[#008751]');
                            } else {
                                barEl.classList.remove('bg-[#008751]');
                                barEl.classList.add('bg-emerald-400');
                            }
                        }
                        if (percentTextEl) percentTextEl.innerText = `${candidate.percent}% of votes`;
                    });
                });

                const lastUpdated = document.getElementById('last-updated-time');
                if (lastUpdated) {
                    const now = new Date();
                    lastUpdated.innerText = `Updated at ${now.toLocaleTimeString()}`;
                }

            } catch (err) {
                console.error("Live results sync error:", err);
            }
        }

        // Poll every 3.5 seconds
        setInterval(fetchLiveResults, 3500);
    </script>
</body>
</html>
