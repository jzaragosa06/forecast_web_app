@extends('layouts.base')

@section('title', 'Upload Inputs')

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
                    <label for="type" class="block text-sm font-medium text-gray-700">Time Series Type</label>
                    <input type="text" id="type" name="type" value="{{ $type }}" readonly
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="freq" class="block text-sm font-medium text-gray-700">Frequency</label>
                    <input type="text" id="freq" name="freq" value="{{ $freq }}" readonly
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="5"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="filename" class="block text-sm font-medium text-gray-700">Filename</label>
                    <input type="text" id="filename" name="filename" value="{{ $filename }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>

            <!-- Processing Options Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="container mx-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-4">Feature Variables</h3>
                            <div id="variable-buttons" class="space-y-2">
                                @foreach ($headers as $index => $header)
                                    @if ($index > 0)
                                        <button
                                            class="feature-btn px-4 py-2 rounded-md border border-gray-300 w-full text-left transition-colors hover:bg-indigo-500 hover:text-white"
                                            data-index="{{ $index }}">{{ $header }}</button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="p-4">
                            <form id="processing-form">
                                <fieldset>
                                    <legend class="text-sm font-medium text-gray-700 mb-4">Fill Missing Value (NaN) with:
                                    </legend>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="fill-method" value="forward" checked
                                                class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <span class="ml-2">Forward Fill</span>
                                        </label>
                                    </div>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="fill-method" value="backward"
                                                class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <span class="ml-2">Backward Fill</span>
                                        </label>
                                    </div>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="fill-method" value="average"
                                                class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <span class="ml-2">Average of the series</span>
                                        </label>
                                    </div>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="fill-method" value="zero"
                                                class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <span class="ml-2">Fill with zeros</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="mt-6">
                    <button type="button" id="submit-button"
                        class="w-full inline-flex justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Save
                    </button>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('scripts')
    <script>
        const data = @json($data);
        const headers = @json($headers);
        let tempData = JSON.parse(JSON.stringify(data));
        let fillMethods = {};
        let activeIndex = null;
        let chartInstance = null;



        // ---------------
        const featureButtons = document.querySelectorAll('.feature-btn');

        // Highlight the first button initially
        featureButtons[0].classList.add('bg-indigo-500', 'text-white');
        // Display first variable immediately on page load
        showVariableData(featureButtons[0].getAttribute('data-index'));

        featureButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove highlight from all buttons
                featureButtons.forEach(btn => btn.classList.remove('bg-indigo-500', 'text-white'));
                // Highlight the clicked button
                button.classList.add('bg-indigo-500', 'text-white');

                // Display the chart and fill method for the clicked variable
                const index = button.getAttribute('data-index');
                showVariableData(index);
            });
        });

        function showVariableData(index) {
            activeIndex = index; // Update activeIndex here

            let method = 'forward'; // Default fill method

            // Use the previously selected fill method if available
            if (fillMethods[activeIndex]) {
                method = fillMethods[activeIndex];
            }

            fillMissingValues(method, index);

            const label = headers[index];
            const values = tempData.map(row => parseFloat(row[index]) || null);
            const dates = tempData.map(row => convertDate(row[0]));

            showChart(label, dates, values);
            console.log(`${label} - ${fillMethods[index]}`);

            // Check the corresponding fill method radio button
            document.querySelector(`input[name="fill-method"][value="${method}"]`).checked = true;
        }


        // ----------

        document.querySelectorAll('input[name="fill-method"]').forEach(input => {
            input.addEventListener('change', () => {
                if (activeIndex !== null) {
                    const method = document.querySelector('input[name="fill-method"]:checked').value;
                    console.log(`options - ${method}`)

                    fillMissingValues(method, activeIndex);

                    const label = headers[activeIndex];
                    const values = tempData.map(row => parseFloat(row[activeIndex]) || null);
                    const dates = tempData.map(row => convertDate(row[0]));
                    showChart(label, dates, values);
                }
            });
        });


        function showChart(label, dates, values) {
            if (chartInstance) {
                chartInstance.destroy();
            }

            const formattedData = dates.map((date, index) => ({
                x: date,
                y: values[index]
            }));

            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: false,
                    }
                },
                series: [{
                    name: label,
                    data: formattedData
                }],
                xaxis: {
                    type: 'datetime',
                    title: {
                        text: 'Date'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Value'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 1,
                }
            };

            chartInstance = new ApexCharts(document.querySelector("#chart"), options);
            chartInstance.render();
        }




        function fillMissingValues(method, index) {
            fillMethods[index] = method;
            console.log(fillMethods);

            const dataCopy = JSON.parse(JSON.stringify(data)); // Make a copy of the original data

            for (const [i, row] of dataCopy.entries()) {
                const currentMethod = fillMethods[i] || 'forward';
                switch (currentMethod) {
                    case 'forward':
                        for (let j = 1; j < dataCopy.length; j++) {
                            if (dataCopy[j][i] === null || dataCopy[j][i] === '') {
                                dataCopy[j][i] = dataCopy[j - 1][i];
                            }
                        }
                        break;
                    case 'backward':
                        for (let j = dataCopy.length - 2; j >= 0; j--) {
                            if (dataCopy[j][i] === null || dataCopy[j][i] === '') {
                                dataCopy[j][i] = dataCopy[j + 1][i];
                            }
                        }
                        break;
                    case 'average':
                        let sum = 0;
                        let count = 0;
                        for (let j = 0; j < dataCopy.length; j++) {
                            if (dataCopy[j][i] !== null && dataCopy[j][i] !== '') {
                                sum += parseFloat(dataCopy[j][i]);
                                count++;
                            }
                        }
                        const average = sum / count;
                        for (let j = 0; j < dataCopy.length; j++) {
                            if (dataCopy[j][i] === null || dataCopy[j][i] === '') {
                                dataCopy[j][i] = average;
                            }
                        }
                        break;
                    case 'zero':
                        for (let j = 0; j < dataCopy.length; j++) {
                            if (dataCopy[j][i] === null || dataCopy[j][i] === '') {
                                dataCopy[j][i] = 0;
                            }
                        }
                        break;
                }
            }

            tempData = dataCopy;
        }








        function convertToCSV(headers, data) {
            const csvRows = [];
            csvRows.push(headers.join(','));
            for (const row of data) {
                csvRows.push(row.join(','));
            }
            return csvRows.join('\n');
        }

        function createDownloadLink(csvData) {
            const blob = new Blob([csvData], {
                type: 'text/csv'
            });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.getElementById('download-link');
            downloadLink.href = url;
            downloadLink.download = 'processed_data.csv';
            downloadLink.textContent = 'Download Processed Data';
            downloadLink.style.display = 'block';
        }



        function convertDate(inputDate) {
            // Parse the input date string into a Date object
            const parsedDate = new Date(inputDate);

            // Format the date as MM/dd/yyyy (full year format)
            const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
            return formattedDate;
        }

        document.getElementById('submit-button').addEventListener('click', () => {
            console.log('');
            let finalData = JSON.parse(JSON.stringify(data));

            headers.forEach((header, index) => {
                if (index > 0) { // Skip the date column
                    let method = fillMethods[index] || 'forward';
                    fillMissingValues(method, index);
                }
            });

            const csvData = convertToCSV(headers, tempData);

            //extract the additional data from the controller. 
            const type = @json($type);
            const freq = @json($freq);
            const description = @json($description);
            const filename = @json($filename);



            // Create a FormData object to send the CSV and other data
            const formData = new FormData();
            formData.append('csv_file', new Blob([csvData], {
                type: 'text/csv'
            }), 'data.csv');


            formData.append('type', type);
            formData.append('freq', freq);
            formData.append('description', description);
            formData.append('filename', filename);

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
                    console.log('Data saved successfully:', response);

                    // Redirect the user manually
                    window.location.href = response.redirect_url;
                },
                error: function(xhr, status, error) {
                    console.error('Error saving data:', error);
                    // Handle error response
                }
            });


        });
    </script>
@endsection
