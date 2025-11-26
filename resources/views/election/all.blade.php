<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('./build/assets/fctLogo.png') }}">
    <title>Vote in All Elections - E-Vote Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .radio-card:has(input:checked) {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('election') }}" class="flex items-center gap-3 text-gray-600 hover:text-gray-800">
                        <img src="{{ asset('./build/assets/fctLogo.png') }}" width="50" height="50" alt="FCT Logo" srcset="">
                     </a>
                    <h1 class="text-2xl font-bold text-blue-600">FCT e-Voting</h1>
                </div>
                <span class="text-sm text-gray-600">Vote in All Active Elections</span>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8 max-w-5xl">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Cast Your Votes</h1>
            <p class="text-gray-600">Select one candidate from each election below. All your votes will be submitted together after verification.</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <form id="vote-form" method="POST">
            @csrf

            @foreach($elections as $election)
            <!-- Election Card -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $election->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ $election->description }}</p>

                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Starts: <strong>{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y h:i A') }}</strong></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Ends: <strong>{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y h:i A') }}</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Candidates -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Select a Candidate (Optional):</h3>

                    @foreach($election->candidates as $candidate)
                    <label class="radio-card block cursor-pointer">
                        <div class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-300 transition-all">
                            <input type="radio"
                                   name="election_{{ $election->id }}"
                                   value="{{ $candidate->id }}"
                                   class="w-5 h-5 text-blue-600 mr-4">

                            <div class="flex items-center flex-1">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold mr-4">
                                    @if($candidate->photo)
                                        <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->full_name }}" class="w-full h-full object-cover rounded-full">
                                    @else
                                        {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $candidate->full_name }}</h4>
                                    @if($candidate->candidateBio)
                                    <p class="text-sm text-gray-600">{{ Str::limit($candidate->candidateBio->biography, 80) }}</p>
                                    @endif
                                </div>

                                <button type="button"
                                        class="view-profile-btn ml-4 px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
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
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Active Elections</h3>
                <p class="text-gray-600">There are currently no active elections available for voting.</p>
            </div>
            @endif

            @if($elections->isNotEmpty())
            <!-- Submit Section -->
            <div class="bg-white rounded-xl shadow-md p-6 sticky bottom-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">
                            <span id="selected-count">0</span> of {{ $elections->count() }} elections selected
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Select at least one election to submit votes</p>
                    </div>
                    <button type="button"
                            id="submit-btn"
                            class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed"
                            disabled>
                        Submit All Votes
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>

    <!-- Candidate Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900">Candidate Profile</h3>
                <button id="profile-modal-close" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row">
                <!-- Candidate Photo -->
                <div class="md:w-1/2 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center p-8">
                    <div id="profile-photo-container" class="w-full h-96 flex items-center justify-center">
                        <span id="profile-initials" class="text-9xl font-bold text-white"></span>
                        <img id="profile-photo" src="" alt="" class="hidden w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                </div>

                <!-- Candidate Details -->
                <div class="md:w-1/2 p-8 overflow-y-auto max-h-[600px]">
                    <h4 id="profile-name" class="text-3xl font-bold text-gray-900 mb-2"></h4>

                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-6">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span id="profile-email"></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span id="profile-phone"></span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div id="profile-dob-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Date of Birth</h5>
                            <p id="profile-dob" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-biography-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Biography</h5>
                            <p id="profile-biography" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-education-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Education Background</h5>
                            <p id="profile-education" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-professional-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Professional Background</h5>
                            <p id="profile-professional" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-promises-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Campaign Promises</h5>
                            <p id="profile-promises" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-achievements-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Achievements</h5>
                            <p id="profile-achievements" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-social-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Social Media</h5>
                            <p id="profile-social" class="text-gray-700 leading-relaxed break-all"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accreditation Token Modal -->
    <div id="token-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Accreditation Verification</h3>
                <button id="token-modal-close" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="token-form">
                <p class="text-gray-600 mb-4">
                    Please enter your accreditation token to verify your eligibility and submit your votes.
                </p>

                <div id="token-error-message" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>

                <div class="mb-4">
                    <label for="accreditation_token" class="block text-sm font-medium text-gray-700 mb-1">
                        Accreditation Token
                    </label>
                    <input type="text"
                           id="accreditation_token"
                           name="accreditation_token"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase"
                           placeholder="Enter your token"
                           maxlength="10">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="token-modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="verify-token-button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Verify & Submit Votes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profile Modal
        const profileModal = document.getElementById('profile-modal');
        const profileModalClose = document.getElementById('profile-modal-close');

        document.querySelectorAll('.view-profile-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const data = {
                    name: this.dataset.candidateName,
                    email: this.dataset.candidateEmail,
                    phone: this.dataset.candidatePhone,
                    photo: this.dataset.candidatePhoto,
                    biography: this.dataset.candidateBiography,
                    dob: this.dataset.candidateDob,
                    education: this.dataset.candidateEducation,
                    professional: this.dataset.candidateProfessional,
                    promises: this.dataset.candidatePromises,
                    achievements: this.dataset.candidateAchievements,
                    social: this.dataset.candidateSocial,
                    initials: this.dataset.candidateInitials
                };

                document.getElementById('profile-name').textContent = data.name;
                document.getElementById('profile-email').textContent = data.email;
                document.getElementById('profile-phone').textContent = data.phone;

                const profilePhoto = document.getElementById('profile-photo');
                const profileInitials = document.getElementById('profile-initials');

                if (data.photo) {
                    profilePhoto.src = data.photo;
                    profilePhoto.alt = data.name;
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

                updateSection('profile-dob-section', 'profile-dob', data.dob);
                updateSection('profile-biography-section', 'profile-biography', data.biography);
                updateSection('profile-education-section', 'profile-education', data.education);
                updateSection('profile-professional-section', 'profile-professional', data.professional);
                updateSection('profile-promises-section', 'profile-promises', data.promises);
                updateSection('profile-achievements-section', 'profile-achievements', data.achievements);
                updateSection('profile-social-section', 'profile-social', data.social);

                profileModal.classList.remove('hidden');
            });
        });

        profileModalClose.addEventListener('click', () => profileModal.classList.add('hidden'));
        profileModal.addEventListener('click', (e) => {
            if (e.target === profileModal) profileModal.classList.add('hidden');
        });

        // Vote Selection Counter
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        const selectedCount = document.getElementById('selected-count');
        const submitBtn = document.getElementById('submit-btn');
        const totalElections = {{ $elections->count() }};

        function updateCounter() {
            const selected = document.querySelectorAll('input[type="radio"]:checked').length;
            selectedCount.textContent = selected;
            // Enable submit button if at least one election is selected
            submitBtn.disabled = selected < 1;
        }

        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateCounter);
        });

        // Token Modal
        const tokenModal = document.getElementById('token-modal');
        const tokenModalClose = document.getElementById('token-modal-close');
        const tokenModalCancel = document.getElementById('token-modal-cancel');
        const tokenForm = document.getElementById('token-form');
        const tokenErrorMessage = document.getElementById('token-error-message');
        const verifyTokenButton = document.getElementById('verify-token-button');
        const accreditationTokenInput = document.getElementById('accreditation_token');

        submitBtn.addEventListener('click', () => {
            tokenModal.classList.remove('hidden');
            tokenErrorMessage.classList.add('hidden');
        });

        tokenModalClose.addEventListener('click', () => {
            tokenModal.classList.add('hidden');
            tokenForm.reset();
        });

        tokenModalCancel.addEventListener('click', () => {
            tokenModal.classList.add('hidden');
            tokenForm.reset();
        });

        tokenModal.addEventListener('click', (e) => {
            if (e.target === tokenModal) {
                tokenModal.classList.add('hidden');
                tokenForm.reset();
            }
        });

        // Convert input to uppercase
        accreditationTokenInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Handle token verification and form submission
        tokenForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const token = accreditationTokenInput.value.trim();
            if (!token) return;

            verifyTokenButton.disabled = true;
            verifyTokenButton.textContent = 'Verifying...';
            tokenErrorMessage.classList.add('hidden');

            try {
                // Verify token
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
                    // Collect all votes
                    const votes = {};
                    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                        const electionId = radio.name.replace('election_', '');
                        votes[electionId] = radio.value;
                    });

                    // Submit votes
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
                        // Redirect to success page
                        window.location.href = submitData.redirect_url;
                    } else {
                        tokenErrorMessage.textContent = submitData.message || 'Failed to submit votes. Please try again.';
                        tokenErrorMessage.classList.remove('hidden');
                        verifyTokenButton.disabled = false;
                        verifyTokenButton.textContent = 'Verify & Submit Votes';
                    }
                } else {
                    tokenErrorMessage.textContent = verifyData.message || 'Invalid accreditation token. Please check and try again.';
                    tokenErrorMessage.classList.remove('hidden');
                    verifyTokenButton.disabled = false;
                    verifyTokenButton.textContent = 'Verify & Submit Votes';
                }
            } catch (error) {
                console.error('Error:', error);
                tokenErrorMessage.textContent = 'An error occurred. Please try again.';
                tokenErrorMessage.classList.remove('hidden');
                verifyTokenButton.disabled = false;
                verifyTokenButton.textContent = 'Verify & Submit Votes';
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-6 py-6 text-center text-gray-500">
            <p>&copy; 2025 E-Vote Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
