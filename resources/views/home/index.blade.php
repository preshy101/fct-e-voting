<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> E-Voting System — Official Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/federal_logo.jpeg') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .theme-gradient {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        }
        .hero-mesh {
            background: radial-gradient(circle at 20% 20%, rgba(0, 168, 101, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 80% 80%, rgba(0, 77, 46, 0.12) 0%, transparent 40%),
                        #f8fafc;
        }
        .card-hover {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 135, 81, 0.2);
        }
        .btn-brand {
            background: linear-gradient(135deg, #008751 0%, #005a36 100%);
            transition: all 0.3s ease;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #00a865 0%, #006b40 100%);
            box-shadow: 0 10px 25px -5px rgba(0, 135, 81, 0.4);
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .floating-icon {
            animation: floatSlow 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="hero-mesh min-h-screen flex flex-col text-slate-800">

    <!-- Header Navigation -->
    <header class="bg-white/90 backdrop-blur-md border-b border-emerald-100 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="48" height="48" alt="Logo" class="h-11 w-auto object-contain transition group-hover:scale-105">
                    <div>
                        <div class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-1.5">
                            <span>e</span>
                            <span class="text-[#008751]">-Voting System</span>
                        </div>
                        <div class="text-xs text-slate-500 font-medium">Democratic & Certified Voting System</div>
                    </div>
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('election.live.results') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        Live Results
                    </a>
                    <a href="{{ route('accreditation.index') }}" class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold text-[#008751] hover:text-[#005a36] hover:bg-emerald-50 rounded-lg transition">
                        Accreditation
                    </a>
                    <a href="{{ route('election') }}" class="inline-flex items-center px-5 py-2.5 btn-brand text-white text-sm font-semibold rounded-xl shadow-md transition">
                        View Elections
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-12 lg:py-16">
        
        <!-- Hero Title Banner -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-[#00683e] text-xs font-bold uppercase tracking-wider mb-6 border border-emerald-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#008751] animate-pulse"></span>
                Official E-Voting Platform
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                Your Voice, Your Future. <br class="hidden sm:inline"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#008751] to-emerald-600">Cast Your Ballot Securely.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Participate in verified, transparent, and certified elections. Get accredited in seconds and vote with confidence.
            </p>
        </div>

        <!-- Action Cards Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-16">
            
            <!-- Accreditation Card -->
            <div class="card-hover bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="theme-gradient p-8 text-white text-center relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="floating-icon mb-4 inline-block">
                            <div class="w-18 h-18 mx-auto p-4 bg-white/15 backdrop-blur-md rounded-2xl border border-white/20 shadow-inner">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">Voter Accreditation</h2>
                        <p class="text-emerald-100 text-sm max-w-sm mx-auto">Verify your Practice ID and obtain your unique voting token</p>
                    </div>

                    <div class="p-8">
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">1</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">Enter Practice ID:</strong> Verify your membership eligibility in the verified registry.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">2</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">Receive Secret Token:</strong> An encrypted 6-character token will be issued and emailed.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">3</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">Unlock Ballots:</strong> Use your token to vote in all active elections securely.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 pt-0">
                    <a href="{{ route('accreditation.index') }}" class="w-full inline-flex items-center justify-center py-4 px-6 btn-brand text-white text-base font-bold rounded-2xl shadow-lg transition duration-200">
                        <span>Get Accredited Now</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Cast Your Vote Card -->
            <div class="card-hover bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-[#004d2e] p-8 text-white text-center relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-[#008751]/20 rounded-full blur-xl pointer-events-none"></div>
                        <div class="floating-icon mb-4 inline-block" style="animation-delay: 0.3s;">
                            <div class="w-18 h-18 mx-auto p-4 bg-white/15 backdrop-blur-md rounded-2xl border border-white/20 shadow-inner">
                                <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">Cast Your Vote</h2>
                        <p class="text-emerald-200 text-sm max-w-sm mx-auto">Explore live elections, review candidates, and submit ballots</p>
                    </div>

                    <div class="p-8">
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">1</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">Browse Contests:</strong> Review candidate profiles and their election manifestos.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">2</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">One-Click Multi Voting:</strong> Vote across all active categories in a single ballot.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#008751] flex items-center justify-center font-bold text-xs mr-3 mt-0.5 flex-shrink-0">3</div>
                                <p class="text-slate-600 text-sm leading-relaxed"><strong class="text-slate-800 font-semibold">Verified Receipt:</strong> Receive instant confirmation and cryptographic reference.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 pt-0">
                    <a href="{{ route('election') }}" class="w-full inline-flex items-center justify-center py-4 px-6 bg-slate-900 hover:bg-slate-800 text-white text-base font-bold rounded-2xl shadow-lg transition duration-200">
                        <span>Enter Voting Booth</span>
                        <svg class="w-5 h-5 ml-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Trust Badges -->
        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 border border-emerald-100 shadow-sm max-w-5xl mx-auto">
            <div class="grid sm:grid-cols-3 gap-6 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#008751] flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Encrypted & Confidential</h3>
                    <p class="text-xs text-slate-500">Your ballot choices are completely private and tamper-proof.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#008751] flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">One Member, One Vote</h3>
                    <p class="text-xs text-slate-500">Strict token authentication prevents duplicate or unauthorized voting.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#008751] flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Instant Results Tally</h3>
                    <p class="text-xs text-slate-500">Real-time certified vote counting with downloadable PDF election reports.</p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <img src="{{ asset('images/federal_logo.jpeg') }}" width="32" height="32" alt="Logo" class="h-8 w-auto">
                <span class="font-bold text-slate-800">e-Voting System</span>
            </div>
            <p class="text-sm text-slate-500 mb-2">&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
            <p class="text-xs text-slate-400">For support inquiries, contact your election administrator.</p>
        </div>
    </footer>

</body>
</html>
