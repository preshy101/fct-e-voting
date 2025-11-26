<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('./build/assets/fctLogo.png') }}">
    <title>Voter Accreditation - E-Vote Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .spinner {
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function copyToken(token) {
            // Create a temporary textarea element
            const textarea = document.createElement('textarea');
            textarea.value = token;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);

            // Select and copy the text
            textarea.select();
            textarea.setSelectionRange(0, 99999); // For mobile devices

            try {
                document.execCommand('copy');

                // Show success feedback
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Copied!
                `;
                button.classList.add('bg-green-600');
                button.classList.remove('bg-blue-600', 'hover:bg-blue-700');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600');
                    button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy token:', err);
                alert('Failed to copy token. Please copy it manually.');
            }

            // Remove the temporary textarea
            document.body.removeChild(textarea);
        }

        function handleFormSubmit(event) {
            const form = event.target;
            const submitButton = form.querySelector('button[type="submit"]');
            const buttonText = submitButton.querySelector('.button-text');
            const buttonSpinner = submitButton.querySelector('.button-spinner');

            // Disable the button and show spinner
            submitButton.disabled = true;
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
            submitButton.classList.remove('hover:bg-blue-700');

            // Hide text and show spinner
            buttonText.classList.add('hidden');
            buttonSpinner.classList.remove('hidden');
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/" class="flex items-center gap-3 text-2xl text-gray-600 hover:text-gray-800">
                        <img src="{{ asset('./build/assets/fctLogo.png') }}" width="50" height="50" alt="FCT Logo" srcset="">
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">FCT e-Voting</h1>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Voter Accreditation</h1>
                <p class="text-lg text-gray-600">
                    Request accreditation to participate in restricted elections
                </p>
            </div>

            <!-- Accreditation Time Status -->
            @if(isset($setting) && $setting->accreditation_start_time && $setting->accreditation_end_time)
                @if($isAccreditationActive)
                    <div class="bg-green-50 border-2 border-green-300 rounded-xl p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-8 h-8 text-green-600 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Accreditation is Open</h3>
                                <p class="text-green-800 mb-3">You can request your accreditation token now.</p>
                                <div class="text-sm text-green-700 space-y-1">
                                    <p><strong>Started:</strong> {{ $setting->accreditation_start_time->format('F j, Y \a\t g:i A') }}</p>
                                    <p><strong>Ends:</strong> {{ $setting->accreditation_end_time->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-2 border-red-300 rounded-xl p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-8 h-8 text-red-600 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-red-900 mb-2">Accreditation Not Available</h3>
                                <p class="text-red-800 mb-3">{{ $accreditationMessage }}</p>
                                <div class="text-sm text-red-700 space-y-1">
                                    <p><strong>Opens:</strong> {{ $setting->accreditation_start_time->format('F j, Y \a\t g:i A') }}</p>
                                    <p><strong>Closes:</strong> {{ $setting->accreditation_end_time->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($accreditation) && !$accreditation->is_approved)
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-8 h-8 text-yellow-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-900 mb-1">Accreditation Pending</h3>
                        <p class="text-yellow-700">Your accreditation request is being reviewed. You will receive an email once approved.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Accreditation Request Form -->
            <div class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Request Accreditation</h2>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('token'))
                <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl p-6 shadow-lg">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Your Accreditation Token</h3>
                        <p class="text-sm text-gray-600 mb-4">Please save this token. You will need it to cast your vote.</p>

                        <div class="bg-white rounded-lg p-6 shadow-inner mb-4">
                            <div class="text-5xl font-bold text-blue-600 tracking-widest font-mono mb-2">
                                {{ session('token') }}
                            </div>
                            <button onclick="copyToken('{{ session('token') }}')"
                                    class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy Token
                            </button>
                        </div>

                        @if(session('member'))
                        <div class="bg-white rounded-lg p-4 text-left">
                            <h4 class="font-semibold text-gray-900 mb-2">Member Information:</h4>
                            <div class="text-sm text-gray-700 space-y-1">
                                <p><span class="font-medium">Name:</span> {{ session('member')->first_name }} {{ session('member')->last_name }}</p>
                                <p><span class="font-medium">Practice ID:</span> {{ session('member')->practice_ID }}</p>
                                @if(session('member')->email)
                                <p><span class="font-medium">Email:</span> {{ session('member')->email }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-xs text-yellow-800 flex items-start">
                                <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>Important:</strong> Keep this token secure. It can only be used once to cast your vote. Do not share it with anyone.</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                    {{ session('error') }}
                </div>
                @endif
                <!-- Information Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            What happens next?
                        </h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>1. Your accreditation request will be reviewed by the election administrator</li>
                            <li>2. You will receive an email notification once your request is approved or rejected</li>
                            <li>3. If approved, you will receive an accreditation token to access the election</li>
                        </ul>
                    </div>

                <form action="{{ route('accreditation.request') }}" method="POST" class="space-y-6" onsubmit="handleFormSubmit(event)">
                    @csrf

                    <!-- Practice ID -->
                    <div>
                        <label for="practice_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Practice ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="practice_id"
                               name="practice_id"
                               required
                               {{ !$isAccreditationActive ? 'disabled' : '' }}
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ !$isAccreditationActive ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                               placeholder="Enter your Practice ID">
                        @error('practice_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Submit Button -->
                    <button type="submit"
                            {{ !$isAccreditationActive ? 'disabled' : '' }}
                            class="w-full px-6 py-3 {{ $isAccreditationActive ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }} text-white font-medium rounded-lg transition-colors shadow-md flex items-center justify-center">
                        <span class="button-text">
                            {{ $isAccreditationActive ? 'Submit Accreditation Request' : 'Accreditation Not Available' }}
                        </span>
                        <span class="button-spinner hidden">
                            <div class="spinner inline-block mr-2"></div>
                            Processing...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 mb-2">
                    Need help with accreditation? <a href="mailto:info@niprfct.org.ng" class="text-blue-600 hover:text-blue-700 font-medium">
                    Contact Support: +2348060126048 • +2348054771414 • +2348039652051
                </a>
                </p>
                <a href="{{ route('election') }}"  class="text-blue-600 hover:text-blue-700 font-medium">
                    Go To Elections
                </a>
                {{--  --}}
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
