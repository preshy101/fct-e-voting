<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Official Voting Booth — e-Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .radio-card:has(input:checked) {
            border-color: #008751 !important;
            background-color: #f0fdf4 !important;
        }
        .radio-card:has(input:checked) .radio-indicator {
            background-color: #008751;
            border-color: #008751;
        }
        .pulse-live {
            animation: livePulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(1.15); }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-emerald-100 sticky top-0 z-40 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('election') }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#008751]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to Elections</span>
                </a>

                <a href="/" class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="36" height="36" alt="Logo" class="h-9 w-auto">
                    <span class="text-lg font-extrabold text-slate-900 flex items-center gap-1"><span>e</span><span class="text-[#008751]">-Voting</span></span>
                </a>

                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-[#008751] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Official Voting Booth
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <div class="flex-grow container mx-auto px-6 py-8 max-w-5xl">
        
        <!-- Live Real-Time Preview Banner -->
        <section class="bg-gradient-to-r from-slate-900 via-slate-800 to-[#004d2e] rounded-3xl p-6 md:p-8 text-white mb-8 shadow-xl border border-emerald-500/30 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-[#008751]/30 rounded-full blur-2xl pointer-events-none"></div>
            <div class="flex items-center space-x-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/20 border border-rose-500/40 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <span class="w-4 h-4 rounded-full bg-rose-500 pulse-live"></span>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[11px] font-bold uppercase tracking-wider mb-1">
                        <span>🔴 Live Vote Stream</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black tracking-tight">Real-Time Election Votes Preview</h3>
                    <p class="text-xs md:text-sm text-slate-300 mt-0.5">Preview live incoming votes and candidate percentage standings as they trickle in.</p>
                </div>
            </div>
            <a href="{{ route('election.live.results') }}" class="inline-flex items-center px-6 py-3.5 bg-[#008751] hover:bg-[#00a865] text-white font-extrabold rounded-2xl text-sm shadow-lg transition whitespace-nowrap relative z-10">
                <span>View Live Real-Time Tally</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </section>

        <!-- Page Title Card -->
        <div class="bg-white rounded-3xl border border-emerald-100 shadow-md p-6 md:p-8 mb-8">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#00683e] text-xs font-bold uppercase tracking-wider mb-3 border border-emerald-200">
                Multi-Election Ballot
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">Vote in All Active Elections</h1>
            <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                Select your preferred candidate for each election category below. When you're ready, click submit to verify your token and securely cast all your votes at once.
            </p>
        </div>

        @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-6 flex items-center text-rose-800 text-xs font-semibold">
            <svg class="w-5 h-5 text-rose-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form id="vote-form" method="POST">
            @csrf

            @foreach($elections as $election)
            <!-- Election Category Section Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 md:p-8 mb-8">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#008751] bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                            {{ $election->category->title ?? 'Contest' }}
                        </span>
                        <span class="text-xs font-medium text-slate-500">
                            Ends: {{ \Carbon\Carbon::parse($election->end_date)->format('M d, h:i A') }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 mb-1">{{ $election->title }}</h2>
                    @if($election->description)
                    <p class="text-xs text-slate-500">{{ $election->description }}</p>
                    @endif
                </div>

                <!-- Candidates Selection List -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Choose Candidate:</h3>

                    @foreach($election->candidates as $candidate)
                    <label class="radio-card block cursor-pointer rounded-2xl border-2 border-slate-200 transition-all overflow-hidden hover:border-emerald-300">
                        <div class="flex items-center p-4">
                            <input type="radio"
                                   name="election_{{ $election->id }}"
                                   value="{{ $candidate->id }}"
                                   class="w-5 h-5 text-[#008751] focus:ring-[#008751] border-slate-300 mr-4">

                            <div class="flex items-center flex-1 justify-between gap-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full theme-gradient flex items-center justify-center text-white font-bold text-sm mr-3.5 flex-shrink-0 shadow-sm overflow-hidden">
                                        @if($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                        @endif
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm md:text-base">{{ $candidate->full_name }}</h4>
                                        @if($candidate->candidateBio)
                                        <p class="text-xs text-slate-500 line-clamp-1">{{ $candidate->candidateBio->biography ?? $candidate->candidateBio->bio }}</p>
                                        @endif
                                    </div>
                                </div>

                                <button type="button"
                                        class="view-profile-btn px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition"
                                        data-candidate-id="{{ $candidate->id }}"
                                        data-candidate-name="{{ $candidate->full_name }}"
                                        data-candidate-email="{{ $candidate->email }}"
                                        data-candidate-phone="{{ $candidate->phone_number }}"
                                        data-candidate-photo="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : '' }}"
                                        data-candidate-biography="{{ $candidate->candidateBio?->biography ?? 'No biography available.' }}"
                                        data-candidate-dob="{{ $candidate->candidateBio?->date_of_birth ? \Carbon\Carbon::parse($candidate->candidateBio->date_of_birth)->format('F d, Y') : '' }}"
                                        data-candidate-education="{{ $candidate->candidateBio?->education_background ?? '' }}"
                                        data-candidate-professional="{{ $candidate->candidateBio?->professional_background ?? '' }}"
                                        data-candidate-promises="{{ $candidate->candidateBio?->campaign_promises ?? '' }}"
                                        data-candidate-achievements="{{ $candidate->candidateBio?->achievements ?? '' }}"
                                        data-candidate-social="{{ $candidate->candidateBio?->social_media_handles ?? '' }}"
                                        data-candidate-initials="{{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            @if($elections->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Active Elections Available</h3>
                <p class="text-xs text-slate-500">There are currently no active contests open for voting.</p>
            </div>
            @endif

            @if($elections->isNotEmpty())
            <!-- Sticky Bottom Submit Action Bar -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl border border-emerald-200 shadow-2xl p-5 sticky bottom-4 z-30">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                            <span id="selected-count" class="w-6 h-6 rounded-full bg-emerald-100 text-[#008751] flex items-center justify-center text-xs font-black">0</span>
                            <span>of {{ $elections->count() }} Contests Selected</span>
                        </div>
                        <p class="text-xs text-slate-500 hidden sm:block">Select your choices then submit with your token.</p>
                    </div>
                    <button type="button"
                            id="submit-btn"
                            class="px-8 py-3.5 btn-brand text-white text-sm font-bold rounded-2xl shadow-lg transition duration-200 disabled:bg-slate-300 disabled:from-slate-300 disabled:to-slate-300 disabled:cursor-not-allowed disabled:shadow-none"
                            disabled>
                        Submit All Ballots
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>

    <!-- Candidate Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-900">Candidate Profile</h3>
                <button id="profile-modal-close" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row">
                <div class="md:w-5/12 theme-gradient flex items-center justify-center p-6">
                    <div id="profile-photo-container" class="w-full h-80 flex items-center justify-center">
                        <span id="profile-initials" class="text-7xl font-black text-white/90"></span>
                        <img id="profile-photo" src="" alt="" class="hidden w-full h-full object-cover rounded-2xl shadow-md">
                    </div>
                </div>

                <div class="md:w-7/12 p-6 md:p-8 overflow-y-auto max-h-[500px]">
                    <h4 id="profile-name" class="text-2xl font-extrabold text-slate-900 mb-2"></h4>
                    <div class="text-xs text-slate-500 mb-6 flex items-center">
                        <span id="profile-email"></span>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div id="profile-biography-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Biography</h5>
                            <p id="profile-biography" class="text-slate-600 leading-relaxed"></p>
                        </div>
                        <div id="profile-education-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Education</h5>
                            <p id="profile-education" class="text-slate-600 leading-relaxed"></p>
                        </div>
                        <div id="profile-professional-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Professional Background</h5>
                            <p id="profile-professional" class="text-slate-600 leading-relaxed"></p>
                        </div>
                        <div id="profile-promises-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Manifesto & Promises</h5>
                            <p id="profile-promises" class="text-slate-600 leading-relaxed"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accreditation Token Modal -->
    <div id="token-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="bg-white w-full max-w-md p-6 md:p-8 rounded-3xl shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#008751] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Voter Verification</h3>
                </div>
                <button id="token-modal-close" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="token-form">
                <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                    Please enter your single-use accreditation token to verify your eligibility and submit all selected ballots.
                </p>

                <div id="token-error-message" class="hidden mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs"></div>

                <div class="mb-5">
                    <label for="accreditation_token" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Accreditation Token <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="accreditation_token"
                           name="accreditation_token"
                           required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-slate-900 font-mono tracking-widest text-base font-bold uppercase placeholder-slate-400"
                           placeholder="e.g. 8K2M9P"
                           maxlength="10">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="token-modal-cancel" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit" id="verify-token-button" class="px-6 py-2.5 btn-brand text-white text-xs font-bold rounded-xl shadow-md transition">
                        Verify & Submit All Votes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const profileModal = document.getElementById('profile-modal');
        const profileModalClose = document.getElementById('profile-modal-close');

        document.querySelectorAll('.view-profile-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const data = {
                    name: this.dataset.candidateName,
                    email: this.dataset.candidateEmail,
                    photo: this.dataset.candidatePhoto,
                    biography: this.dataset.candidateBiography,
                    education: this.dataset.candidateEducation,
                    professional: this.dataset.candidateProfessional,
                    promises: this.dataset.candidatePromises,
                    initials: this.dataset.candidateInitials
                };

                document.getElementById('profile-name').textContent = data.name;
                document.getElementById('profile-email').textContent = data.email || 'Official Candidate';

                const profilePhoto = document.getElementById('profile-photo');
                const profileInitials = document.getElementById('profile-initials');

                if (data.photo) {
                    profilePhoto.src = data.photo;
                    profilePhoto.classList.remove('hidden');
                    profileInitials.classList.add('hidden');
                } else {
                    profilePhoto.classList.add('hidden');
                    profileInitials.textContent = data.initials;
                    profileInitials.classList.remove('hidden');
                }

                const updateSection = (sectionId, elementId, content) => {
                    const section = document.getElementById(sectionId);
                    const element = document.getElementById(elementId);
                    if (content && content.trim() !== '') {
                        element.textContent = content;
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                };

                updateSection('profile-biography-section', 'profile-biography', data.biography);
                updateSection('profile-education-section', 'profile-education', data.education);
                updateSection('profile-professional-section', 'profile-professional', data.professional);
                updateSection('profile-promises-section', 'profile-promises', data.promises);

                profileModal.classList.remove('hidden');
            });
        });

        if (profileModalClose) profileModalClose.addEventListener('click', () => profileModal.classList.add('hidden'));
        if (profileModal) profileModal.addEventListener('click', (e) => { if (e.target === profileModal) profileModal.classList.add('hidden'); });

        const radioButtons = document.querySelectorAll('input[type="radio"]');
        const selectedCount = document.getElementById('selected-count');
        const submitBtn = document.getElementById('submit-btn');

        function updateCounter() {
            const selected = document.querySelectorAll('input[type="radio"]:checked').length;
            if (selectedCount) selectedCount.textContent = selected;
            if (submitBtn) submitBtn.disabled = selected < 1;
        }

        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateCounter);
        });

        const tokenModal = document.getElementById('token-modal');
        const tokenModalClose = document.getElementById('token-modal-close');
        const tokenModalCancel = document.getElementById('token-modal-cancel');
        const tokenForm = document.getElementById('token-form');
        const tokenErrorMessage = document.getElementById('token-error-message');
        const verifyTokenButton = document.getElementById('verify-token-button');
        const accreditationTokenInput = document.getElementById('accreditation_token');

        if (submitBtn) {
            submitBtn.addEventListener('click', () => {
                tokenModal.classList.remove('hidden');
                tokenErrorMessage.classList.add('hidden');
            });
        }

        if (tokenModalClose) tokenModalClose.addEventListener('click', () => { tokenModal.classList.add('hidden'); tokenForm.reset(); });
        if (tokenModalCancel) tokenModalCancel.addEventListener('click', () => { tokenModal.classList.add('hidden'); tokenForm.reset(); });
        if (tokenModal) tokenModal.addEventListener('click', (e) => { if (e.target === tokenModal) { tokenModal.classList.add('hidden'); tokenForm.reset(); } });

        if (accreditationTokenInput) {
            accreditationTokenInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        if (tokenForm) {
            tokenForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const token = accreditationTokenInput.value.trim();
                if (!token) return;

                verifyTokenButton.disabled = true;
                verifyTokenButton.textContent = 'Verifying Token...';
                tokenErrorMessage.classList.add('hidden');

                try {
                    const verifyResponse = await fetch('{{ route("accreditation.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ token: token })
                    });

                    const verifyData = await verifyResponse.json();

                    if (verifyData.success) {
                        const votes = {};
                        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                            const electionId = radio.name.replace('election_', '');
                            votes[electionId] = radio.value;
                        });

                        const submitResponse = await fetch('{{ route("election.all.submit") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                votes: votes,
                                member_id: verifyData.member_id,
                                token: token
                            })
                        });

                        const submitData = await submitResponse.json();

                        if (submitData.success) {
                            window.location.href = submitData.redirect_url;
                        } else {
                            tokenErrorMessage.textContent = submitData.message || 'Failed to submit votes. Please try again.';
                            tokenErrorMessage.classList.remove('hidden');
                            verifyTokenButton.disabled = false;
                            verifyTokenButton.textContent = 'Verify & Submit All Votes';
                        }
                    } else {
                        tokenErrorMessage.textContent = verifyData.message || 'Invalid accreditation token. Please check and try again.';
                        tokenErrorMessage.classList.remove('hidden');
                        verifyTokenButton.disabled = false;
                        verifyTokenButton.textContent = 'Verify & Submit All Votes';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    tokenErrorMessage.textContent = 'An error occurred. Please try again.';
                    tokenErrorMessage.classList.remove('hidden');
                    verifyTokenButton.disabled = false;
                    verifyTokenButton.textContent = 'Verify & Submit All Votes';
                }
            });
        }
    </script>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12">
        <div class="container mx-auto px-6 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }}  E-Voting Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
