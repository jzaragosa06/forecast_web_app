@extends('layouts.admin_base')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Number of Users Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Total Users</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $numberOfUsers }}</p>
        </div>

        <!-- Number of Files Analyzed Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Files Analyzed</h2>
            <p class="text-3xl font-semibold text-green-600">{{ $numberOfFilesAnalyzed }}</p>
        </div>
    </div>

    <!-- ApexCharts for different metrics -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h2 class="text-xl font-bold mb-4">Analytics Overview </h2>

        <!-- Chart for Files Analyzed -->
        <div id="filesAnalyzedChart"></div>

        <!-- Chart for Posts Made -->
        <div id="postsMadeChart"></div>

        <!-- Chart for Comments Made -->
        <div id="commentsMadeChart"></div>

        <!-- Chart for New Accounts -->
        <div id="newAccountsChart"></div>

        <!-- Chart for Files Created -->
        <div id="filesCreatedChart"></div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to create a chart
            function createChart(elementId, title, data) {
                let values = Object.values(data);
                let dates = Object.keys(data);

                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [{
                        name: title,
                        data: values,
                    }],
                    xaxis: {
                        categories: dates,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    yaxis: {
                        title: {
                            text: 'Count'
                        }
                    },
                    title: {
                        text: title
                    }
                };

                var chart = new ApexCharts(document.querySelector(`#${elementId}`), options);
                chart.render();
            }

            const filesCreated = @json($filesCreated);

            console.log(@json($filesCreated));
            console.log(Object.values(filesCreated));
            console.log(Object.keys(filesCreated));







            // Creating charts for each metric
            createChart('filesAnalyzedChart', 'Files Analyzed', @json($filesAnalyzed));
            createChart('postsMadeChart', 'Posts Made', @json($postsMade));
            createChart('commentsMadeChart', 'Comments Made', @json($commentsMade));
            createChart('newAccountsChart', 'New Accounts', @json($newAccounts));
            createChart('filesCreatedChart', 'Files Created', @json($filesCreated));
        });
    </script>
@endsection
