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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Data Info Card -->
            <div class="relative bg-white border border-gray-300 rounded-lg p-6 lg:col-span-1">
                <span class="absolute -top-2 -left-2 bg-white px-2 text-blue-600 text-lg">
                    Time Series Data Info
                </span>
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Time Series Type</label>
                    <input type="text" id="type" name="type" value="{{ $type }}" readonly
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="freq" class="block text-sm font-medium text-gray-700">Frequency</label>
                    <input type="text" id="freq" name="freq" readonly
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
            <div class="relative bg-white border border-gray-300 rounded-lg p-6 lg:col-span-2">
                <span class="absolute -top-2 -left-2 bg-white px-2 text-blue-600 text-lg">
                    Processing Option
                </span>
                <div class="grid grid-cols-3 gap-4">
                    <!-- Feature Variables -->
                    <div class="p-4">
                        <p class="text-sm font-medium text-gray-700 mb-4">Time Series Variables</p>
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

                    <!-- Fill Options -->
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

                    <!-- Time Series to Include -->
                    <div class="p-4">
                        <p class="text-sm font-medium text-gray-700 mb-4">Time Series to Include</p>
                        @foreach ($headers as $index => $header)
                            @if ($index > 0)
                                <div>
                                    <input type="checkbox" name="included-variables"
                                        id="included-variable-{{ $index }}" value="{{ $header }}" checked>
                                    {{ $header }}
                                </div>
                            @endif
                        @endforeach
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

        let freq = "";

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

        freq = inferFrequency(tempData.map(row => convertDate(row[0])));
        $('#freq').val(freq);

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
            const originalValues = data.map(row => parseFloat(row[index]) || null); // Original values
            const dates = tempData.map(row => convertDate(row[0]));

            showChart(label, dates, values, originalValues); // Pass original values to the chart
            console.log(`${label} - ${fillMethods[index]}`);

            // Check the corresponding fill method radio button
            document.querySelector(`input[name="fill-method"][value="${method}"]`).checked = true;
        }


        document.querySelectorAll('input[name="fill-method"]').forEach(input => {
            input.addEventListener('change', () => {
                if (activeIndex !== null) {
                    const method = document.querySelector('input[name="fill-method"]:checked').value;
                    console.log(`options - ${method}`)

                    fillMissingValues(method, activeIndex);

                    const label = headers[activeIndex];
                    const values = tempData.map(row => parseFloat(row[activeIndex]) || null);
                    const originalValues = data.map(row => parseFloat(row[activeIndex]) ||
                        null); // Original values
                    const dates = tempData.map(row => convertDate(row[0]));
                    showChart(label, dates, values, originalValues); // Pass original values to the chart
                }
            });
        });

        function showChart(label, dates, values, originalValues) {
            if (chartInstance) {
                chartInstance.destroy();
            }

            const formattedData = dates.map((date, index) => ({
                x: date,
                y: values[index]
            }));

            const originalData = dates.map((date, index) => ({
                x: date,
                y: originalValues[index]
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
                        name: `${label} (Filled)`,
                        data: formattedData
                    },
                    {
                        name: `${label} (Original)`,
                        data: originalData
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
                        text: 'Value'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2, // Different widths for filled and original values
                },
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

        function getSelectedVariables() {
            // Collect all checked checkboxes
            const selected = [];
            document.querySelectorAll('input[name="included-variables"]:checked').forEach((checkbox) => {
                selected.push(checkbox.value);
            });
            return selected;
        }

        function filterDataBySelectedVariables(headers, data, selectedVariables) {
            const filteredHeaders = headers.filter((header) => selectedVariables.includes(header) || headers.indexOf(
                header) === 0);
            const filteredData = data.map((row) => row.filter((_, index) => selectedVariables.includes(headers[index]) ||
                index === 0));

            return {
                headers: filteredHeaders,
                data: filteredData
            };
        }

        function convertToCSV(headers, data) {
            const csvRows = [];
            csvRows.push(headers.join(","));
            for (const row of data) {
                row[0] = convertDate(row[0]);
                csvRows.push(row.join(","));
            }
            return csvRows.join("\n");
        }

        function convertDate(inputDate) {
            const parsedDate = new Date(inputDate);
            const formattedDate = dateFns.format(parsedDate, "MM/dd/yyyy");
            return formattedDate;
        }

        document.getElementById("submit-button").addEventListener("click", () => {

            headers.forEach((header, index) => {
                if (index > 0) { // Skip the date column
                    let method = fillMethods[index] || 'forward';
                    fillMissingValues(method, index);
                }
            });

            const selectedVariables = getSelectedVariables();

            if (selectedVariables.length === 0) {
                alert("Please select at least one variable to include.");
                return;
            }

            const {
                headers: filteredHeaders,
                data: filteredData
            } = filterDataBySelectedVariables(headers, tempData, selectedVariables);

            const csvData = convertToCSV(filteredHeaders, filteredData);

            let type = @json($type);
            const description = document.getElementById("description").value;
            
            const filename = $('#filename').val();
            const source = @json($source);

            if (selectedVariables.length == 1) {
                type = "univariate";
            }

            const formData = new FormData();
            formData.append("csv_file", new Blob([csvData], {
                type: "text/csv"
            }), "data.csv");
            formData.append("type", type);
            formData.append('freq', freq);
            formData.append("description", description);
            formData.append("filename", filename);
            formData.append("source", source);

            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            $.ajax({
                url: "{{ route('save') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute(
                        "content")
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Data saved successfully:", response);
                    window.location.href = response.redirect_url;
                },
                error: function(xhr, status, error) {
                    console.error("Error saving data:", error);
                    window.location.href = response.redirect_url;
                }
            });
        });
    </script>
@endsection
