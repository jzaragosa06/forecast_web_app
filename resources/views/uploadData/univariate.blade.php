@extends('layouts.base')

@section('title', 'Upload Inputs')
@section('page-title', 'Data Preprocessing')
@section('content')
    <div class="container mx-auto p-6">
        <!-- Chart Card -->
        <div class="flex justify-center mb-6">
            <div class="bg-white shadow-md rounded-lg p-4 w-full">
                <div id="chart-container">
                    <div id="chart"></div>
                </div>
            </div>
        </div>

        <!-- Data Info and Processing Options Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


            <!-- Data Info Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">
                        Time Series Type
                    </label>
                    <input type="text" id="type" name="type" value="{{ $type }}" readonly
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="freq" class="block text-sm font-medium text-gray-700">

                        Frequency
                    </label>
                    <input type="text" id="freq" name="freq" readonly
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">

                        Description
                    </label>
                    <textarea id="description" name="description" rows="5"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="filename" class="block text-sm font-medium text-gray-700">

                        Filename
                    </label>
                    <input type="text" id="filename" name="filename" value="{{ $filename }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>


            <!-- Processing Options Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <form id="processing-form">
                    <fieldset>
                        <legend class="text-sm font-medium text-gray-700 mb-4">Fill Missing Value (NaN) with:</legend>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="fill-method" value="forward"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2">Forward Fill</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="fill-method" value="backward"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2">Backward Fill</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="fill-method" value="average"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2">Average of the series</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="fill-method" value="zero"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2">Fill with zeros</span>
                            </label>
                        </div>
                    </fieldset>

                    <!-- Save Button -->
                    <div class="mt-6">
                        <button type="button" id="submit-button" name="submit-button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            const data = @json($data);
            const headers = @json($headers);

            let originalData = JSON.parse(JSON.stringify(data)); // Deep copy of original data
            let tempData = JSON.parse(JSON.stringify(originalData));
            let chartInstance = null; // Variable to store the current chart instance

            freq = inferFrequency(tempData.map(row => convertDate(row[0])));
            $('#freq').val(freq);


            function convertDate(inputDate) {
                const parsedDate = new Date(inputDate);
                return dateFns.format(parsedDate, 'MM/dd/yyyy');
            }

            // Ensure that data is valid
            if (data && data.length > 0 && headers.length > 1) {
                const originalValues = originalData.map(row => parseFloat(row[1]) || null);
                const dates = originalData.map(row => convertDate(row[0]));

                const label = headers[1];

                // Initial chart with both original and filled data (initially filled is same as original)
                showChart(label, dates, originalValues, originalValues);
            } else {
                console.error('Invalid data or headers');
            }

            function showChart(label, dates, originalValues, filledValues) {
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Create formatted data for original and filled series
                const originalSeriesData = dates.map((date, index) => ({
                    x: date,
                    y: originalValues[index]
                }));
                const filledSeriesData = dates.map((date, index) => ({
                    x: date,
                    y: filledValues[index]
                }));

                const options = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: label + ' (Original)',
                            data: originalSeriesData,
                            color: '#1E90FF' // Blue for original data
                        },
                        {
                            name: label + ' (Filled)',
                            data: filledSeriesData,
                            color: '#FF6347' // Red for filled data
                        }
                    ],
                    xaxis: {
                        type: 'datetime',
                        title: {
                            text: 'Date'
                        }
                    },
                    yaxis: {
                        title: {
                            text: label
                        },
                        labels: {
                            formatter: function(value) {
                                return isNaN(value) ? value : value.toFixed(2);
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return isNaN(value) ? value : value.toFixed(2);
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                };

                chartInstance = new ApexCharts(document.querySelector("#chart-container"), options);
                chartInstance.render();
            }

            function fillMissingValues(method) {
                tempData = JSON.parse(JSON.stringify(originalData)); // Reset tempData

                switch (method) {
                    case 'forward':
                        for (let i = 1; i < tempData.length; i++) {
                            if (tempData[i][1] === null || tempData[i][1] === '') {
                                tempData[i][1] = tempData[i - 1][1];
                            }
                        }
                        break;
                    case 'backward':
                        for (let i = tempData.length - 2; i >= 0; i--) {
                            if (tempData[i][1] === null || tempData[i][1] === '') {
                                tempData[i][1] = tempData[i + 1][1];
                            }
                        }
                        break;
                    case 'average':
                        let sum = 0;
                        let count = 0;
                        for (let i = 0; i < tempData.length; i++) {
                            if (tempData[i][1] !== null && tempData[i][1] !== '') {
                                sum += parseFloat(tempData[i][1]);
                                count++;
                            }
                        }
                        const average = sum / count;
                        for (let i = 0; i < tempData.length; i++) {
                            if (tempData[i][1] === null || tempData[i][1] === '') {
                                tempData[i][1] = average;
                            }
                        }
                        break;
                    case 'zero':
                        for (let i = 0; i < tempData.length; i++) {
                            if (tempData[i][1] === null || tempData[i][1] === '') {
                                tempData[i][1] = 0;
                            }
                        }
                        break;
                }

                const filledValues = tempData.map(row => parseFloat(row[1]));
                const dates = tempData.map(row => row[0]);
                const originalValues = originalData.map(row => parseFloat(row[1]) || null);
                showChart(headers[1], dates, originalValues, filledValues);
            }

            document.querySelectorAll('input[name="fill-method"]').forEach(input => {
                input.addEventListener('change', () => {
                    const method = document.querySelector('input[name="fill-method"]:checked')
                        .value;
                    fillMissingValues(method);
                });
            });

            function generateCSV(data) {
                // let csvContent = `Date,${headers}\n`; // Header
                let csvContent = `Date,${headers[1]}\n`; // Header

                data.forEach(row => {
                    csvContent += `${convertDate(row[0])},${row[1]}\n`; // Correct interpolation
                });
                return csvContent;
            }

            document.getElementById('submit-button').addEventListener('click', () => {
                alert(tempData);
                const csvData = generateCSV(tempData);


                console.log('content of the csv data: look for the format', csvData);

                //extract the additional data from the controller. 
                const type = @json($type);

                const description = $('#description').val();
                const filename = $('#filename').val();
                const source = @json($source);


                // Create a FormData object to send the CSV and other data
                const blob = new Blob([csvData], {
                    type: 'text/csv'
                });
                const formData = new FormData();
                formData.append('csv_file', blob, 'data.csv');

                formData.append('type', type);
                formData.append('freq', freq);
                formData.append('description', description);
                formData.append('filename', filename);
                formData.append('source', source);


                // Inspect FormData
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }


                // Send the data using AJAX
                $.ajax({
                    url: '{{ route('save') }}', // URL to your Laravel route
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token here
                    },
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Let the browser set the content type
                    success: function(response) {
                        console.log('Data saved successfully:');

                        // Redirect the user manually
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving data:', error);
                    }
                });
            });

        });



        function inferFrequency(dates) {
            // Sort dates in ascending order if they are not already sorted
            dates.sort((a, b) => new Date(a) - new Date(b));

            // Calculate the difference in days between consecutive dates
            let diffs = [];
            for (let i = 1; i < dates.length; i++) {
                const diff = Math.abs(new Date(dates[i]) - new Date(dates[i - 1])) / (1000 * 60 * 60 * 24);
                diffs.push(diff);
            }

            // Find the mode of the differences
            let modeDiff = findMode(diffs);

            // Determine the frequency based on the difference
            if (modeDiff >= 28 && modeDiff <= 31) {
                return "M"; // Monthly
            } else if (modeDiff >= 89 && modeDiff <= 92) {
                return "Q"; // Quarterly
            } else if (modeDiff >= 364 && modeDiff <= 366) {
                return "Y"; // Yearly
            } else if (modeDiff === 7) {
                return "W"; // Weekly
            } else if (modeDiff === 1) {
                return "D"; // Daily
            } else {
                return "Unknown frequency";
            }
        }

        function findMode(arr) {
            const frequency = {};
            let maxFreq = 0;
            let mode = null;

            arr.forEach(value => {
                frequency[value] = (frequency[value] || 0) + 1;
                if (frequency[value] > maxFreq) {
                    maxFreq = frequency[value];
                    mode = value;
                }
            });

            return mode;
        }
    </script>
@endsection
