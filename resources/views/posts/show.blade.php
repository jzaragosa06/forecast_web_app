@extends('layouts.base')

@section('title', 'Post Details')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-6 py-4 h-screen">
        <!-- Left Column: Scrollable -->
        <div class="flex flex-col h-full bg-gray-100 p-4 rounded-lg shadow-md overflow-y-auto">
            <!-- Scrollable content area -->
            <div class="flex-1">
                <!-- Post Title and Meta Info -->
                <h1 class="text-2xl font-semibold mb-2">{{ $post->title }}</h1>
                <p class="text-sm text-gray-500">Posted by: {{ $post->user->name }} on
                    {{ $post->created_at->format('M d, Y') }}</p>

                <!-- Post Body -->
                <div class="mt-4 text-gray-700">
                    <p>{!! $post->body !!}</p>
                </div>


                <!-- Comments Section -->
                <div class="mt-6 bg-white p-4 rounded-lg shadow-md relative">-
                    <h2 class="text-xl font-semibold mb-4 flex items-center justify-between">
                        Comments
                        <!-- Font Awesome Comment Icon -->
                        <i class="fas fa-plus text-blue-500 cursor-pointer"
                            onclick="document.getElementById('comment-form-section').scrollIntoView({ behavior: 'smooth' })"></i>
                    </h2>

                    <div id="comments-section">
                        @if ($post->comments->where('parent_id', null)->isEmpty())
                            <p class="text-center text-gray-500">No comments exist. Be the first to comment.</p>
                        @else
                            @foreach ($post->comments->where('parent_id', null) as $comment)
                                @include('posts.partials.comment', ['comment' => $comment])
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>

            <!-- Fixed Comment Form at the bottom -->
            <div id="comment-form-section" class="mt-4">
                <h3 id="comment-header" class="text-lg font-semibold">Post a comment</h3>
                <form id="comment-form" action="{{ route('comments.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" id="parent_id" name="parent_id" value="">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <textarea id="comment-body" name="body" rows="2"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Write your comment here..."></textarea>

                    <div class="flex justify-end mt-2">
                        <button type="submit"
                            class="bg-blue-500 text-white py-1 px-4 rounded-md hover:bg-blue-600">Submit</button>
                        <button type="button" id="cancel-reply" class="ml-2 text-gray-600 hover:text-red-500"
                            style="display:none;">Cancel Reply</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Static -->
        <div class="bg-gray-100 p-4 rounded-lg shadow-md h-full">
            <!-- Conditional buttons and charts rendering -->
            <div class="mb-4">
                @if ($file_meta['operation'] == 'forecast')
                    @if ($file_meta['inputFileType'] == 'univariate')
                        <!-- Forecast Charts for Univariate Data -->
                        <div class="mb-4">
                            <div id="chart1" class="h-64 bg-white shadow-md rounded-md"></div>
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @else
                        <!-- Forecast Charts for Multivariate Data -->
                        <div class="mb-4">
                            <div id="chart1" class="h-64 bg-white shadow-md rounded-md"></div>
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @endif
                @elseif ($file_meta['operation'] == 'trend')
                    @if ($file_meta['inputFileType'] == 'univariate')
                        <!-- Trend Charts for Univariate Data -->
                        <div class="mb-4">
                            <div id="chart1" class="h-64 bg-white shadow-md rounded-md"></div>
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @else
                        <!-- Trend Charts for Multivariate Data -->
                        <div class="mb-4">
                            <div id="chart-container" class="h-64 bg-white shadow-md rounded-md"></div>
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @endif
                @else
                    @if ($file_meta['inputFileType'] == 'univariate')
                        <!-- Seasonality for Univariate Data -->
                        <div id="button-container" class="flex gap-2 mb-4">
                            <!-- Dynamic buttons will be inserted here -->
                        </div>
                        <div id="chart-container" class="flex flex-col gap-6">
                            <!-- Dynamic charts will be inserted here -->
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @else
                        <!-- Seasonality for Multivariate Data -->
                        <div id="button-container" class="flex overflow-x-auto gap-2 mb-4">
                            <!-- Dynamic buttons for components will be inserted here -->
                        </div>
                        <div id="chart-container" class="flex flex-col gap-6">
                            <!-- Dynamic charts will be inserted here -->
                        </div>
                        <div>
                            <div id="chart" class="h-64 bg-white shadow-md rounded-md"></div>
                            <!-- Description of the time series data that was used to produce the result. -->
                            <p class="text-gray-400 text-sm mt-2">{{ $timeSeriesData['description'] }}</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>



    <script>
        function renderInputData() {
            // ApexCharts initialization
            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false,
                    }
                },
                title: {
                    text: 'Raw Data',
                    align: 'left',
                    style: {
                        fontSize: '18px', // Font size of the title
                        color: '#263238' // Color of the title
                    }
                },
                series: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            name: '{{ $timeSeriesData['header'][$i] }}',
                            data: {!! json_encode(
                                array_map(function ($row) use ($i) {
                                    return floatval($row['values'][$i - 1]);
                                }, $timeSeriesData['data']),
                            ) !!}
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                xaxis: {
                    categories: {!! json_encode(array_column($timeSeriesData['data'], 'date')) !!},
                    type: 'datetime',
                },
                yaxis: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            title: {
                                text: ' {{ $timeSeriesData['header'][$i] }}'
                            },
                            labels: {
                                show: true,
                                formatter: function(value) {
                                    return isNaN(value) ? value : value.toFixed(2);
                                }
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            }
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                stroke: {
                    curve: 'smooth',
                    lineCap: 'butt',
                    colors: undefined,
                    width: 2,
                    dashArray: 0,
                },
                grid: {
                    show: true,
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }

        @if ($file_meta['operation'] == 'forecast')
            @if ($file_meta['inputFileType'] == 'univariate')
                $(document).ready(function() {
                    renderInputData();
                });
                $(document).ready(function() {
                    // Fetch and parse JSON data from the server-side
                    const jsonData = @json($data); // Server-side rendered data
                    const data = JSON.parse(jsonData);
                    const colname = data.metadata.colname;

                    renderChart1();


                    $('#forecastTable').DataTable({
                        "pageLength": 10,
                        "ordering": true,
                        "searching": false, // Remove the search box
                        "lengthChange": true // Remove the entries dropdown
                    });

                    function renderChart1() {
                        // Forecast index
                        let forecastIndex = data.forecast.pred_out.index;
                        let forecastValue = data.forecast
                            .pred_out[
                                `${colname}`];


                        // Initialize the first chart using ApexCharts
                        let options1 = {
                            chart: {
                                type: 'line',
                                height: 300,
                                toolbar: {
                                    show: false,
                                },


                            },
                            series: [{
                                name: 'Pred Out',
                                data: forecastValue,

                            }],
                            xaxis: {
                                categories: forecastIndex,
                                type: 'datetime',

                            },
                            yaxis: {
                                labels: {
                                    formatter: function(value) {
                                        // Check if the value is a valid number before applying toFixed
                                        return isNaN(value) ? value : value.toFixed(
                                            2); // Safely format only valid numeric values
                                    }
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(value) {
                                        // Check if the value is a valid number before applying toFixed
                                        return isNaN(value) ? value : value.toFixed(
                                            2); // Safely format only valid numeric values
                                    }
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },

                        };

                        let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
                        chart1.render();

                    }
                });
            @else
                $(document).ready(function() {
                    renderInputData();
                });
                $(document).ready(function() {

                    // Fetch and parse JSON data from the server-side
                    const jsonData = @json($data); // Server-side rendered data
                    const data = JSON.parse(jsonData);
                    // const colname = data.metadata.colname;
                    const colname = (data.metadata.colname)[(data.metadata.colname).length - 1];



                    renderChart1();


                    $('#forecastTable').DataTable({
                        "pageLength": 10,
                        "ordering": true,
                        "searching": false, // Remove the search box
                        "lengthChange": true // Remove the entries dropdown
                    });

                    function renderChart1() {
                        // Forecast index
                        let forecastIndex = data.forecast.pred_out.index;
                        let forecastValue = data.forecast
                            .pred_out[
                                `${colname}`];


                        // Initialize the first chart using ApexCharts
                        let options1 = {
                            chart: {
                                type: 'line',
                                height: 300,
                                toolbar: {
                                    show: false,
                                },


                            },
                            series: [{
                                name: 'Pred Out',
                                data: forecastValue,

                            }],
                            xaxis: {
                                categories: forecastIndex,
                                type: 'datetime',

                            },
                            yaxis: {
                                labels: {
                                    formatter: function(value) {
                                        // Check if the value is a valid number before applying toFixed
                                        return isNaN(value) ? value : value.toFixed(
                                            2); // Safely format only valid numeric values
                                    }
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(value) {
                                        // Check if the value is a valid number before applying toFixed
                                        return isNaN(value) ? value : value.toFixed(
                                            2); // Safely format only valid numeric values
                                    }
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },

                        };

                        let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
                        chart1.render();

                    }




                });
            @endif
        @elseif ($file_meta['operation'] == 'trend')
            @if ($file_meta['inputFileType'] == 'univariate')
                renderInputData();

                $(document).ready(function() {
                    // Fetch and parse JSON data from the server-side
                    const jsonData = @json($data); // Server-side rendered data
                    const data = JSON.parse(jsonData);

                    // Utility function to handle missing values
                    const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

                    // Clean the data to handle missing values
                    const trendData = cleanData(data.trend[`${data.metadata.colname}`]);


                    // Initialize the chart with ApexCharts
                    var options = {
                        chart: {
                            type: 'line',
                            height: 300,
                            zoom: {
                                enabled: true
                            },
                            toolbar: {
                                show: false,
                            }
                        },
                        series: [{
                            name: `${data.metadata.colname}`,
                            data: trendData,
                        }],
                        xaxis: {
                            categories: data.trend.index, // x-axis labels (dates/times)
                            title: {
                                text: 'Date/Time'
                            },
                            type: 'datetime',
                        },
                        yaxis: {
                            title: {
                                text: `${data.metadata.colname}`,
                            },
                            labels: {
                                formatter: function(value) {
                                    // Check if the value is a valid number before applying toFixed
                                    return isNaN(value) ? value : value.toFixed(
                                        2); // Safely format only valid numeric values
                                }
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        tooltip: {
                            enabled: true,
                            shared: true,
                            intersect: false
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#chart1"), options);
                    chart.render();
                });
            @else
                renderInputData();
                $(document).ready(function() {
                    // Fetch and parse JSON data from the server-side
                    const jsonData = @json($data); // Server-side rendered data
                    const data = JSON.parse(jsonData);
                    const colnames = data.metadata.colname;


                    // Utility function to handle missing values
                    const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

                    const seriesData = [];
                    const yAxisCongif = [];


                    colnames.forEach((col, index) => {
                        seriesData.push({
                            name: col,
                            data: cleanData(data.trend[`${col}`])
                        });


                        yAxisCongif.push({
                            title: {
                                text: `${col}`,
                            },
                            labels: {
                                show: true,
                                formatter: function(value) {
                                    return isNaN(value) ? value : value.toFixed(2);
                                }
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            }
                        });
                    });




                    // Initialize the chart with ApexCharts
                    var options = {
                        chart: {
                            type: 'line',
                            height: 350,
                            zoom: {
                                enabled: true
                            },
                            toolbar: {
                                show: false,
                            },
                            events: {
                                markerClick: function(event, chartContext, opts) {
                                    console.log(opts);
                                    console.log(opts.seriesIndex);

                                    //well fetch the colname from the index
                                    handleExplanationSelection(colname_seriesIndexDict[opts.seriesIndex]);


                                }
                            },
                        },
                        series: seriesData,
                        xaxis: {
                            categories: data.trend.index, // x-axis labels (dates/times)
                            title: {
                                text: 'Date/Time'
                            },
                            type: 'datetime',
                        },
                        yaxis: yAxisCongif,
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        tooltip: {
                            enabled: true,
                            shared: true,
                            intersect: false
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-container"), options);
                    chart.render();

                });
            @endif
        @else
            @if ($file_meta['inputFileType'] == 'univariate')
                renderInputData();
                $(document).ready(function() {

                    const jsonData = @json($data);
                    const data = JSON.parse(jsonData);


                    const generateYearlyLabels = () => {
                        const labels = [];
                        const arbitraryYear = 2020; // Arbitrary non-leap year
                        let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

                        while (currentDate.getFullYear() === arbitraryYear) {
                            // Convert to timestamp for ApexCharts datetime x-axis
                            labels.push(currentDate.getTime());
                            // Increment by 1 day
                            currentDate.setDate(currentDate.getDate() + 1);
                        }

                        return labels;
                    };

                    const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    const yearlyLabels = generateYearlyLabels();

                    // Reference to containers
                    const chartContainer = document.getElementById('chart-container');
                    const buttonContainer = document.getElementById('button-container');


                    // Function to create chart
                    function createChart(title, labels, seriesData, isDatetime = false) {
                        const cardDiv = document.createElement('div');
                        cardDiv.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'p-6', 'mb-6');

                        const chartDiv = document.createElement('div');
                        chartDiv.style.marginBottom = '20px';
                        cardDiv.appendChild(chartDiv);
                        chartContainer.appendChild(cardDiv);

                        const options = {
                            chart: {
                                type: 'line',
                                height: 350,
                                animations: {
                                    enabled: true
                                },
                                toolbar: {
                                    show: false
                                }
                            },
                            title: {
                                text: title,
                                align: 'left'
                            },
                            xaxis: {
                                type: isDatetime ? 'datetime' : 'category', // Use 'datetime' for yearly
                                categories: labels,
                                labels: {
                                    formatter: function(value, timestamp) {
                                        if (isDatetime) {
                                            // Format the datetime labels to only show month and day
                                            return new Date(timestamp).toLocaleDateString('en-US', {
                                                month: 'short',
                                                day: 'numeric'
                                            });
                                        } else {
                                            return value;
                                        }
                                    }
                                }
                            },
                            series: seriesData,
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            markers: {
                                size: 0
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                x: {
                                    format: 'MMM dd'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Value'
                                },
                                labels: {
                                    formatter: (value) => value.toFixed(2)
                                }
                            }
                        };

                        const chart = new ApexCharts(chartDiv, options);
                        chart.render();
                    }

                    // Function to create buttons
                    function createButton(component) {
                        const button = document.createElement('button');
                        button.classList.add('font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none');

                        // Set the button styles based on the component state
                        button.textContent = component.charAt(0).toUpperCase() + component.slice(1);
                        button.onclick = () => {
                            loadComponent(component);
                            updateButtonStyles(component);
                        };

                        // Return the button element
                        return button;
                    }

                    // Function to update button styles
                    function updateButtonStyles(selectedComponent) {
                        const buttons = buttonContainer.querySelectorAll('button');

                        buttons.forEach(button => {
                            if (button.textContent.toLowerCase() === selectedComponent) {
                                button.classList.add('bg-blue-500', 'text-white');
                                button.classList.remove('bg-white', 'text-blue-500', 'border');
                            } else {
                                button.classList.add('bg-white', 'text-blue-500', 'border',
                                    'border-blue-500');
                                button.classList.remove('bg-blue-500', 'text-white');
                            }
                        });
                    }

                    // Function to load the component (weekly or yearly)
                    function loadComponent(component) {
                        chartContainer.innerHTML = ''; // Clear previous charts

                        data.components.forEach(comp => {
                            if (comp === component) {
                                let labels, title, isDatetime = false;
                                const colname = data.metadata.colname;
                                const seriesData = [{
                                    name: 'Value',
                                    data: data.seasonality_per_period[colname][component].values
                                }];

                                if (component === 'yearly') {
                                    labels = yearlyLabels;
                                    title = `${colname} - Yearly Seasonality`;
                                    isDatetime = true;
                                } else if (component === 'weekly') {
                                    labels = weeklyLabels;
                                    title = `${colname} - Weekly Seasonality`;
                                }
                                createChart(title, labels, seriesData, isDatetime);

                            }
                        });
                    }

                    // Generate buttons based on available components
                    data.components.forEach(component => {
                        const button = createButton(component);
                        buttonContainer.appendChild(button);
                    });

                    // Initial loading of the first component
                    loadComponent(data.components[0]);
                    updateButtonStyles(data.components[0]);
                });
            @else
                renderInputData();

                $(document).ready(function() {

                    const jsonData = @json($data);
                    const data = JSON.parse(jsonData);

                    const generateYearlyLabels = () => {
                        const labels = [];
                        const arbitraryYear = 2020; // Arbitrary non-leap year
                        let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

                        while (currentDate.getFullYear() === arbitraryYear) {
                            // Convert to timestamp for ApexCharts datetime x-axis
                            labels.push(currentDate.getTime());
                            // Increment by 1 day
                            currentDate.setDate(currentDate.getDate() + 1);
                        }

                        return labels;
                    };

                    const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    const yearlyLabels = generateYearlyLabels();

                    // Reference to containers
                    const chartContainer = document.getElementById('chart-container');
                    const buttonContainer = document.getElementById('button-container');

                    // Function to create chart
                    function createChart(title, labels, seriesData, yAxisConfig, isDatetime = false) {
                        const cardDiv = document.createElement('div');
                        cardDiv.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'p-6', 'mb-6');

                        const chartDiv = document.createElement('div');
                        chartDiv.style.marginBottom = '20px';
                        cardDiv.appendChild(chartDiv);
                        chartContainer.appendChild(cardDiv);

                        const options = {
                            chart: {
                                type: 'line',
                                height: 350,
                                animations: {
                                    enabled: true
                                },
                                toolbar: {
                                    show: false
                                }
                            },
                            title: {
                                text: title,
                                align: 'left'
                            },
                            xaxis: {
                                type: isDatetime ? 'datetime' : 'category',
                                categories: labels,
                                labels: {
                                    formatter: function(value, timestamp) {
                                        if (isDatetime) {
                                            return new Date(timestamp).toLocaleDateString('en-US', {
                                                month: 'short',
                                                day: 'numeric'
                                            });
                                        } else {
                                            return value;
                                        }
                                    }
                                }
                            },
                            series: seriesData,
                            yaxis: yAxisConfig,
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            markers: {
                                size: 0
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                x: {
                                    format: 'MMM dd'
                                }
                            }
                        };

                        const chart = new ApexCharts(chartDiv, options);
                        chart.render();
                    }

                    // Function to create buttons for components
                    function createButton(label, container, onClick) {
                        const button = document.createElement('button');
                        button.classList.add('font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none',
                            'bg-white',
                            'text-blue-500',
                            'border', 'border-blue-500');
                        button.textContent = label.charAt(0).toUpperCase() + label.slice(1);
                        button.onclick = onClick;
                        container.appendChild(button);
                    }

                    // Function to load the component (weekly or yearly)
                    function loadComponent(component) {
                        chartContainer.innerHTML = '';
                        const colnames = data.metadata.colname;
                        let seriesData = [];
                        let yAxisConfig = [];
                        let title =
                            `${data.metadata.colname.join(', ')} - ${component.charAt(0).toUpperCase() + component.slice(1)} Seasonality`;

                        colnames.forEach((col) => {
                            const seasonalityData = data.seasonality_per_period[col];

                            if (seasonalityData[component]) {
                                seriesData.push({
                                    name: col,
                                    data: seasonalityData[component].values
                                });

                                // Add y-axis configuration for this variable
                                yAxisConfig.push({
                                    seriesName: col,
                                    title: {
                                        text: col
                                    },
                                    labels: {
                                        show: true,
                                        formatter: function(value) {
                                            return isNaN(value) ? value : value.toFixed(2);
                                        }
                                    },
                                });
                            }
                        });

                        const isDatetime = component === 'yearly';
                        createChart(title, isDatetime ? yearlyLabels : weeklyLabels, seriesData, yAxisConfig,
                            isDatetime);
                    }

                    // Generate buttons based on available components
                    data.components.forEach(component => {
                        createButton(component, buttonContainer, () => {
                            loadComponent(component);
                            updateButtonStyles(component,
                                buttonContainer); // Update button styles for the selected component
                        });
                    });

                    // Function to update button styles for component buttons
                    function updateButtonStyles(selectedComponent, container) {
                        const buttons = container.querySelectorAll('button');

                        buttons.forEach(button => {
                            // Reset all button styles
                            button.classList.remove('bg-blue-500', 'text-white', 'bg-white',
                                'text-blue-500', 'border', 'border-blue-500');

                            // Apply styles based on whether this is the selected button
                            if (button.textContent.toLowerCase() === selectedComponent.toLowerCase()) {
                                button.classList.add('bg-blue-500', 'text-white');
                            } else {
                                button.classList.add('bg-white', 'text-blue-500', 'border',
                                    'border-blue-500');
                            }
                        });
                    }

                    // Load the first component by default
                    const initialComponent = data.components[0];
                    loadComponent(initialComponent);
                    updateButtonStyles(initialComponent, buttonContainer);
                });
            @endif
        @endif

        // Comment Functionality
        $(document).ready(function() {
            const commentForm = document.getElementById('comment-form');
            const parentIdField = document.getElementById('parent_id');
            const commentHeader = document.getElementById('comment-header');
            const commentBody = document.getElementById('comment-body');
            const cancelReplyButton = document.getElementById('cancel-reply');
            const replyButtons = document.querySelectorAll('.reply-btn');

            // When reply button is clicked, set the parent_id and update form header
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const username = this.getAttribute('data-username');

                    parentIdField.value = commentId; // Set parent_id to the comment ID
                    commentHeader.textContent = `Replying to ${username}`;
                    commentBody.placeholder = `Reply to ${username}...`;

                    cancelReplyButton.style.display = 'inline'; // Show the cancel button
                });
            });

            // When cancel reply is clicked, reset the form to post a new comment
            cancelReplyButton.addEventListener('click', function() {
                parentIdField.value = ''; // Reset parent_id
                commentHeader.textContent = 'Post a comment';
                commentBody.placeholder = 'Write your comment here...';

                cancelReplyButton.style.display = 'none'; // Hide the cancel button
            });
        });
    </script>
@endsection
