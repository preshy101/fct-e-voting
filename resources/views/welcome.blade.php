<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/federal_logo.jpeg') }}">
    <title>Active Elections — e-Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .theme-gradient {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        }
        .carousel-container {
            position: relative;
            overflow: hidden;
        }
        .carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .carousel-slide {
            min-width: 100%;
            transition: opacity 0.5s ease-in-out;
        }
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 9999px;
            background-color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .carousel-dot.active {
            background-color: #ffffff;
            width: 28px;
        }
        @keyframes emeraldGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(0, 135, 81, 0.4), 0 0 40px rgba(0, 135, 81, 0.2);
            }
            50% {
                box-shadow: 0 0 30px rgba(0, 135, 81, 0.7), 0 0 60px rgba(0, 135, 81, 0.4);
            }
        }
        .btn-glow-emerald {
            animation: emeraldGlow 2.5s ease-in-out infinite;
        }
        .btn-glow-emerald:hover {
            animation: none;
            box-shadow: 0 12px 30px rgba(0, 135, 81, 0.5);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 135, 81, 0.1), 0 8px 10px -6px rgba(0, 135, 81, 0.1);
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
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-emerald-100 sticky top-0 z-40 shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/federal_logo.jpeg') }}" width="44" height="44" alt="Logo" class="h-10 w-auto object-contain">
                    <div>
                        <div class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-1">
                            <span>e</span><span class="text-[#008751]">-Voting System</span>
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium hidden sm:block">Democratic & Certified Voting System</div>
                    </div>
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('election.live.results') }}" class="px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 pulse-live"></span>
                        Live Results
                    </a>
                    <a href="{{ route('accreditation.index') }}" class="px-4 py-2 text-sm font-semibold text-[#008751] hover:bg-emerald-50 rounded-xl transition">
                        Get Accredited
                    </a>
                    <!-- <a href="{{ route('election.all') }}" class="inline-flex items-center px-4 py-2 bg-[#008751] hover:bg-[#00683e] text-white text-sm font-bold rounded-xl shadow transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Vote All
                    </a> -->
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-8 md:py-12 max-w-6xl">

        <!-- Hero Carousel Section -->
        <section class="mb-12">
            <div class="carousel-container rounded-3xl overflow-hidden shadow-2xl border border-emerald-800/20">
                <div class="carousel-track">
                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <div class="relative theme-gradient text-white p-10 md:p-16">
                            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="max-w-2xl relative z-10">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-sm text-xs font-semibold uppercase tracking-wider mb-4 border border-emerald-400/30 text-emerald-300">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Certified & Secure
                                </div>
                                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-3">Vote with Integrity</h1>
                                <p class="text-lg md:text-xl text-emerald-100 mb-6">Each ballot is encrypted, authenticated, and accounted for with total transparency.</p>
                                <div class="flex items-center space-x-6 text-sm text-emerald-200 font-medium">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-1.5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Verified Accuracy</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-1.5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>End-to-End Cryptography</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-[#004d2e] text-white p-10 md:p-16">
                            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-[#008751]/20 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="max-w-2xl relative z-10">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 backdrop-blur-sm text-xs font-semibold uppercase tracking-wider mb-4 border border-emerald-400/30 text-emerald-300">
                                    Fast & Mobile Ready
                                </div>
                                <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-3">Vote from Anywhere</h2>
                                <p class="text-lg md:text-xl text-slate-300 mb-6">Vote securely on your phone, tablet, or desktop in just a few simple clicks.</p>
                                <div class="flex items-center space-x-6 text-sm text-emerald-200 font-medium">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-1.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Instant Verification</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full p-2.5 backdrop-blur-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full p-2.5 backdrop-blur-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Dots Indicators -->
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-2">
                    <button class="carousel-dot active" data-slide="0"></button>
                    <button class="carousel-dot" data-slide="1"></button>
                </div>
            </div>
        <!-- Main Call To Action / Multi-Vote Ballot -->
        <section class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-md mb-12 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-semibold border border-amber-200 mb-4">
                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>Accreditation Required for Voting</span>
            </div>
            
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">Vote in All Active Elections in One Step</h2>
            <p class="text-slate-600 text-sm max-w-xl mx-auto mb-6 leading-relaxed">
                Save time by completing your votes across all active categories in a single secure ballot session.
            </p>

            <a href="{{ route('election.all') }}" class="inline-flex items-center px-8 py-4 bg-[#008751] hover:bg-[#00683e] text-white font-bold rounded-2xl shadow-lg transition btn-glow-emerald transform hover:-translate-y-0.5">
                <span>Open Multi-Election Ballot</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </section>

        <!-- Individual Active Elections Section -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Active Elections</h2>
                    <p class="text-xs text-slate-500">Explore specific election categories and contestants</p>
                </div>
                <div class="flex items-center space-x-3">
                    
                    <span class="text-xs font-bold text-[#008751] bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">
                        {{ count($elections ?? []) }} Available
                    </span>
                </div>
            </div>

            @if(isset($elections) && count($elections) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($elections as $election)
                    <div class="card-hover bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#008751] bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                                    {{ $election->category->title ?? 'General' }}
                                </span>
                                <span class="inline-flex items-center text-xs font-semibold text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-[#008751] mr-1.5"></span>
                                    Active
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $election->title }}</h3>
                            <p class="text-xs text-slate-500 mb-4 line-clamp-2">
                                {{ $election->description ?? 'Democratic election contest for members.' }}
                            </p>

                            <div class="space-y-1.5 text-xs text-slate-600 border-t border-slate-100 pt-3">
                                <div class="flex items-center justify-between">
                                    <span>Closes:</span>
                                    <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($election->end_date)->format('M d, h:i A') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Contestants:</span>
                                    <span class="font-semibold text-slate-800">{{ $election->candidates->count() }} Candidates</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0 space-y-2">
                            <a href="{{ route('election.view', ['slug' => $election->id]) }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 bg-slate-900 hover:bg-[#008751] text-white text-xs font-bold rounded-xl transition duration-200 shadow-sm">
                                <span>Vote in this Election</span>
                                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('election.result', $election->id) }}" class="w-full inline-flex items-center justify-center py-2 px-4 bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-[#008751] text-xs font-semibold rounded-xl border border-slate-200 transition">
                                <span>View Results & Tally</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">No Active Elections Right Now</h3>
                    <p class="text-sm text-slate-500">Upcoming elections will be published here once voting opens.</p>
                </div>
            @endif
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <img src="{{ asset('images/federal_logo.jpeg') }}" width="32" height="32" alt="Logo" class="h-8 w-auto">
                <span class="font-bold text-slate-800">e-Voting System</span>
            </div>
            <p class="text-sm text-slate-500 mb-2">&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
            <p class="text-xs text-slate-400">For support inquiries, contact your election administrator.</p>
        </div>
    </footer>

    <!-- Carousel Logic -->
    <script>
        const track = document.querySelector('.carousel-track');
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        let currentIndex = 0;
        let autoSlideInterval;

        function updateCarousel(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            currentIndex = index;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === currentIndex);
            });
        }

        prevBtn.addEventListener('click', () => {
            updateCarousel(currentIndex - 1);
            resetAutoSlide();
        });

        nextBtn.addEventListener('click', () => {
            updateCarousel(currentIndex + 1);
            resetAutoSlide();
        });

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                updateCarousel(i);
                resetAutoSlide();
            });
        });

        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                updateCarousel(currentIndex + 1);
            }, 6000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        startAutoSlide();
    </script>
</body>
</html>
