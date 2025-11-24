<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $election->title }} - E-Vote Portal</title>
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
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">Elections</h1>
                </div>
                {{-- <div class="text-sm text-gray-600">
                    Ballot box:
                    <span class="font-medium"><a href="{{ route('election.result') }}" target="_blank" rel="noopener noreferrer"></a></span>
                </div> --}}
            </div>
        </nav>
    </header>
<div class="container mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6">Election Results — {{ $election->title }}</h1>

    {{-- ===== Summary Cards ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Total Number of Members</p>
            <p class="text-2xl font-semibold text-gray-800" id="total-registered">
                {{ number_format($membersCount ?? 0) }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Total Votes Cast</p>
            <p class="text-2xl font-semibold text-indigo-600" id="total-cast">
                {{ $election->candidates->sum('votes_count') }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Leading Candidate</p>
            <p class="text-2xl font-semibold text-green-600" id="current-leader">
                {{ $election->candidates->sortByDesc('votes_count')->first()->name ?? 'N/A' }}
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

    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 rounded-xl mb-8 shadow-lg flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold">🏆 Current Leader</h2>
            <p class="text-2xl font-bold">{{ $leader?->first_name.' '.$leader?->last_name ?? 'No Votes Yet' }}</p>
            <p class="text-sm opacity-90">{{ $leaderVotes }} votes ({{ $leaderPercent }}%)</p>
        </div>
        @if($leader)
            <div class="bg-white text-orange-600 w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold">
                {{ strtoupper(substr($leader->name, 0, 2)) }}
            </div>
        @endif
    </div>

    {{-- ===== Candidate Cards ===== --}}
    <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 auto-rows-fr">
        @foreach ($election->candidates->sortByDesc('votes_count') as $candidate)
            @php
                $percent = $membersCount > 0 ? round(($candidate->votes_count / $membersCount) * 100, 1) : 0;
            @endphp
            <div class="bg-white p-6 rounded-xl shadow border border-gray-200 flex flex-col justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                        {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                        </h3>

                        <!-- Progress Bar (Full Card Width) -->
                        <div class="w-full bg-gray-200 h-3 rounded-full mt-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-700 ease-out {{ $loop->first ? 'bg-green-500' : 'bg-blue-500' }}"
                                style="width: {{ $percent }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3">
                    <p class="text-sm text-gray-500">{{ $percent }}% of total members</p>
                    <p class="text-xl font-bold text-gray-900" id="votes-{{ $candidate->id }}">
                        {{ $candidate->votes_count }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>


</div>

{{-- ===== Live Auto-Refresh Script ===== --}}

<script>
setInterval(() => {
    console.log('Fetching latest results...');
    fetch("{{ route('api.election.results', $election->id) }}")
        .then(res => res.json())
        .then(data => {
            let totalVotes = 0;
            data.forEach(c => totalVotes += c.votes_count);

            // Update candidates
            data.forEach(c => {
                const el = document.getElementById(`votes-${c.id}`);
                if (el) el.innerText = c.votes_count;
            });

            // Update total votes & leader
            document.getElementById('total-cast').innerText = totalVotes;

            const leader = data.sort((a, b) => b.votes_count - a.votes_count)[0];
            if (leader) {
                document.getElementById('current-leader').innerText = leader.name;
            }
        });
}, 5000); // every 5 seconds
</script>
<script>
document.querySelectorAll('[id^="votes-"]').forEach(el => {
    const candidate = data.find(c => `votes-${c.id}` === el.id);
    if (candidate) {
        el.innerText = candidate.votes_count;
        const progressBar = el.closest('.bg-white').querySelector('.h-3.rounded-full');
        const percent = (candidate.votes_count / data.total_members) * 100;
        progressBar.style.width = percent + '%';
    }
});
</script>
</body>
</html>
