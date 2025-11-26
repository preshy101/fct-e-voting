<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('./build/assets/fctLogo.png') }}">
    <title>E-Vote Portal | Welcome</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Apply Inter font */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for modal transition (optional but nice) */
        .modal {
            transition: opacity 0.25s ease;
        }
        .modal-content {
            transition: transform 0.25s ease;
        }
        /* Carousel Styles */
        .carousel-container {
            position: relative;
            overflow: hidden;
        }
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-slide {
            min-width: 100%;
            transition: opacity 0.5s ease-in-out;
        }
        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #cbd5e1;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .carousel-dot.active {
            background-color: #2563eb;
            transform: scale(1.2);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header Navigation -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 text-2xl font-bold text-blue-600">
                    <img src="{{ asset('./build/assets/fctLogo.png') }}" width="50" height="50" alt="FCT Logo" srcset="">
                    <span>FCT e-Voting</span>
                </a>

            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-6 md:py-10">

        <!-- Hero Section with Carousel -->
        <section class="mb-16">
            <div class="carousel-container max-w-5xl mx-auto rounded-2xl overflow-hidden shadow-2xl">
                <div class="carousel-track">
                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white p-12 md:p-20">
                            <div class="max-w-2xl">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 mt-5">Your Voice, Your Vote</h2>
                                <p class="text-xl md:text-2xl mb-6">Participate in secure and transparent democratic elections</p>
                                <div class="flex items-center space-x-4">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-lg">100% Secure & Confidential</span>
                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 opacity-10">
                                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-12 md:p-20">
                            <div class="max-w-2xl">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 mt-5">Easy & Convenient</h2>
                                <p class="text-xl md:text-2xl mb-6">Vote from anywhere, anytime with just a few clicks</p>
                                <div class="flex items-center space-x-4">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-lg">Fast & Efficient Process</span>
                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 opacity-10">
                                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-slide">
                        <div class="relative bg-gradient-to-r from-green-600 to-teal-700 text-white p-12 md:p-20">
                            <div class="max-w-2xl">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 mt-5">Make a Difference</h2>
                                <p class="text-xl md:text-2xl mb-6">Every vote counts in shaping our collective future</p>
                                <div class="flex items-center space-x-4">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-lg">Trusted & Reliable</span>
                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 opacity-10">
                                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-3 shadow-lg transition-all">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-3 shadow-lg transition-all">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Dots Indicators -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3">
                    <button class="carousel-dot active" data-slide="0"></button>
                    <button class="carousel-dot" data-slide="1"></button>
                    <button class="carousel-dot" data-slide="2"></button>
                </div>
            </div>
        </section>

        <!-- Welcome Text -->
        <section class="text-center mb-12">
            <h1 style="color: red">Accreditation Token can only be used once to securely cast your vote</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Welcome to the secure online voting portal. Please select an election category below to cast your vote.
            </p>

            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">
                Vote in All Election
            </h2>
            <div class="mt-6">
                <a href="{{ route('election.all') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-lg rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Vote in All Elections
                </a>
            </div>
        </section>

        <!-- Election Categories Section -->
        <section class="mt-12 md:mt-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">
                Vote only in a single Election
            </h2>

            <!-- Responsive Grid for Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

                @foreach($elections as $election)
                <!-- Category Card 1 -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $election->title }}</h3>
                        <p class="text-gray-600 mb-6">
                            {{ Str::limit($election->description, 50) }}
                        </p>
                        {{-- <button data-election="{{ $election->name }}" class="vote-button w-full px-4 py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-900 transition-colors">
                            Vote Now
                        </button> --}}
                        <a href="{{ route('election.view', ['slug' => $election->id]) }}" class=" w-full px-4 py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-900 transition-colors">
                            View Election
                        </a>
                    </div>
                </div>
                @endforeach
                {{-- @php
                dd($elections)
                @endphp --}}
                @if($elections == [])
                    <p class="text-gray-600">No active elections available at the moment.</p>
                @endif
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 md:mt-20">
        <div class="container mx-auto px-6 py-6 text-center text-gray-500">
            <p>&copy; 2025 E-Vote Portal. All rights reserved.</p>
        </div>
    </footer>

    <!--
      Modal Section
      Initially hidden.
    -->
    <div id="auth-modal" class="modal fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
        <div class="modal-content bg-white w-full max-w-md p-6 rounded-lg shadow-xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 id="modal-title" class="text-xl font-semibold text-gray-900">Voter Verification</h3>
                <button id="modal-close" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="practice-id-form" action="route('vote.page')">
                @csrf
                <p class="text-gray-600 mb-4">
                    To proceed with the <strong id="modal-election-name" class="font-medium text-gray-800"></strong>, please enter your Practice ID.
                </p>
                <div>
                    <label for="practice_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Practice ID
                    </label>
                    <input type="text" id="practice_id" name="practice_id" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter your Practice ID">
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // ===== Carousel Functionality =====
        const carouselTrack = document.querySelector('.carousel-track');
        const carouselSlides = document.querySelectorAll('.carousel-slide');
        const carouselDots = document.querySelectorAll('.carousel-dot');
        const prevButton = document.getElementById('carousel-prev');
        const nextButton = document.getElementById('carousel-next');

        let currentSlide = 0;
        const totalSlides = carouselSlides.length;

        // Function to update carousel position
        const updateCarousel = () => {
            carouselTrack.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Update dots
            carouselDots.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        };

        // Next slide
        const nextSlide = () => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        };

        // Previous slide
        const prevSlide = () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
        };

        // Go to specific slide
        const goToSlide = (slideIndex) => {
            currentSlide = slideIndex;
            updateCarousel();
        };

        // Event listeners for navigation
        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);

        // Event listeners for dots
        carouselDots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        // Auto-advance carousel every 5 seconds
        let autoSlideInterval = setInterval(nextSlide, 5000);

        // Pause auto-advance when hovering over carousel
        const carouselContainer = document.querySelector('.carousel-container');
        carouselContainer.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });

        carouselContainer.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(nextSlide, 5000);
        });

        // ===== Modal Functionality =====
        // Get all modal elements
        const modal = document.getElementById('auth-modal');
        const modalCloseButton = document.getElementById('modal-close');
        const modalCancelButton = document.getElementById('modal-cancel');
        const modalElectionName = document.getElementById('modal-election-name');
        const practiceIdForm = document.getElementById('practice-id-form');
        const practiceIdInput = document.getElementById('practice_id');

        // Get all "Vote Now" buttons
        const voteButtons = document.querySelectorAll('.vote-button');

        // Function to open the modal
        const openModal = (electionName) => {
            modalElectionName.textContent = electionName; // Set election name in modal
            modal.classList.remove('hidden');
        };

        // Function to close the modal
        const closeModal = () => {
            modal.classList.add('hidden');
            practiceIdForm.reset(); // Clear the form
        };

        // Add click event listeners to all "Vote Now" buttons
        voteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const electionName = button.getAttribute('data-election');
                openModal(electionName);
            });
        });

        // Add click event listeners for closing the modal
        modalCloseButton.addEventListener('click', closeModal);
        modalCancelButton.addEventListener('click', closeModal);

        // Close modal when clicking on the background overlay
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        // Handle the form submission
        practiceIdForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent actual form submission
            const practiceId = practiceIdInput.value;

            // In a real app, you would send this ID to your server for verification.
            console.log(`Practice ID Submitted: ${practiceId}`);
            console.log(`For Election: ${modalElectionName.textContent}`);

            // For this demo, we'll just show a message and close the modal.
            // Using a simple message box instead of alert()
            const submitButton = practiceIdForm.querySelector('button[type="submit"]');
            submitButton.textContent = 'Verifying...';
            submitButton.disabled = true;

            // Simulate a network request
            setTimeout(() => {
                console.log('Verification complete.');
                closeModal();
                submitButton.textContent = 'Submit';
                submitButton.disabled = false;
                // You could redirect to the voting page here
                // window.location.href = `/vote/${modalElectionName.textContent}?id=${practiceId}`;
            }, 1000);
        });
    </script>

</body>
</html>
