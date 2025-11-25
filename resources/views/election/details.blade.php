<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Details - E-Vote Portal</title>
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
                    <a href="/" class="flex items-center gap-3 text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <img src="{{ asset('build/assets/fctLogo.png') }}" width="50" height="50" alt="FCT Logo" srcset="">

                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">FCT e-Voting</h1>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8">
        @foreach($elections as $election)
        <!-- Election Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $election->title }}</h1>
                    <p class="text-gray-600">{{ $election->description }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                        Active
                    </span>
                </div>
            </div>

            <!-- Election Timeline -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Starts: <strong>{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y h:i A') }}</strong></span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Ends: <strong>{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y h:i A') }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Candidates Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Candidates</h2>

            <form action="{{ route('election.vote.cast') }}" method="POST" id="vote-form">
                @csrf
                <input type="hidden" name="election_id" value="{{ $election->id }}">
                <input type="hidden" name="member_id" id="member_id" value="">
                <input type="hidden" name="practice_id" id="practice_id" value="">
                <input type="hidden" name="candidate_id" id="candidate_id" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($election->candidates as $candidate)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer candidate-card border-2 border-transparent hover:border-blue-500"
                         data-candidate-id="{{ $candidate->id }}">
                        <!-- Candidate Image Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            @if($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->first_name }} {{ $candidate->last_name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl font-bold text-white">
                                    {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                                </span>
                            @endif
                        </div>

                        <!-- Candidate Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                            </h3>

                            @if($candidate->candidateBio)
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($candidate->candidateBio->bio, 100) }}</p>
                            @endif

                            <div class="space-y-2">
                                <button type="button"
                                        class="view-profile-button w-full px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors"
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
                                <button type="button"
                                        class="vote-button w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                        data-candidate-id="{{ $candidate->id }}"
                                        data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name }}">
                                    Vote for this Candidate
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
        @endforeach

        @if($elections->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Active Elections</h3>
            <p class="text-gray-600">There are currently no active elections available.</p>
        </div>
        @endif
    </div>

    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl overflow-hidden">
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
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date of Birth
                            </h5>
                            <p id="profile-dob" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-biography-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Biography
                            </h5>
                            <p id="profile-biography" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-education-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                </svg>
                                Education Background
                            </h5>
                            <p id="profile-education" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-professional-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Professional Background
                            </h5>
                            <p id="profile-professional" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-promises-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Campaign Promises
                            </h5>
                            <p id="profile-promises" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-achievements-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                Achievements
                            </h5>
                            <p id="profile-achievements" class="text-gray-700 leading-relaxed"></p>
                        </div>

                        <div id="profile-social-section">
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Social Media
                            </h5>
                            <p id="profile-social" class="text-gray-700 leading-relaxed break-all"></p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="button"
                                id="profile-vote-button"
                                class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                                data-candidate-id="">
                            Vote for this Candidate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accreditation Token Modal -->
    <div id="auth-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Accreditation Verification</h3>
                <button id="modal-close" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="accreditation-form">
                <p class="text-gray-600 mb-4">
                    To vote for <strong id="candidate-name" class="font-medium text-gray-800"></strong>, please enter your accreditation token.
                </p>

                <div id="error-message" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>
                <div id="success-message" class="hidden mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm"></div>

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
                    <button type="button" id="modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="verify-button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Verify & Submit Vote
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profile Modal Elements
        const profileModal = document.getElementById('profile-modal');
        const profileModalClose = document.getElementById('profile-modal-close');
        const profileName = document.getElementById('profile-name');
        const profileBio = document.getElementById('profile-bio');
        const profilePhoto = document.getElementById('profile-photo');
        const profileInitials = document.getElementById('profile-initials');
        const profileVoteButton = document.getElementById('profile-vote-button');

        // Auth Modal Elements
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

        // Open profile modal when clicking view profile button
        document.querySelectorAll('.view-profile-button').forEach(button => {
            button.addEventListener('click', function() {
                const data = {
                    id: this.dataset.candidateId,
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

                // Set basic info
                profileName.textContent = data.name;
                document.getElementById('profile-email').textContent = data.email;
                document.getElementById('profile-phone').textContent = data.phone;
                profileVoteButton.dataset.candidateId = data.id;
                profileVoteButton.dataset.candidateName = data.name;

                // Set photo or initials
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

                // Helper function to show/hide sections
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

                // Update all sections
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

        // Close profile modal
        function closeProfileModal() {
            profileModal.classList.add('hidden');
        }

        profileModalClose.addEventListener('click', closeProfileModal);
        profileModal.addEventListener('click', (e) => {
            if (e.target === profileModal) closeProfileModal();
        });

        // Vote from profile modal
        profileVoteButton.addEventListener('click', function() {
            selectedCandidateId = this.dataset.candidateId;
            candidateNameSpan.textContent = this.dataset.candidateName;
            closeProfileModal();
            modal.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
        });

        // Open modal when clicking vote button
        document.querySelectorAll('.vote-button').forEach(button => {
            button.addEventListener('click', function() {
                selectedCandidateId = this.dataset.candidateId;
                candidateNameSpan.textContent = this.dataset.candidateName;
                modal.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                successMessage.classList.add('hidden');
            });
        });

        // Convert input to uppercase
        accreditationTokenInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Close modal
        function closeModal() {
            modal.classList.add('hidden');
            accreditationForm.reset();
            selectedCandidateId = null;
        }

        modalClose.addEventListener('click', closeModal);
        modalCancel.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Handle accreditation form submission
        accreditationForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const token = accreditationTokenInput.value.trim();
            if (!token) return;

            verifyButton.disabled = true;
            verifyButton.textContent = 'Verifying...';
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');

            try {
                // Verify accreditation token
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
                    // Submit vote
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
                        // Show success message
                        successMessage.textContent = 'Vote submitted successfully! Redirecting...';
                        successMessage.classList.remove('hidden');

                        // Redirect to success page
                        setTimeout(() => {
                            window.location.href = submitData.redirect_url;
                        }, 1000);
                    } else {
                        errorMessage.textContent = submitData.message || 'Failed to submit vote. Please try again.';
                        errorMessage.classList.remove('hidden');
                        verifyButton.disabled = false;
                        verifyButton.textContent = 'Verify & Submit Vote';
                    }
                } else {
                    errorMessage.textContent = verifyData.message || 'Invalid or already used accreditation token.';
                    errorMessage.classList.remove('hidden');
                    verifyButton.disabled = false;
                    verifyButton.textContent = 'Verify & Submit Vote';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
                verifyButton.disabled = false;
                verifyButton.textContent = 'Verify & Submit Vote';
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
