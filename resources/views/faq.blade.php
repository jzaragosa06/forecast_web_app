@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8 bg-white">

        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-gray-800 mb-10 text-center">Frequently Asked Questions (FAQ)</h1>

        <div class="space-y-4">
            <!-- Question 1 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What features does the system offer?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Trend Analysis: Identifies long-term patterns in data.</li>
                        <li>Seasonality Analysis: Detects recurring patterns at specific intervals.</li>
                        <li>Forecasting: Predicts future data points based on historical trends.</li>
                    </ul>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What are the system's limitations?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">The system requires structured data in specific formats and does not handle
                        missing or inconsistent data effectively. It is also not optimized for real-time streaming analysis.
                    </p>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What data formats are acceptable?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">The system accepts CSV and Excel files formatted for univariate or multivariate
                        time series analysis.</p>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>How does the system perform trend analysis?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">Trend analysis is performed using the Prophet package, which models each time
                        series to identify long-term patterns.</p>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What are the requirements for univariate data?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">Univariate data must include a date index and a single column of numeric
                        values.</p>
                </div>
            </div>

            <!-- Question 6 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>Can the system handle multivariate data?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">Yes, the system can analyze multivariate data with a date index and multiple
                        numeric columns.</p>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What does the seasonality analysis provide?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">Seasonality analysis identifies recurring patterns in the data on a weekly or
                        yearly basis.</p>
                </div>
            </div>

            <!-- Question 8 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What models are used for forecasting?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">The system uses hybrid stacking regression for univariate data and decision
                        tree models for multivariate data.</p>
                </div>
            </div>

            <!-- Question 9 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>What is the system's error rate?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">The system demonstrates a low error rate of approximately 3% for univariate
                        forecasts.</p>
                </div>
            </div>

            <!-- Question 10 -->
            <div class="border rounded-lg overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium focus:outline-none"
                    data-faq-toggle>
                    <span>Does the system support real-time analysis?</span>
                    <span class="text-gray-500">+</span>
                </button>
                <div class="px-4 py-3 hidden" data-faq-content>
                    <p class="text-gray-600">No, the system is designed for batch analysis of historical data rather than
                        real-time streaming.</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('[data-faq-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                content.classList.toggle('hidden');
                const icon = button.querySelector('span:last-child');
                icon.textContent = content.classList.contains('hidden') ? '+' : '-';
            });
        });
    </script>
@endsection
