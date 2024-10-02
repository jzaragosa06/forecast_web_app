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

        <section class="flex justify-center items-center min-h-screen py-16 px-8">
            <div class="text-left animate-fade-in max-w-xl">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">DataForesight is all you need.</h1>
                <p class="text-gray-500 mb-6 text-left">
                    Unlock powerful insights from your data with our cutting-edge time series analysis platform. Break down
                    your data into trend, seasonality, and forecasts with ease. Engage with an AI assistant for
                    personalized experience and take notes as you go.
                </p>
                <div class="flex justify-left space-x-4">
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
        </section>


        <!-- Features Section -->
        <section class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center animate-fade-in">
                    <i class="fas fa-chart-line text-blue-600 text-4xl mb-4"></i>
                    <h3 class="font-bold text-lg text-gray-800">Real-time Analysis</h3>
                    <p class="text-gray-500">Analyse time series with powerful tool.</p>
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
    </div>
@endsection
