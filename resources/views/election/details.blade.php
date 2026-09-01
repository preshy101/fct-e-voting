<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>{{ $elections->first()->title ?? 'Election Ballot' }} — E-Voting Portal</title>
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
        .candidate-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .candidate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 135, 81, 0.15);
            border-color: #008751;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-emerald-100 sticky top-0 z-40 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('election') }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#008751]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden sm:inline">Back to Elections</span>
                    </a>
                </div>

                <a href="/" class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="36" height="36" alt=" Logo" class="h-9 w-auto">
                    <span class="text-lg font-extrabold text-slate-900"> <span class="text-[#008751]">E-Voting</span></span>
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('accreditation.index') }}" class="px-3.5 py-1.5 text-xs font-bold text-[#008751] bg-emerald-50 hover:bg-emerald-100 rounded-lg border border-emerald-200 transition">
                        Get Token
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Body Container -->
    <div class="flex-grow container mx-auto px-6 py-8 max-w-6xl">
        
        @if(isset($isPreview) && $isPreview)
        <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-4 mb-6 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <span class="font-bold">Live Preview Mode:</span>
                    <span class="text-sm"> You are previewing the ballot presentation. Voting is disabled.</span>
                </div>
            </div>
            <span class="px-2.5 py-1 bg-amber-200 text-amber-800 text-xs font-bold rounded-md">PREVIEW</span>
        </div>
        @endif

        @foreach($elections as $election)
        <!-- Election Header Details -->
        <div class="bg-white rounded-3xl border border-emerald-100 shadow-md p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#008751] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            {{ $election->category->title ?? 'Election Category' }}
                        </span>
                        @if($election->year)
                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">
                            {{ $election->year }}
                        </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">{{ $election->title }}</h1>
                    <p class="text-sm text-slate-600 max-w-3xl leading-relaxed">{{ $election->description }}</p>
                </div>

                <div class="flex-shrink-0">
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-[#00683e] border border-emerald-200">
                        <span class="w-2 h-2 bg-[#008751] rounded-full mr-2 animate-pulse"></span>
                        Voting Open
                    </span>
                </div>
            </div>

            <!-- Election Timeline Badges -->
            <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <svg class="w-4 h-4 mr-2 text-[#008751]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Voting Opens: <strong class="text-slate-800 font-semibold">{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y h:i A') }}</strong></span>
                </div>
                <div class="flex items-center text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Voting Closes: <strong class="text-slate-800 font-semibold">{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y h:i A') }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Candidates Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Candidates on the Ballot</h2>
                    <p class="text-xs text-slate-500">Review contestant profiles and select your preferred candidate</p>
                </div>
                <span class="text-xs font-bold text-[#008751] bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">
                    {{ $election->candidates->count() }} Candidates
                </span>
            </div>

            <form action="{{ route('election.vote.cast') }}" method="POST" id="vote-form">
                @csrf
                <input type="hidden" name="election_id" value="{{ $election->id }}">
                <input type="hidden" name="member_id" id="member_id" value="">
                <input type="hidden" name="staff_id" id="staff_id" value="">
                <input type="hidden" name="candidate_id" id="candidate_id" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($election->candidates as $candidate)
                    <div class="candidate-card bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between"
                         data-candidate-id="{{ $candidate->id }}">
                        
                        <!-- Candidate Photo / Banner -->
                        <div class="h-52 theme-gradient flex items-center justify-center relative overflow-hidden">
                            @if($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->first_name }} {{ $candidate->last_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border-2 border-white/30 text-white font-black text-3xl tracking-wider shadow-inner">
                                    {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Candidate Info -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </h3>

                                @if($candidate->candidateBio)
                                <p class="text-xs text-slate-500 mb-4 line-clamp-2 leading-relaxed">{{ $candidate->candidateBio->biography ?? $candidate->candidateBio->bio }}</p>
                                @else
                                <p class="text-xs text-slate-400 mb-4 italic">Certified Contestant</p>
                                @endif
                            </div>

                            <div class="space-y-2 pt-3 border-t border-slate-100">
                                <button type="button"
                                        class="view-profile-button w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition"
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
                                    View Profile & Manifesto
                                </button>

                                @if(isset($isPreview) && $isPreview)
                                <button type="button" disabled
                                        class="w-full py-2.5 px-4 bg-slate-200 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                                    Vote Disabled (Preview Mode)
                                </button>
                                @else
                                <button type="button"
                                        class="vote-button w-full py-3 px-4 btn-brand text-white text-xs font-bold rounded-xl shadow transition"
                                        data-candidate-id="{{ $candidate->id }}"
                                        data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name }}">
                                    Vote for Candidate
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
        @endforeach

        @if($elections->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No Active Election Found</h3>
            <p class="text-xs text-slate-500">The requested election is not active or does not exist.</p>
        </div>
        @endif
    </div>

    <!-- Candidate Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-900">Candidate Profile</h3>
                <button id="profile-modal-close" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row">
                <!-- Candidate Image -->
                <div class="md:w-5/12 theme-gradient flex items-center justify-center p-6">
                    <div id="profile-photo-container" class="w-full h-80 flex items-center justify-center">
                        <span id="profile-initials" class="text-7xl font-black text-white/90"></span>
                        <img id="profile-photo" src="" alt="" class="hidden w-full h-full object-cover rounded-2xl shadow-md">
                    </div>
                </div>

                <!-- Candidate Details Body -->
                <div class="md:w-7/12 p-6 md:p-8 overflow-y-auto max-h-[500px]">
                    <h4 id="profile-name" class="text-2xl font-extrabold text-slate-900 mb-2"></h4>

                    <div class="flex flex-wrap gap-3 text-xs text-slate-500 mb-6">
                        <div class="flex items-center" id="email-wrapper">
                            <svg class="w-3.5 h-3.5 mr-1 text-[#008751]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span id="profile-email"></span>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div id="profile-biography-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Biography</h5>
                            <p id="profile-biography" class="text-slate-600 leading-relaxed"></p>
                        </div>

                        <div id="profile-education-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Education Background</h5>
                            <p id="profile-education" class="text-slate-600 leading-relaxed"></p>
                        </div>

                        <div id="profile-professional-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Professional Background</h5>
                            <p id="profile-professional" class="text-slate-600 leading-relaxed"></p>
                        </div>

                        <div id="profile-promises-section">
                            <h5 class="font-bold text-slate-700 uppercase tracking-wider mb-1">Key Manifestos & Promises</h5>
                            <p id="profile-promises" class="text-slate-600 leading-relaxed"></p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        @if(isset($isPreview) && $isPreview)
                        <button type="button" disabled
                                class="w-full py-3 bg-slate-200 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                            Voting Disabled in Preview Mode
                        </button>
                        @else
                        <button type="button"
                                id="profile-vote-button"
                                class="w-full py-3 btn-brand text-white text-xs font-bold rounded-xl shadow-md transition"
                                data-candidate-id="">
                            Cast Vote for this Candidate
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accreditation Token Modal -->
    <div id="auth-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
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
                <button id="modal-close" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="accreditation-form">
                <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                    To cast your vote for <strong id="candidate-name" class="text-slate-900 font-bold"></strong>, please enter your accredited token.
                </p>

                <div id="error-message" class="hidden mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs"></div>
                <div id="success-message" class="hidden mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-xs"></div>

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
                    <button type="button" id="modal-cancel" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit" id="verify-button" class="px-6 py-2.5 btn-brand text-white text-xs font-bold rounded-xl shadow-md transition">
                        Verify & Cast Ballot
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const profileModal = document.getElementById('profile-modal');
        const profileModalClose = document.getElementById('profile-modal-close');
        const profileName = document.getElementById('profile-name');
        const profilePhoto = document.getElementById('profile-photo');
        const profileInitials = document.getElementById('profile-initials');
        const profileVoteButton = document.getElementById('profile-vote-button');

        const modal = document.getElementById('auth-modal');
        const modalClose = document.getElementById('modal-close');
        const modalCancel = document.getElementById('modal-cancel');
        const accreditationForm = document.getElementById('accreditation-form');
        const accreditationTokenInput = document.getElementById('accreditation_token');
        const candidateNameSpan = document.getElementById('candidate-name');
        const verifyButton = document.getElementById('verify-button');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');
        let selectedCandidateId = null;
        let currentElectionId = {{ $elections->first()->id ?? 'null' }};

        document.querySelectorAll('.view-profile-button').forEach(button => {
            button.addEventListener('click', function() {
                const data = {
                    id: this.dataset.candidateId,
                    name: this.dataset.candidateName,
                    email: this.dataset.candidateEmail,
                    phone: this.dataset.candidatePhone,
                    photo: this.dataset.candidatePhoto,
                    biography: this.dataset.candidateBiography,
                    education: this.dataset.candidateEducation,
                    professional: this.dataset.candidateProfessional,
                    promises: this.dataset.candidatePromises,
                    initials: this.dataset.candidateInitials
                };

                profileName.textContent = data.name;
                document.getElementById('profile-email').textContent = data.email || 'Official Candidate';
                if (profileVoteButton) {
                    profileVoteButton.dataset.candidateId = data.id;
                    profileVoteButton.dataset.candidateName = data.name;
                }

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

        function closeProfileModal() {
            profileModal.classList.add('hidden');
        }

        if (profileModalClose) profileModalClose.addEventListener('click', closeProfileModal);
        if (profileModal) profileModal.addEventListener('click', (e) => { if (e.target === profileModal) closeProfileModal(); });

        if (profileVoteButton) {
            profileVoteButton.addEventListener('click', function() {
                selectedCandidateId = this.dataset.candidateId;
                candidateNameSpan.textContent = this.dataset.candidateName;
                closeProfileModal();
                modal.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                successMessage.classList.add('hidden');
            });
        }

        document.querySelectorAll('.vote-button').forEach(button => {
            button.addEventListener('click', function() {
                selectedCandidateId = this.dataset.candidateId;
                candidateNameSpan.textContent = this.dataset.candidateName;
                modal.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                successMessage.classList.add('hidden');
            });
        });

        accreditationTokenInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        function closeModal() {
            modal.classList.add('hidden');
            accreditationForm.reset();
            selectedCandidateId = null;
        }

        if (modalClose) modalClose.addEventListener('click', closeModal);
        if (modalCancel) modalCancel.addEventListener('click', closeModal);
        if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

        accreditationForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const token = accreditationTokenInput.value.trim();
            if (!token) return;

            verifyButton.disabled = true;
            verifyButton.textContent = 'Verifying Token...';
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');

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
                    const submitResponse = await fetch('{{ route("election.vote.cast") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            election_id: currentElectionId,
                            candidate_id: selectedCandidateId,
                            member_id: verifyData.member_id,
                            token: token
                        })
                    });

                    const submitData = await submitResponse.json();

                    if (submitData.success) {
                        successMessage.textContent = 'Ballot cast successfully! Redirecting...';
                        successMessage.classList.remove('hidden');
                        setTimeout(() => {
                            window.location.href = submitData.redirect_url;
                        }, 1000);
                    } else {
                        errorMessage.textContent = submitData.message || 'Failed to submit vote. Please try again.';
                        errorMessage.classList.remove('hidden');
                        verifyButton.disabled = false;
                        verifyButton.textContent = 'Verify & Cast Ballot';
                    }
                } else {
                    errorMessage.textContent = verifyData.message || 'Invalid or already used accreditation token.';
                    errorMessage.classList.remove('hidden');
                    verifyButton.disabled = false;
                    verifyButton.textContent = 'Verify & Cast Ballot';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred. Please check network connection and try again.';
                errorMessage.classList.remove('hidden');
                verifyButton.disabled = false;
                verifyButton.textContent = 'Verify & Cast Ballot';
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12">
        <div class="container mx-auto px-6 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
