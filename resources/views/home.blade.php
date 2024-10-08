@extends('layouts.base')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')


@section('content')
    <div class="container  mx-auto my-6">
        <div class="container mx-auto p-4">
            <div class="flex space-x-4">

                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                        <h4 class="text-lg font-semibold mb-4">Add Data</h4>
                        <div class="flex-grow">
                            <button type="button" id="ts-info"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md mb-2 hover:bg-blue-700"
                                data-toggle="modal" data-target="#ts-info-form">
                                Add More data via upload
                            </button>
                            <button type="button" id="ts-add-via-api-open-meteo-btn"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" data-toggle="modal"
                                data-target="#ts-add-via-api-open-meteo-modal">
                                Add data from Open-Meteo
                            </button>

                            {{-- Stocks --}}
                            <button type="button" id="ts-add-via-api-stocks-btn"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Stocks
                            </button>

                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                        <h4 class="text-lg font-semibold mb-4">Analyze</h4>
                        <form action="{{ route('manage.operations') }}" method="post" class="flex-grow">
                            @csrf
                            <div class="mb-4">
                                <label for="file_id" class="block text-sm font-medium mb-1">Select File</label>
                                <select name="file_id" id="file_id"
                                    class="form-select block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach (Auth::user()->files as $file)
                                        <option value="{{ $file->file_id }}">{{ $file->filename }}</option>
                                    @endforeach
                                    <option value="" id="add-more-from-option">Add more data +</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="operation" class="block text-sm font-medium mb-1">Select Operation</label>
                                <select name="operation" id="operation"
                                    class="form-select block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="trend">Trend</option>
                                    <option value="seasonality">Seasonality</option>
                                    <option value="forecast">Forecast</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Analyze</button>
                        </form>
                    </div>
                </div>



                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                        <h4 class="text-lg font-semibold mb-4">Recent Results</h4>
                        <div class="flex-grow">
                            @if ($file_assocs->isEmpty())
                                <p class="text-gray-500 text-center">No recent results found.</p>
                            @else
                                <ul class="list-disc pl-5">
                                    @foreach ($file_assocs->slice(0, 5) as $file_assoc)
                                        <li class="mb-2">
                                            <a href="{{ route('manage.results.get', $file_assoc->file_assoc_id) }}"
                                                class="text-blue-600 hover:underline">
                                                <p>{{ $file_assoc->assoc_filename }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- Show "View More" link if there are more than 5 results --}}
                        @if ($file_assocs->count() > 5)
                            <div class="mt-4">
                                <a href="{{ route('crud.index') }}" class="text-blue-600 hover:underline font-semibold">
                                    View More
                                </a>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
        <hr class="my-4">



        <div class="flex space-x-4">
            <!-- Input Button -->
            <button id="input-via-uploads-Btn" class="bg-blue-600 text-white border border-blue-600 px-4 py-2 rounded-md">
                Uploads
            </button>
            <!-- Results Button -->
            <button id="input-via-openmeteo-Btn" class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded-md">
                Open-Meteo
            </button>
        </div>

        <div id="input-via-uploads-Container" class="mt-4">
            <!-- Input container content -->
            <div class="container mx-auto p-4">
                @foreach ($timeSeriesData as $index => $fileData)
                    @if ($files[$index]->source == 'uploads')
                        <div class="bg-white border rounded-lg shadow-md mb-4">
                            <div class="p-4">
                                <div class="flex">
                                    <div class="w-full lg:w-1/3">
                                        <h5 class="text-lg font-semibold mb-2">{{ $files[$index]->filename }}</h5>
                                        <p class="text-sm mb-1">Type: {{ $files[$index]->type }}</p>
                                        <p class="text-sm mb-1">Frequency: {{ $files[$index]->freq }}</p>
                                        <p class="text-sm mb-1">Description: {{ $files[$index]->description }}</p>
                                        <form action="{{ route('seqal.index', $files[$index]->file_id) }}" method="post">
                                            @csrf
                                            <button type ="submit" class="text-gray-600 hover:text-gray-800">Seq.
                                                Al.</button>
                                        </form>
                                    </div>
                                    <div class="w-full lg:w-2/3 mt-4 lg:mt-0">
                                        <div class="graph-container mt-4" style="height: 300px;">
                                            <div id="graph-{{ $index }}" style="height: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
        <div id="input-via-openmeteo-Container" class="mt-4 hidden">
            <div class="container mx-auto p-4">
                @foreach ($timeSeriesData as $index => $fileData)
                    @if ($files[$index]->source == 'open-meteo')
                        <div class="bg-white border rounded-lg shadow-md mb-4">
                            <div class="p-4">
                                <div class="flex">
                                    <div class="w-full lg:w-1/3">
                                        <h5 class="text-lg font-semibold mb-2">{{ $files[$index]->filename }}</h5>
                                        <p class="text-sm mb-1">Type: {{ $files[$index]->type }}</p>
                                        <p class="text-sm mb-1">Frequency: {{ $files[$index]->freq }}</p>
                                        <p class="text-sm mb-1">Description: {{ $files[$index]->description }}</p>
                                        <form action="{{ route('seqal.index', $files[$index]->file_id) }}" method="post">
                                            @csrf
                                            <button type ="submit" class="text-gray-600 hover:text-gray-800">Seq.
                                                Al.</button>

                                        </form>
                                    </div>
                                    <div class="w-full lg:w-2/3 mt-4 lg:mt-0">
                                        <div class="graph-container mt-4" style="height: 300px;">
                                            <div id="graph-{{ $index }}" style="height: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    <!-- Upload Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="ts-info-form"
        style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Information About the Time Series Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('upload.ts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium mb-1">Upload from Device</label>
                        <input type="file" name="file" id="file"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium mb-1">Description:</label>

                        <textarea name="description" id="description" cols="10" rows="5"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forecast Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="forecast-modal"
        style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Forecast Settings</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manage.operations') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_id" id="modal_file_id">
                    <input type="hidden" name="operation" value="forecast">

                    <div class="mb-4">
                        <label for="horizon" class="block text-sm font-medium mb-1">Forecast Horizon</label>
                        <input type="number" name="horizon" id="horizon"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Forecast Method</label>
                        <div class="flex items-center">
                            <input type="radio" name="method" value="with_refit" id="with_refit" class="mr-2">
                            <label for="with_refit" class="text-sm">With Refit</label>
                        </div>
                        <div class="flex items-center mt-1">
                            <input type="radio" name="method" value="without_refit" id="without_refit"
                                class="mr-2">
                            <label for="without_refit" class="text-sm">Without Refit</label>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Run
                        Forecast</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Fetch data from open-meteo modal --}}
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden"
        id="ts-add-via-api-open-meteo-modal" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-2/3">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Open Meteo</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body  overflow-y-auto max-h-[75vh]">
                <form action="" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="weather_code_daily" name="daily"
                                    value="weather_code">
                                <label class="ml-2" for="weather_code_daily">Weather code</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_max_daily"
                                    name="daily" value="temperature_2m_max">
                                <label class="ml-2" for="temperature_2m_max_daily">Maximum Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_min_daily"
                                    name="daily" value="temperature_2m_min">
                                <label class="ml-2" for="temperature_2m_min_daily">Minimum Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_mean_daily"
                                    name="daily" value="temperature_2m_mean">
                                <label class="ml-2" for="temperature_2m_mean_daily">Mean Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_max_daily"
                                    name="daily" value="apparent_temperature_max">
                                <label class="ml-2" for="apparent_temperature_max_daily">Maximum Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_min_daily"
                                    name="daily" value="apparent_temperature_min">
                                <label class="ml-2" for="apparent_temperature_min_daily">Minimum Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_mean_daily"
                                    name="daily" value="apparent_temperature_mean">
                                <label class="ml-2" for="apparent_temperature_mean_daily">Mean Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunrise_daily" name="daily"
                                    value="sunrise">
                                <label class="ml-2" for="sunrise_daily">Sunrise</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunset_daily" name="daily"
                                    value="sunset">
                                <label class="ml-2" for="sunset_daily">Sunset</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="daylight_duration_daily" name="daily"
                                    value="daylight_duration">
                                <label class="ml-2" for="daylight_duration_daily">Daylight Duration</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunshine_duration_daily" name="daily"
                                    value="sunshine_duration">
                                <label class="ml-2" for="sunshine_duration_daily">Sunshine Duration</label>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="precipitation_sum_daily" name="daily"
                                    value="precipitation_sum">
                                <label class="ml-2" for="precipitation_sum_daily">Precipitation Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="rain_sum_daily" name="daily"
                                    value="rain_sum">
                                <label class="ml-2" for="rain_sum_daily">Rain Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="snowfall_sum_daily" name="daily"
                                    value="snowfall_sum">
                                <label class="ml-2" for="snowfall_sum_daily">Snowfall Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="precipitation_hours_daily"
                                    name="daily" value="precipitation_hours">
                                <label class="ml-2" for="precipitation_hours_daily">Precipitation Hours</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_speed_10m_max_daily"
                                    name="daily" value="wind_speed_10m_max">
                                <label class="ml-2" for="wind_speed_10m_max_daily">Maximum Wind Speed (10 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_gusts_10m_max_daily"
                                    name="daily" value="wind_gusts_10m_max">
                                <label class="ml-2" for="wind_gusts_10m_max_daily">Maximum Wind Gusts (10 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_direction_10m_dominant_daily"
                                    name="daily" value="wind_direction_10m_dominant">
                                <label class="ml-2" for="wind_direction_10m_dominant_daily">Dominant Wind Direction (10
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="shortwave_radiation_sum_daily"
                                    name="daily" value="shortwave_radiation_sum">
                                <label class="ml-2" for="shortwave_radiation_sum_daily">Shortwave Radiation Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="et0_fao_evapotranspiration_daily"
                                    name="daily" value="et0_fao_evapotranspiration">
                                <label class="ml-2" for="et0_fao_evapotranspiration_daily">Reference Evapotranspiration
                                    (ET₀)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <!-- Date Pickers -->
                        <label for="start-date" class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="end-date" class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <!-- Map Display -->
                        <button type="button" id="use-current-loc-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Use Current
                            Location</button>
                        <button type="button" id="get-from-maps-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Open Map</button>

                        <div id="map" class="mt-4 h-96 hidden"></div>
                        <p id="selected-location" class="mt-2 text-sm">Latitude: <span id="lat"></span>, Longitude:
                            <span id="long"></span>
                        </p>
                    </div>

                    <button type="submit" id="fetch-data-open-meteo-btn"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Fetch</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stocks Modal -->
    {{-- <div id="ts-add-via-api-stocks-modal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Stock Market Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="flex justify-between">
                    <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                        data-dismiss="modal">Close</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Stocks Modal -->
    {{-- <div id="ts-add-via-api-stocks-modal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Stock Market Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <!-- Stock selection using Combo Box -->
                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between space-x-4">
                        <!-- Stock Combo Box -->
                        <div class="w-full">
                            <label for="stock-selection" class="block text-sm font-medium text-gray-700">Select
                                Stock</label>
                            <select id="stock-selection"
                                class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="AAPL">Apple (AAPL)</option>
                                <option value="TSLA">Tesla (TSLA)</option>
                                <option value="GOOG">Google (GOOG)</option>
                                <option value="AMZN">Amazon (AMZN)</option>
                                <option value="MSFT">Microsoft (MSFT)</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="flex space-x-4">
                            <!-- Start Date -->
                            <div>
                                <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start-date"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <!-- End Date -->
                            <div>
                                <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end-date"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>

                    <!-- Interval Dropdown -->
                    <div class="w-full">
                        <label for="interval" class="block text-sm font-medium text-gray-700">Interval</label>
                        <select id="interval"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="1day">1 Day</option>
                            <option value="1week">1 Week</option>
                            <option value="1month">1 Month</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-between mt-4">
                    <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                        data-dismiss="modal">Close</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div id="ts-add-via-api-stocks-modal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Stock Market Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <!-- Stock selection using Combo Box (Input + Datalist) -->
                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between space-x-4">
                        <!-- Stock Combo Box -->
                        <div class="w-full">
                            <label for="stock-selection" class="block text-sm font-medium text-gray-700">Select or Enter
                                Stock</label>
                            <input list="stocks" id="stock-selection" name="stock-selection"
                                class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                placeholder="Enter stock symbol or select from the list">
                            <datalist id="stocks">
                                <option value="AAPL">Apple (AAPL)</option>
                                <option value="TSLA">Tesla (TSLA)</option>
                                <option value="GOOG">Google (GOOG)</option>
                                <option value="AMZN">Amazon (AMZN)</option>
                                <option value="MSFT">Microsoft (MSFT)</option>
                            </datalist>
                        </div>

                        <!-- Date Range -->
                        <div class="flex space-x-4">
                            <!-- Start Date -->
                            <div>
                                <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start-date"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <!-- End Date -->
                            <div>
                                <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end-date"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>

                    <!-- Interval Dropdown -->
                    <div class="w-full">
                        <label for="interval" class="block text-sm font-medium text-gray-700">Interval</label>
                        <select id="interval"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="1day">1 Day</option>
                            <option value="1week">1 Week</option>
                            <option value="1month">1 Month</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-between mt-4">
                    <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                        data-dismiss="modal">Close</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="ts-add-via-api-stocks-modal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40 hidden" style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md md:max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Stock Market Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <!-- Stock selection using Combo Box (Input + Datalist) -->
                <div class="flex flex-col space-y-6">
                    <div class="space-y-2">
                        <!-- Stock Combo Box -->
                        <div>
                            <label for="stock-selection" class="block text-sm font-medium text-gray-700">Select or Enter
                                Stock</label>
                            <input list="stocks" id="stock-selection" name="stock-selection"
                                class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                placeholder="Enter stock symbol or select from the list">
                            <datalist id="stocks">
                                <option value="AAPL">Apple (AAPL)</option>
                                <option value="TSLA">Tesla (TSLA)</option>
                                <option value="GOOG">Google (GOOG)</option>
                                <option value="AMZN">Amazon (AMZN)</option>
                                <option value="MSFT">Microsoft (MSFT)</option>
                            </datalist>
                        </div>

                        <!-- Date Range -->
                        <div class="flex space-x-4">
                            <!-- Start Date -->
                            <div class="w-1/2">
                                <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start-date-stocks"
                                    class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <!-- End Date -->
                            <div class="w-1/2">
                                <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end-date-stocks"
                                    class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>




                    </div>

                    <!-- Interval Dropdown -->
                    <div>
                        <label for="interval" class="block text-sm font-medium text-gray-700">Interval</label>
                        <select id="interval"
                            class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="1day">1 Day</option>
                            <option value="1week">1 Week</option>
                            <option value="1month">1 Month</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end mt-6 space-x-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                        data-dismiss="modal">Close</button>
                    <button id="fetch-data-stocks" type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Fetch</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const uploadsBtn = document.getElementById('input-via-uploads-Btn');
            const openmeteoBtn = document.getElementById('input-via-openmeteo-Btn');
            const uploadsContainer = document.getElementById('input-via-uploads-Container');
            const openmeteoContainer = document.getElementById('input-via-openmeteo-Container');

            // Event listeners to toggle between buttons
            uploadsBtn.addEventListener('click', () => {
                uploadsBtn.classList.add('bg-blue-600', 'text-white');
                uploadsBtn.classList.remove('bg-white', 'text-blue-600');
                openmeteoBtn.classList.add('bg-white', 'text-blue-600');
                openmeteoBtn.classList.remove('bg-blue-600', 'text-white');

                uploadsContainer.classList.remove('hidden');
                openmeteoContainer.classList.add('hidden');
            });

            openmeteoBtn.addEventListener('click', () => {
                openmeteoBtn.classList.add('bg-blue-600', 'text-white');
                openmeteoBtn.classList.remove('bg-white', 'text-blue-600');
                uploadsBtn.classList.add('bg-white', 'text-blue-600');
                uploadsBtn.classList.remove('bg-blue-600', 'text-white');

                uploadsContainer.classList.add('hidden');
                openmeteoContainer.classList.remove('hidden');
            });

        });
        $(document).ready(function() {

            // Iterate over each file data to create corresponding graphs
            @foreach ($timeSeriesData as $index => $fileData)
                var options = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false,
                        }
                    },
                    series: [
                        @for ($i = 1; $i < count($fileData['header']); $i++)
                            {
                                name: '{{ $fileData['header'][$i] }}',
                                data: {!! json_encode(
                                    array_map(function ($row) use ($i) {
                                        return floatval($row['values'][$i - 1]);
                                    }, $fileData['data']),
                                ) !!},
                                yaxis: {{ $i - 1 }}
                            },
                        @endfor
                    ],
                    xaxis: {
                        categories: {!! json_encode(array_column($fileData['data'], 'date')) !!},
                        type: 'datetime'
                    },

                    yaxis: [
                        @for ($i = 1; $i < count($fileData['header']); $i++)
                            {
                                labels: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },

                            },
                        @endfor
                    ],
                    stroke: {
                        curve: 'smooth'
                    },

                    grid: {
                        show: false,
                    }
                };

                var chart = new ApexCharts(document.querySelector("#graph-{{ $index }}"), options);
                chart.render();
            @endforeach
        });

        $(document).ready(function() {
            $('#operation').on('change', function() {
                if ($(this).val() === 'forecast') {
                    $('#forecast-modal').removeClass('hidden').hide().fadeIn(200);
                    $('#forecast-modal > div').removeClass('scale-95').addClass('scale-100');
                    $('#modal_file_id').val($('#file_id').val());
                }
            });

            // Open the 'Add More data' modal when 'Add more data' is selected
            $('#file_id').on('change', function() {
                if ($(this).val() === '') {
                    $('#ts-info-form').modal('show');
                }
            });

            $('#ts-info').click(function() {
                $('#ts-info-form').removeClass('hidden').hide().fadeIn(200);
                $('#ts-info-form > div').removeClass('scale-95').addClass('scale-100');
            });


        });

        $(document).ready(function() {
            let map;
            let marker;
            let lat;
            let lon;

            $('#ts-add-via-api-open-meteo-btn').click(function() {
                $('#ts-add-via-api-open-meteo-modal').removeClass('hidden').hide().fadeIn(200);
                $('#ts-add-via-api-open-meteo-modal > div').removeClass('scale-95').addClass('scale-100');
            });

            // Close modals
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.fixed').css('display', 'none');
            });

            // Close modals when clicking outside the modal content
            $('.fixed').click(function(e) {
                if ($(e.target).is(this)) {
                    $(this).fadeOut(200, function() {
                        $(this).addClass('hidden');
                    });
                }
            });

            // Initialize and show Google Map when "Open Map" button is clicked
            $('#get-from-maps-btn').on('click', function() {
                $('#map').css('display', 'block');

                // Initialize Google Map
                if (!map) {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {
                            lat: -34.397,
                            lng: 150.644
                        }, // Set default center
                        zoom: 8
                    });

                    // Add marker on click
                    map.addListener('click', function(e) {
                        placeMarkerAndPanTo(e.latLng, map);
                    });
                }
            });

            // Place a marker on map and pan to it
            function placeMarkerAndPanTo(latLng, map) {


                if (marker) {
                    marker.setPosition(latLng);
                } else {
                    marker = new google.maps.Marker({
                        position: latLng,
                        map: map
                    });
                }
                map.panTo(latLng);

                lat = latLng.lat();
                lon = latLng.lng();



                // Update the latitude and longitude in the form
                $('#lat').text(lat);
                $('#long').text(lon);
            }

            // Geolocation: Use current location
            $('#use-current-loc-btn').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {

                        lat = position.coords.latitude;
                        lon = position.coords.longitude;

                        console.log(lat);
                        console.log(lon);

                        if (map) {
                            // Update the map's center and place a marker
                            let currentLocation = new google.maps.LatLng(lat, lon);
                            map.setCenter(currentLocation);
                            placeMarkerAndPanTo(currentLocation, map);
                        }

                        $('#lat').text(lat);
                        $('#long').text(lon);

                    }, function(error) {
                        console.error("Error retrieving location: ", error);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

            // Listen for click event on the fetch button
            $('#fetch-data-open-meteo-btn').on('click', function(e) {
                e.preventDefault();

                // Extract latitude and longitude
                let lat = $('#lat').text().trim(); // Assuming lat and long values are stored here
                let long = $('#long').text().trim();

                // Get the selected checkboxes
                let selectedDaily = [];
                $('input[name="daily"]:checked').each(function() {
                    selectedDaily.push($(this).val());
                });

                // If no checkboxes are selected, alert the user
                if (selectedDaily.length === 0) {
                    alert('Please select at least one data field');
                    return;
                }

                // Build the API request URL
                let apiUrl = 'https://archive-api.open-meteo.com/v1/archive';
                let startDate = $('#start-date').val(); // Extracting start date
                let endDate = $('#end-date').val(); // Extracting end date

                let dailyParams = selectedDaily.join(',');

                let requestUrl =
                    `${apiUrl}?latitude=${lat}&longitude=${long}&start_date=${startDate}&end_date=${endDate}&daily=${dailyParams}&timezone=auto`;

                // Send the AJAX request
                $.ajax({
                    url: requestUrl,
                    type: 'GET',
                    success: function(response) {
                        // Handle the response from the server
                        console.log('Data fetched successfully:', response);

                        csvData = generateCSV(response, selectedDaily);
                        console.log("generated csv raw", csvData);

                        // Create a FormData object to send the CSV and other data
                        const blob = new Blob([csvData], {
                            type: 'text/csv'
                        });

                        const formData = new FormData();
                        formData.append('csv_file', blob, 'data.csv');

                        let currentDate = new Date().toISOString().split('T')[0];
                        console.log(currentDate);


                        let type;
                        let freq = 'D';
                        let description =
                            `time sereis data involving ${selectedDaily.join(',')}`;
                        let filename = `${selectedDaily.join('-')}-${currentDate}.csv`;

                        if (selectedDaily.length == 1) {
                            type = "univariate";
                        } else {
                            type = "multivariate";
                        }

                        formData.append('type', type);
                        formData.append('freq', freq);
                        formData.append('description', description);
                        formData.append('filename', filename);
                        formData.append('source', 'open-meteo');

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
                                window.location.href = response.redirect_url;
                            },
                            error: function(xhr, status, error) {
                                console.error('Error saving data:', error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        alert('Failed to fetch data. Please try again.');
                    }
                });


                function convertDate(inputDate) {
                    // Parse the input date string into a Date object
                    const parsedDate = new Date(inputDate);

                    // Format the date as MM/dd/yyyy (full year format)
                    const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
                    return formattedDate;
                }


                function generateCSV(data, selectedVariables) {


                    // Extract time array from the response
                    const timeArray = data.daily.time;

                    // Initialize CSV content with headers
                    let csvContent = 'time,' + selectedVariables.join(',') + '\n';

                    // Loop through each day (time array)
                    for (let i = 0; i < timeArray.length; i++) {
                        // Start each row with the time (date)
                        // let row = [timeArray[i]];
                        let row = [convertDate(timeArray[i])];

                        // For each selected variable, add the corresponding value to the row
                        selectedVariables.forEach(variable => {

                            row.push(data.daily[variable][i]);


                        });

                        // Add the row to CSV content
                        csvContent += row.join(',') + '\n';
                    }

                    return csvContent;
                }



            });

        });

        $(document).ready(function() {

            // Initialize Flatpickr with yy-mm-dd format

            $('#ts-add-via-api-stocks-btn').click(function() {
                $('#ts-add-via-api-stocks-modal').removeClass('hidden').hide().fadeIn(200);
                $('#ts-add-via-api-stocks-modal > div').removeClass('scale-95').addClass('scale-100');
            });

            // Close modals
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.fixed').css('display', 'none');
            });

            // Close modals when clicking outside the modal content
            $('.fixed').click(function(e) {
                if ($(e.target).is(this)) {
                    $(this).fadeOut(200, function() {
                        $(this).addClass('hidden');
                    });
                }
            });


            $('#fetch-data-stocks').click(function(e) {
                e.preventDefault();

                // Fetch the values from the inputs
                const stockSymbol = $('#stock-selection').val(); // Fetch stock symbol input
                const startDate = $('#start-date-stocks').val(); // Extracting start date
                const endDate = $('#end-date-stocks').val(); // Extracting end date
                const interval = $('#interval').val(); // Fetch interval dropdown

                // Validation logic: Check if any field is empty
                if (!stockSymbol) {
                    alert("Stock symbol is required!");
                    $('#stock-selection').focus(); // Focus the empty input
                    return;
                }

                if (!startDate) {
                    alert("Start date is required!");
                    $('#start-date-stocks').focus();
                    return;
                }

                if (!endDate) {
                    alert("End date is required!");
                    $('#end-date-stocks').focus();
                    return;
                }

                if (!interval) {
                    alert("Interval is required!");
                    $('#interval').focus();
                    return;
                }

                // build the http request. 
                let requestURLStocks =
                    `https://api.twelvedata.com/time_series?apikey=e7bd90a9e6b24f85aec8b6d9a0f07b10&interval=${interval}&end_date=${endDate}&start_date=${startDate}&symbol=${stockSymbol}&format=JSON`;

                $.ajax({
                    type: "GET",
                    url: requestURLStocks,

                    success: function(response) {
                        console.log('success', response);
                        let csvData = extractToCSV(response);
                        console.log(csvData);
                        const blob = new Blob([csvData], {
                            type: 'text/csv'
                        });

                        const formData = new FormData();
                        formData.append('csv_file', blob, 'data.csv');

                        let currentDate = new Date().toISOString().split('T')[0];
                        let type = "multivariate";
                        let freq;;
                        let description =
                            `Time sereis data involving the ${stockSymbol} stocks between ${startDate} and ${endDate}. `;
                        let filename = `Stock-${stockSymbol}-${currentDate}.csv`;


                        formData.append('type', type);
                        formData.append('freq', freq);
                        formData.append('description', description);
                        formData.append('filename', filename);
                        formData.append('source', 'stocks');

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
                                window.location.href = response.redirect_url;
                            },
                            error: function(xhr, status, error) {
                                console.error('Error saving data:', error);
                            }
                        });


                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        alert('Failed to fetch data. Please try again.');
                    }
                });

            });

            // function extractToCSV(response) {
            //     // Check if response has values array
            //     if (!response || !response.values || response.values.length === 0) {
            //         console.error("No values found in the response.");
            //         return;
            //     }

            //     // Extract data from the values array
            //     const values = response.values;

            //     // Define the CSV headers
            //     const headers = ['datetime', 'open', 'high', 'low', 'close', 'volume'];

            //     // Create an array for CSV rows starting with the headers
            //     let csvContent = headers.join(",") + "\n";

            //     // Loop through the values and extract the fields to append to the CSV content
            //     values.forEach(item => {
            //         const row = [
            //             convertDate(item.datetime),
            //             item.open,
            //             item.high,
            //             item.low,
            //             item.close,
            //             item.volume
            //         ].join(",");
            //         csvContent += row + "\n";
            //     });


            //     return csvContent;
            // }
            function extractToCSV(response) {
                // Check if response has values array
                if (!response || !response.values || response.values.length === 0) {
                    console.error("No values found in the response.");
                    return;
                }

                // Extract data from the values array
                const values = response.values;

                // Define the CSV headers
                const headers = ['datetime', 'open', 'high', 'low', 'close', 'volume'];

                // Create an array for CSV rows starting with the headers
                let csvContent = headers.join(",") + "\n";

                // Sort the values in ascending order based on datetime
                values.sort((a, b) => new Date(a.datetime) - new Date(b.datetime));

                // Loop through the sorted values and extract the fields to append to the CSV content
                values.forEach(item => {
                    const row = [
                        convertDate(item.datetime), // Assuming this function formats the date
                        item.open,
                        item.high,
                        item.low,
                        item.close,
                        item.volume
                    ].join(",");
                    csvContent += row + "\n";
                });

                return csvContent;
            }


            function convertDate(inputDate) {
                // Parse the input date string into a Date object
                const parsedDate = new Date(inputDate);

                // Format the date as MM/dd/yyyy (full year format)
                const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
                return formattedDate;
            }

        });
    </script>
@endsection
