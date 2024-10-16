@extends('layouts.admin_base')

@section('title', 'Admin-Data Source')

@section('page-title', 'Data-Source')

@section('content')

    <div class="flex space-x-6 items-center justify-center">
        <!-- Card 1 -->
        <div class="bg-white w-64 p-6 rounded-lg shadow-lg">
            <div class="flex justify-center">
                <img src="https://via.placeholder.com/100" alt="Logo" class="rounded-full mb-4">
            </div>
            <h2 class="text-center text-xl font-bold mb-2">OPEN-METEO</h2>
            <p class="text-center text-sm text-gray-500 mb-6">For meteorological data</p>
            <p class="text-gray-700 text-sm mb-6">
                Ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                lorem ipsum lorem ipsum lorem ipsum
            </p>
            <div class="flex justify-center">
                <a href="{{ route('admin.open_meteo') }}"><button
                        class="bg-blue-500 text-white py-2 px-4 rounded">Edit</button></a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white w-64 p-6 rounded-lg shadow-lg">
            <div class="flex justify-center">
                <img src="https://via.placeholder.com/100" alt="Logo" class="rounded-full mb-4">
            </div>
            <h2 class="text-center text-xl font-bold mb-2">Yahoo-Fin</h2>
            <p class="text-center text-sm text-gray-500 mb-6">For finance data</p>
            <p class="text-gray-700 text-sm mb-6">
                Ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                lorem ipsum lorem ipsum lorem ipsum
            </p>

            <div class="flex justify-center">
                <a href="{{ route('admin.stocks') }}">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded">Edit</button>
                </a>

            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white w-64 p-6 rounded-lg shadow-lg">
            <div class="flex justify-center">
                <img src="https://via.placeholder.com/100" alt="Logo" class="rounded-full mb-4">
            </div>
            <h2 class="text-center text-xl font-bold mb-2">Agricultural</h2>
            <p class="text-center text-sm text-gray-500 mb-6">For agri data</p>
            <p class="text-gray-700 text-sm mb-6">
                Ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                lorem ipsum lorem ipsum lorem ipsum
            </p>
            <div class="flex justify-center">
                <button class="bg-blue-500 text-white py-2 px-4 rounded">Edit</button>
            </div>
        </div>
    </div>

@endsection
