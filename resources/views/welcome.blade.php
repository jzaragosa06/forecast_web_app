@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen">

        <!-- Hero Section -->
        {{-- <section class="flex justify-center items-center min-h-screen py-16 px-8">
        <div class="text-center animate-fade-in">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">TagSalamisim is all you need.</h1>
            <p class="text-gray-500 mb-6 text-left">Improve your
                data-driven decisions like never before!"</p>
            <div class="flex inset-y-0 left-0 space-x-4">
                <a href="#"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:bg-blue-600 hover:scale-105">Get
                    Started</a>
                <a href="#"
                    class="border border-blue-500 text-blue-500 px-6 py-2 rounded-lg transition duration-300 ease-in-out hover:bg-blue-50 hover:scale-105">Documentation</a>
            </div>
        </div>
        <div class="ml-12 animate-fade-in">
            <img src="assets/img/chart.svg" alt="Illustration" class="w-96 h-auto">
        </div>
    </section> --}}

        <section id="home"
            class="flex flex-col md:flex-row justify-between items-center min-h-screen py-16 px-8 md:px-16">
            <div class="text-left md:text-left max-w-2xl md:w-1/2 animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">DataForesight: All You Need</h1>
                <p class="text-gray-500 mb-6 text-left">Unlock powerful insights from your data with our cutting-edge time
                    series analysis platform. Break down your data into trend, seasonality, and forecasts with ease. Engage
                    with our AI assistant for a personalized experience and take notes as you go.</p>
                <div class="flex space-x-4">
                    <a href="#"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out">Get
                        Started</a>
                    <a href="#"
                        class="border border-blue-500 hover:bg-blue-100 hover:text-blue-600 text-blue-500 font-medium px-8 py-3 rounded-lg transition duration-300 ease-in-out">Documentation</a>
                </div>
            </div>
            <div class="md:w-1/2 mt-8 md:mt-0 animate-fade-in">
                <img src="assets/img/chart.svg" alt="DataForesight Illustration" class="w-full max-w-lg h-auto">
            </div>
        </section>


        <!-- Features Section -->
        <section id="about" class="py-16 bg-gradient-to-r from -gray-50 to-gray-100">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center animate-fade-in">
                    <i class="fas fa-chart-line text-blue-600 text-4xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">Real-time Analysis</h3>
                    <p class="text-gray-500">Analyze time series with powerful tools.</p>
                </div>
                <div class="text-center animate-fade-in">
                    <i class="fas fa-bolt text-blue-600 text-4xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">Fast Predictions</h3>
                    <p class="text-gray-500">Get accurate predictions instantly.</p>
                </div>
                <div class="text-center animate-fade-in">
                    <i class="fas fa-shield-alt text-blue-600 text-4xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">User Friendly</h3>
                    <p class="text-gray-500">Understand the results better</p>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">About Us</h2>
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
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center animate-fade-in">
                        <i class="fas fa-chart-line text-blue-600 text-4xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Time Series Analysis</h3>
                        <p class="text-gray-500">Our platform uses advanced machine learning algorithms to break down data
                            into trend, seasonality, and forecasts.</p>
                    </div>
                    <div class="text-center animate-fade-in">
                        <i class="fas fa-bolt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Predictive Modeling</h3>
                        <p class="text-gray-500">Our platform provides predictive modeling capabilities to help businesses
                            forecast future trends and make data-driven decisions.</p>
                    </div>
                    <div class="text-center animate-fade-in">
                        <i class="fas fa-shield-alt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-800">Data Visualization</h3>
                        <p class="text-gray-500">Our platform provides interactive data visualization tools to help
                            businesses gain insights and make data-driven decisions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb- 4">Get in Touch</h2>
                <p class="text-gray-500 mb-6">Have a question or want to learn more about our platform? We'd love to hear
                    from you.</p>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="text-gray-800">Name:</label>
                            <input type="text" id="name" class="w-full p-2 border border-gray-400 rounded-lg">
                        </div>
                        <div>
                            <label for="email" class="text-gray-800">Email:</label>
                            <input type="email" id="email" class="w-full p-2 border border-gray-400 rounded-lg">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="message" class="text-gray-800">Message:</label>
                        <textarea id="message" class="w-full p-2 border border-gray-400 rounded-lg"></textarea>
                    </div>
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out mt-4">Send
                        Message</button>
                </form>
            </div>
        </section>


    </div>
@endsection
