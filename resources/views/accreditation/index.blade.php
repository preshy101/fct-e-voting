<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Voter Accreditation E-Voting Portal</title>
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
            transition: all 0.3s ease;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #00a865 0%, #006b40 100%);
            box-shadow: 0 10px 25px -5px rgba(0, 135, 81, 0.4);
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
            const textarea = document.createElement('textarea');
            textarea.value = token;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            textarea.setSelectionRange(0, 99999);

            try {
                document.execCommand('copy');
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Token Copied!
                `;
                button.classList.add('bg-emerald-700');
                button.classList.remove('bg-[#008751]');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-emerald-700');
                    button.classList.add('bg-[#008751]');
                }, 2500);
            } catch (err) {
                console.error('Failed to copy token:', err);
                alert('Failed to copy token. Please copy it manually.');
            }
            document.body.removeChild(textarea);
        }

        function handleFormSubmit(event) {
            const form = event.target;
            const submitButton = form.querySelector('button[type="submit"]');
            const buttonText = submitButton.querySelector('.button-text');
            const buttonSpinner = submitButton.querySelector('.button-spinner');

            submitButton.disabled = true;
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');

            buttonText.classList.add('hidden');
            buttonSpinner.classList.remove('hidden');
        }
    </script>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <!-- Header -->
    <header class="bg-white border-b border-emerald-100 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="44" height="44" alt="Logo" class="h-10 w-auto object-contain">
                    <div>
                        <div class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-1">
                            <span>e</span><span class="text-[#008751]">-Voting System</span>
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium">Voter Accreditation</div>
                    </div>
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('election.live.results') }}" class="px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        Live Results
                    </a>
                    <a href="{{ route('election') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition">
                        View Elections
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Container -->
    <div class="flex-grow container mx-auto px-6 py-10 md:py-14">
        <div class="max-w-2xl mx-auto">

            <!-- Page Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#00683e] text-xs font-bold uppercase tracking-wider mb-3 border border-emerald-200">
                    Step 1 of 2
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Voter Accreditation</h1>
                <p class="text-sm md:text-base text-slate-600">
                    Verify your membership using your staff email address or staff ID to obtain an official accreditation token.
                </p>
            </div>

            <!-- Accreditation Status Notice -->
            @if(isset($setting) && $setting->accreditation_start_time && $setting->accreditation_end_time)
                @if($isAccreditationActive)
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-8 shadow-sm">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-[#008751] text-white flex items-center justify-center mr-3.5 flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-base font-bold text-emerald-950 mb-1">Accreditation Portal is Open</h2>
                                <p class="text-xs text-emerald-800 mb-2">You can request your accreditation token now.</p>
                                <div class="text-xs text-emerald-700 flex flex-wrap gap-x-4 gap-y-1">
                                    <span><strong>Opens:</strong> {{ $setting->accreditation_start_time->format('M d, Y h:i A') }}</span>
                                    <span><strong>Closes:</strong> {{ $setting->accreditation_end_time->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8 shadow-sm">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center mr-3.5 flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-base font-bold text-amber-950 mb-1">Accreditation Window Closed</h2>
                                <p class="text-xs text-amber-800 mb-2">{{ $accreditationMessage }}</p>
                                <div class="text-xs text-amber-700 flex flex-wrap gap-x-4 gap-y-1">
                                    <span><strong>Window:</strong> {{ $setting->accreditation_start_time->format('M d, h:i A') }} — {{ $setting->accreditation_end_time->format('M d, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6">
                    <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Token Generated Box -->
            @if(session('token'))
            <div class="mb-8 bg-gradient-to-br from-emerald-50 via-white to-emerald-50 border-2 border-[#008751] rounded-3xl p-8 md:p-10 shadow-xl text-center">
                <div class="w-16 h-16 bg-emerald-100 text-[#008751] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">Accreditation Successful!</h2>
                <p class="text-xs md:text-sm text-slate-600 mb-6 max-w-lg mx-auto leading-relaxed">
                    Your confidential single-use voting token has been issued. For privacy and security, the token is concealed below and has been sent directly to your registered phone and email.
                </p>

                <!-- Hidden Masked Token Box -->
                <div class="bg-white border-2 border-emerald-200 rounded-2xl p-5 shadow-inner mb-6 max-w-xs mx-auto">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Accreditation Token</div>
                    <div class="text-3xl md:text-4xl font-black text-slate-700 tracking-[0.35em] font-mono select-none">
                        ••••••
                    </div>
                    <div class="text-[11px] text-emerald-700 font-semibold mt-1 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5 text-[#008751]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Concealed for Security</span>
                    </div>
                </div>

                <!-- Delivery Channels Notice Card -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 max-w-lg mx-auto text-left mb-6 shadow-sm">
                    <h3 class="text-xs font-bold text-[#00683e] uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#008751]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Where to find your voting token:</span>
                    </h3>
                    <div class="space-y-3 text-xs text-slate-700">
                        <div class="flex items-start gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-200 text-[#00683e] flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                📱
                            </div>
                            <div>
                                <strong class="text-slate-900 font-semibold">SMS Message:</strong>
                                <span>Sent to your registered mobile phone number
                                    @if(session('member') && session('member')->phone_number)
                                        (<strong>{{ substr(session('member')->phone_number, 0, 4) . '***' . substr(session('member')->phone_number, -4) }}</strong>)
                                    @endif
                                    . Please check your SMS inbox.
                                </span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-200 text-[#00683e] flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                ✉️
                            </div>
                            <div>
                                <strong class="text-slate-900 font-semibold">Email Inbox:</strong>
                                <span>Sent to your registered email address
                                    @if(session('member') && session('member')->email)
                                        (<strong>{{ session('member')->email }}</strong>)
                                    @endif
                                    . Please check your Inbox and Spam/Junk folder.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('member'))
                <div class="bg-white/80 border border-slate-200 rounded-2xl p-4 text-left max-w-lg mx-auto mb-6 text-xs text-slate-600 space-y-1">
                    <p><span class="font-semibold text-slate-700">Accredited Member:</span> {{ session('member')->first_name }} {{ session('member')->last_name }}</p>
                    <p><span class="font-semibold text-slate-700">Staff ID:</span> {{ session('member')->staff_ID }}</p>
                </div>
                @endif

                <div>
                    <a href="{{ route('election.all') }}" class="inline-flex items-center px-8 py-4 bg-[#008751] hover:bg-[#00683e] text-white font-bold rounded-2xl shadow-lg transition transform hover:-translate-y-0.5 text-sm">
                        <span>Proceed to Voting Booth</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <!-- Request Form Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-8 md:p-10">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Request Accreditation Token</h2>
                
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 mb-6">
                    <p class="text-xs text-emerald-900 leading-relaxed">
                        Enter your registered <strong>Staff Email Address</strong> or <strong>Staff ID</strong> (e.g. name@domain.com or 1234). Once submitted, the system will verify your membership and generate your secure single-use voting token.
                    </p>
                </div>

                <form action="{{ route('accreditation.request') }}" method="POST" class="space-y-6" onsubmit="handleFormSubmit(event)">
                    @csrf

                    <div>
                        <label for="staff_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Staff email address or staff ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="staff_id"
                               name="staff_id"
                               required
                               {{ !$isAccreditationActive ? 'disabled' : '' }}
                               class="w-full px-4 py-3.5 border border-slate-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-slate-900 placeholder-slate-400 text-sm font-medium {{ !$isAccreditationActive ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                               placeholder="Enter your Staff email address or staff ID">
                        @error('staff_id')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            {{ !$isAccreditationActive ? 'disabled' : '' }}
                            class="w-full py-4 px-6 {{ $isAccreditationActive ? 'btn-brand' : 'bg-slate-300 cursor-not-allowed' }} text-white font-bold text-sm rounded-xl shadow-md flex items-center justify-center transition">
                        <span class="button-text">
                            {{ $isAccreditationActive ? 'Submit Accreditation Request' : 'Accreditation Currently Unavailable' }}
                        </span>
                        <span class="button-spinner hidden flex items-center">
                            <div class="spinner mr-2"></div>
                            Verifying Member ID...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Help / Contact Support -->
            <div class="mt-8 text-center text-xs text-slate-500 space-y-2">
                <p>
                    Need assistance with accreditation? <a href="mailto:info@niprfct.org.ng" class="text-[#008751] font-semibold hover:underline">Contact Support</a>
                </p>
                <p class="text-[11px] text-slate-400">
                    Helpline: ---
                </p>
            </div>

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
