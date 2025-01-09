@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen">

        <!-- Hero Section -->


        <section id="home" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center min-h-screen py-16 px-8 md:px-16">
            <div class="text-left max-w-2xl animate-fade-in">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-4">DataForesight: Know Your Data</h1>
                <p class="text-gray-500 mb-6 text-sm sm:text-base md:text-lg">Unlock powerful insights from your data with
                    our
                    cutting-edge time series analysis platform. Break down your data into trend, seasonality, and forecasts
                    with
                    ease. Engage with our AI assistant for a personalized experience and take notes as you go.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href='{{ route('register') }}'
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out">Get
                        Started</a>
                    <a href="{{ route('documentation') }}"
                        class="border border-blue-500 hover:bg-blue-100 hover:text-blue-600 text-blue-500 font-medium px-8 py-3 rounded-lg transition duration-300 ease-in-out">Documentation</a>
                    <a href="{{ route('faq') }}"
                        class="border border-blue-500 hover:bg-blue-100 hover:text-blue-600 text-blue-500 font-medium px-8 py-3 rounded-lg transition duration-300 ease-in-out">FAQ</a>
                </div>
            </div>
            <div class="mt-8 md:mt-0 animate-fade-in">
                <img src="assets/img/chart.svg" alt="DataForesight Illustration" class="w-full max-w-lg h-auto">
            </div>
        </section>


        <section id="testimonials" class="py-16 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">What Our Clients Say</h2>
                    <p class="mt-4 text-lg text-gray-600">Discover how our platform empowers businesses to thrive and
                        achieve new heights through data-driven insights. Here's what our clients have to share:</p>
                </div>

                <div class="mt-12 relative">
                    <!-- Carousel Container -->
                    <div class="overflow-hidden relative" id="carousel">
                        <div class="flex transition-transform duration-700 ease-in-out" id="carouselInner">
                            @if (!$reviews->isEmpty())
                                @foreach ($reviews as $review)
                                    <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                                        <div class="bg-white p-6 shadow-lg rounded-lg h-56"> <!-- Fixed height added -->
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ $review->user->profile_photo ? asset('storage/' . $review->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                                    alt="{{ $review->user->name }}'s photo" class="w-12 h-12 rounded-full">
                                                <div>
                                                    <p class="text-lg font-semibold text-gray-900">{{ $review->user->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">{{ $review->position }},
                                                        {{ $review->affiliation }}</p>
                                                </div>
                                            </div>
                                            <p class="mt-4 text-gray-600">"{{ $review->review }}"</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-gray-500">No one has added a review yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Controls -->
                    <button id="prevButton"
                        class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-400 text-white p-2 rounded-full shadow hover:bg-gray-600">
                        &lt;
                    </button>
                    <button id="nextButton"
                        class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-400 text-white p-2 rounded-full shadow hover:bg-gray-600">
                        &gt;
                    </button>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('carousel');
                const carouselInner = document.getElementById('carouselInner');
                const prevButton = document.getElementById('prevButton');
                const nextButton = document.getElementById('nextButton');

                let currentIndex = 0;
                const itemsToShow = 3;
                const totalItems = {{ $reviews->count() }}; // Use the count of reviews dynamically

                const updateCarousel = () => {
                    const offset = -(currentIndex * (carousel.offsetWidth / itemsToShow));
                    carouselInner.style.transform = `translateX(${offset}px)`;
                };

                prevButton.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateCarousel();
                    }
                });

                nextButton.addEventListener('click', () => {
                    if (currentIndex < totalItems - itemsToShow) {
                        currentIndex++;
                        updateCarousel();
                    }
                });

                window.addEventListener('resize', updateCarousel);
            });
        </script>


        <!-- Features Section -->
        <section class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 divide-x gap-8">
                <div class="text-center items-center animate-fade-in grid grid-cols-1 gap-4">
                    <i class="fa-solid fa-calendar-days text-blue-600 text-8xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">Real-time Analysis</h3>
                    <p class="text-gray-600">Analyze time series with powerful tools.</p>
                </div>
                <div class="text-center animate-fade-in grid grid-cols-1 gap-4">
                    <i class="fa-solid fa-magnifying-glass-chart text-blue-600 text-8xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">Fast Predictions</h3>
                    <p class="text-gray-600">Get accurate predictions instantly.</p>
                </div>
                <div class="text-center animate-fade-in grid grid-cols-1 gap-4">
                    <i class="fa-regular fa-face-smile-wink text-blue-600 text-8xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">User Friendly</h3>
                    <p class="text-gray-600">Understand the results better</p>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <hr class="w-48 h-1 mx-auto my-6 bg-gray-300 opacity-50 border-none rounded">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 gap-4">
                <h2 class="text-3xl font-bold text-gray-800 my-8">About Us</h2>
                <p class="text-gray-500 mb-6">DataForesight is a cutting-edge time series analysis platform designed to help
                    businesses unlock powerful insights from their data. Our platform uses advanced machine learning
                    algorithms to break down data into trend, seasonality, and forecasts, providing users with a
                    comprehensive understanding of their data.</p>
                <p class="text-gray-500 mb-6">Our mission is to empower businesses to make data-driven decisions with
                    confidence. We believe that data should be accessible and actionable, and we're committed to providing
                    the tools and expertise to make that a reality.</p>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <hr class="w-48 h-1 mx-auto my-6 bg-gray-300 opacity-50 border-none rounded">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 gap-4">
                <h2 class="text-3xl font-bold text-gray-800 my-10">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center animate-fade-in grid grid-cols-1 gap-4">
                        <i class="fas fa-chart-line text-blue-600 text-8xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Time Series Analysis</h3>
                        <p class="text-gray-500">Our platform uses advanced machine learning algorithms to break down data
                            into trend, seasonality, and forecasts.</p>
                    </div>
                    <div class="text-center animate-fade-in grid grid-cols-1 gap-4">
                        <i class="fas fa-bolt text-blue-600 text-8xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Predictive Modeling</h3>
                        <p class="text-gray-500">Our platform provides predictive modeling capabilities to help businesses
                            forecast future trends and make data-driven decisions.</p>
                    </div>
                    <div class="text-center animate-fade-in grid grid-cols-1 gap-4">
                        <i class="fas fa-shield-alt text-blue-600 text-8xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Data Visualization</h3>
                        <p class="text-gray-500">Our platform provides interactive data visualization tools to help
                            businesses gain insights and make data-driven decisions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <hr class="w-48 h-1 mx-auto my-6 bg-gray-300 opacity-50 border-none rounded">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 gap-4">
                <h2 class="text-3xl font-bold text-gray-800 mb- 4">Get in Touch</h2>
                <p class="text-gray-500 mb-6">Have a question or want to learn more about our platform? We'd love to hear
                    from you.</p>
                <form action="{{ route('queries.submit') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="text-gray-800">Name:</label>
                            <input type="text" name="name" id="name"
                                class="w-full p-2 border border-gray-400 rounded-lg" required>
                        </div>
                        <div>
                            <label for="email" class="text-gray-800">Email:</label>
                            <input type="email" name="email" id="email"
                                class="w-full p-2 border border-gray-400 rounded-lg" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="message" class="text-gray-800">Message:</label>
                        <textarea id="message" name="message" class="w-full h-auto p-2 border border-gray-400 rounded-lg" required></textarea>
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out mt-4">Send
                        Message</button>
                </form>
            </div>
        </section>
    </div>
@endsection
