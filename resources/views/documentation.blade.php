@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-48 py-8 bg-white">

        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-gray-800 mb-10 text-center">System Documentation</h1>

        <!-- System Functions -->
        <section class="mb-12 border-b pb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">System Functions</h2>
            <p class="text-gray-600 mb-4">
                This application provides comprehensive tools for automated time series analysis, supporting both univariate
                and multivariate datasets. The system identifies and analyzes time series components, including trend and
                seasonality, and generates accurate forecasts.
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1">
                <li><strong>Trend Analysis:</strong> Identifies the underlying direction of the data over time, disregarding
                    cyclical or seasonal variations.</li>
                <li><strong>Seasonality Analysis:</strong> Detects recurring patterns in data at specific intervals, like
                    weekly or yearly cycles.</li>
                <li><strong>Forecasting:</strong> Predicts future data points based on historical data, utilizing advanced
                    modeling techniques.</li>
            </ul>
        </section>

        <!-- Allowed Data Formats -->
        <section class="mb-12 border-b pb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Allowed Data Formats</h2>
            <p class="text-gray-600 mb-4">
                The application accepts CSV and Excel files formatted for univariate or multivariate time series data.
            </p>

            <!-- Univariate Data Sample -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Univariate Data Format</h3>
                <p class="text-gray-600 mb-2">
                    For univariate analysis, data should include a date index and a single column of values representing one
                    variable.
                </p>
                <div class="bg-gray-50 p-3 border rounded-md">
                    <pre class="text-sm text-gray-800 font-mono whitespace-pre-wrap select-all">
Date,Value
2023-01-01,150
2023-01-02,155
2023-01-03,158
                    </pre>
                </div>
            </div>

            <!-- Multivariate Data Sample -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Multivariate Data Format</h3>
                <p class="text-gray-600 mb-2">
                    For multivariate analysis, data should include a date index and multiple columns representing various
                    variables.
                </p>
                <div class="bg-gray-50 p-3 border rounded-md">
                    <pre class="text-sm text-gray-800 font-mono whitespace-pre-wrap select-all">
Date,Variable1,Variable2,Variable3
2023-01-01,150,200,250
2023-01-02,155,205,255
2023-01-03,158,210,260
                    </pre>
                </div>
            </div>

            <p class="text-gray-600 mt-2">
                Ensure the date column is in a standard date format (e.g., YYYY-MM-DD) and all variables contain numeric
                values.
            </p>
        </section>

        <!-- Data Analysis Details -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Data Analysis Details</h2>


            <!-- Trend Analysis -->
            <div class="mb-6 pl-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Trend Analysis</h3>
                <p class="text-gray-600 pl-4">
                    In trend analysis, the system seeks to identify the long-term direction or pattern in the data, separate
                    from short-term fluctuations and seasonality. This is done using the <strong>Prophet</strong> package,
                    which models each time series individually. By decomposing the time series, Prophet isolates the trend
                    component, revealing whether the data indicates an overall increase, decrease, or stability over time.
                </p>
                <p class="text-gray-600 pl-4">
                    The process involves fitting a non-linear growth model to each time series and iteratively refining the
                    model to capture significant changes. As a result, users gain insights into long-term trends, helping
                    them understand the general trajectory of their data, which can support strategic decision-making.
                </p>

                <!-- Univariate Trend Chart -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Univariate Trend</h4>
                    <div id="univariateTrendChart" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow"></div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The univariate trend chart shows a smoothed line representing the overall trend for a single
                        variable over time. In this example, the trend reflects a gradual increase, suggesting a positive
                        long-term trajectory in the data.
                    </p>
                </div>

                <!-- Multivariate Trend Chart -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Multivariate Trend</h4>
                    <div id="multivariateTrendChart" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow"></div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The multivariate trend chart illustrates the trends for multiple variables over time, with each line
                        representing a different variable. Separate scales are used for each variable on the left axis,
                        allowing for a clear comparison of how each evolves over time.
                    </p>
                </div>
            </div>

            <!-- ApexCharts Script -->
            <script>
                // Univariate Trend Chart
                var univariateTrendOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Value',
                        data: [100, 105, 110, 115, 120, 125, 130, 135, 140, 145, 150] // Sample smoothed univariate data
                    }],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov']
                    },
                    yaxis: {
                        title: {
                            text: 'Value',
                            style: {
                                color: '#4F46E5'
                            }
                        },
                        labels: {
                            style: {
                                colors: '#4F46E5'
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var univariateTrendChart = new ApexCharts(document.querySelector("#univariateTrendChart"), univariateTrendOptions);
                univariateTrendChart.render();

                // Multivariate Trend Chart
                var multivariateTrendOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Variable 1',
                            data: [100, 102, 104, 108, 112, 116, 120, 125, 130, 135, 140]
                        },
                        {
                            name: 'Variable 2',
                            data: [100, 105, 110, 115, 120, 125, 130, 135, 140, 145, 150]
                        },
                        {
                            name: 'Variable 3',
                            data: [120, 122, 124, 126, 128, 130, 132, 134, 138, 140, 142]
                        }
                    ],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov']
                    },
                    yaxis: [{
                            title: {
                                text: 'Variable 1',
                                style: {
                                    color: '#4F46E5'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#4F46E5'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 2',
                                style: {
                                    color: '#0EA5E9'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#0EA5E9'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 3',
                                style: {
                                    color: '#EF4444'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#EF4444'
                                }
                            }
                        }
                    ],
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5', '#0EA5E9', '#EF4444'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var multivariateTrendChart = new ApexCharts(document.querySelector("#multivariateTrendChart"),
                    multivariateTrendOptions);
                multivariateTrendChart.render();
            </script>

            <!-- Seasonality Analysis -->
            <div class="mb-6 pl-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Seasonality Analysis</h3>
                <p class="text-gray-600 pl-4">
                    Seasonality analysis uncovers recurring patterns within specific intervals in time series data. Using
                    the <strong>Prophet</strong> package, the system captures both weekly and yearly seasonal components,
                    identifying periodic fluctuations that may correspond to cyclical factors such as seasonal demand or
                    weekly usage patterns.
                </p>
                <p class="text-gray-600 pl-4">
                    The system applies Prophet's Fourier series approach to model seasonal patterns, adjusting for both
                    weekly and yearly cycles. The charts below illustrate the deviation from the average (zero line) in both
                    positive and negative directions, highlighting recurring fluctuations within weekly and yearly
                    intervals.
                </p>

                <!-- Univariate Seasonality Analysis -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Univariate Seasonality</h4>

                    <!-- Weekly Seasonality -->
                    <div id="univariateWeeklySeasonality" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4">
                    </div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The weekly seasonality chart for univariate time series data shows deviations from the average value
                        across days of the week. This pattern helps identify consistent increases or decreases on specific
                        days, useful for detecting weekly cyclical trends.
                    </p>

                    <!-- Yearly Seasonality -->
                    <div id="univariateYearlySeasonality" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4">
                    </div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The yearly seasonality chart for univariate time series data shows deviations across the months,
                        illustrating broader seasonal trends throughout the year, such as higher activity in certain
                        seasons.
                    </p>
                </div>

                <!-- Multivariate Seasonality Analysis -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Multivariate Seasonality</h4>

                    <!-- Weekly Seasonality -->
                    <div id="multivariateWeeklySeasonality" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4">
                    </div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The multivariate weekly seasonality chart displays weekly patterns for each variable, with each line
                        representing deviations from the average (zero) for each day. This is helpful in understanding how
                        different variables fluctuate within a weekly cycle.
                    </p>

                    <!-- Yearly Seasonality -->
                    <div id="multivariateYearlySeasonality" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4">
                    </div>
                    <p class="text-gray-600 pl-4 mt-2">
                        The multivariate yearly seasonality chart illustrates monthly patterns for each variable, showing
                        how each variable deviates from its average throughout the year.
                    </p>
                </div>
            </div>

            <!-- ApexCharts Script -->
            <script>
                // Univariate Weekly Seasonality Chart
                var univariateWeeklyOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Deviation',
                        data: [5, 3, 0, -2, -4, 0, 3]
                    }], // Sample weekly deviation data
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yaxis: {
                        title: {
                            text: 'Variable1',
                            style: {
                                color: '#4F46E5'
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var univariateWeeklyChart = new ApexCharts(document.querySelector("#univariateWeeklySeasonality"),
                    univariateWeeklyOptions);
                univariateWeeklyChart.render();

                // Univariate Yearly Seasonality Chart
                var univariateYearlyOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Deviation',
                        data: [2, 4, 6, 4, 0, -3, -5, -4, -2, 0, 3, 5]
                    }], // Sample yearly deviation data
                    xaxis: {
                        categories: ['01/01', '02/01', '03/01', '04/01', '05/01', '06/01', '07/01', '08/01', '09/01', '10/01',
                            '11/01', '12/01'
                        ]
                    },
                    yaxis: {
                        title: {
                            text: 'Variable1',
                            style: {
                                color: '#4F46E5'
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var univariateYearlyChart = new ApexCharts(document.querySelector("#univariateYearlySeasonality"),
                    univariateYearlyOptions);
                univariateYearlyChart.render();

                // Multivariate Weekly Seasonality Chart
                var multivariateWeeklyOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Variable 1',
                            data: [5, 3, 0, -2, -4, 0, 3]
                        },
                        {
                            name: 'Variable 2',
                            data: [3, 2, 1, -1, -3, -1, 2]
                        },
                        {
                            name: 'Variable 3',
                            data: [1, -1, -2, 0, 1, 2, 3]
                        }
                    ], // Sample multivariate weekly data
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yaxis: [{
                            title: {
                                text: 'Variable 1',
                                style: {
                                    color: '#4F46E5'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#4F46E5'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 2',
                                style: {
                                    color: '#0EA5E9'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#0EA5E9'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 3',
                                style: {
                                    color: '#EF4444'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#EF4444'
                                }
                            }
                        }
                    ],
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5', '#0EA5E9', '#EF4444'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var multivariateWeeklyChart = new ApexCharts(document.querySelector("#multivariateWeeklySeasonality"),
                    multivariateWeeklyOptions);
                multivariateWeeklyChart.render();

                // Multivariate Yearly Seasonality Chart
                var multivariateYearlyOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Variable 1',
                            data: [2, 4, 6, 4, 0, -3, -5, -4, -2, 0, 3, 5]
                        },
                        {
                            name: 'Variable 2',
                            data: [1, 2, 3, 2, 0, -1, -3, -2, -1, 1, 2, 4]
                        },
                        {
                            name: 'Variable 3',
                            data: [0, 1, 2, 1, -1, -2, -4, -3, -1, 0, 2, 3]
                        }
                    ], // Sample multivariate yearly data
                    xaxis: {
                        categories: ['01/01', '02/01', '03/01', '04/01', '05/01', '06/01', '07/01', '08/01', '09/01', '10/01',
                            '11/01', '12/01'
                        ]
                    },
                    yaxis: [{
                            title: {
                                text: 'Variable 1',
                                style: {
                                    color: '#4F46E5'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#4F46E5'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 2',
                                style: {
                                    color: '#0EA5E9'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#0EA5E9'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 3',
                                style: {
                                    color: '#EF4444'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#EF4444'
                                }
                            }
                        }
                    ],
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#4F46E5', '#0EA5E9', '#EF4444'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var multivariateYearlyChart = new ApexCharts(document.querySelector("#multivariateYearlySeasonality"),
                    multivariateYearlyOptions);
                multivariateYearlyChart.render();
            </script>




            <!-- Forecasting -->
            <div class="mb-6 pl-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Forecasting</h3>
                <p class="text-gray-600 pl-4">
                    The forecasting module predicts future values based on historical data by leveraging both trend and
                    seasonal components. The system applies tailored approaches for univariate and multivariate time series
                    forecasts, transforming each model into a predictive one using the <strong>Skforecast</strong> package.
                    The Skforecast library enables these models to perform effective forecasting by adapting their
                    structures to handle future time points.
                </p>

                <!-- Univariate Forecasting -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Univariate Forecasting</h4>
                    <p class="text-gray-600 pl-4">
                        For univariate time series, the system employs a <strong>hybrid stacking regression model</strong>
                        to enhance forecast accuracy. This ensemble model integrates <em>Elastic Net</em>, <em>Decision
                            Tree</em>, and <em>Lasso</em> as base regressors, with a <em>Ridge</em> regression serving as
                        the meta-model. Each base model extracts unique aspects of the time series data, and the Ridge
                        regressor consolidates these outputs for a refined prediction.
                    </p>
                    <p class="text-gray-600 pl-4">
                        Through extensive testing, this hybrid model demonstrates a low error rate of approximately 3%,
                        providing reliable forecasts for applications requiring high accuracy, such as sales and demand
                        forecasting. The following graph shows the original historical data alongside the out-of-sample
                        forecasts.
                    </p>
                    <div id="univariateForecasting" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4"></div>
                </div>

                <!-- Multivariate Forecasting -->
                <div class="mt-4 pl-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Multivariate Forecasting</h4>
                    <p class="text-gray-600 pl-4">
                        In multivariate time series forecasting, a <strong>Decision Tree</strong> model is used to predict
                        the target variable while accounting for multiple other influencing variables. The Skforecast
                        package enables this model to analyze interdependencies between variables over time, making it
                        effective for situations where multiple indicators jointly affect outcomes, such as forecasting
                        economic metrics or multi-factor financial data.
                    </p>
                    <p class="text-gray-600 pl-4">
                        The chart below displays the forecast for the target variable in a multivariate setting, with the
                        original data values and predicted future values shown. Additionally, a separate graph illustrates
                        how the three key variables, including the target variable, influence the forecast. This approach
                        captures complex interactions and enhances forecast precision by using all relevant variables as
                        predictors.
                    </p>
                    <!-- Forecasted Target Variable -->
                    <div id="multivariateForecasting" class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4"></div>
                    <!-- Influencing Variables -->
                    <div id="multivariateInfluencingVariables"
                        class="apexcharts-canvas bg-gray-50 p-4 rounded-lg shadow mt-4"></div>
                </div>
            </div>

            <!-- ApexCharts Script -->
            <script>
                // Univariate Forecasting Chart
                var univariateForecastingOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Variable1',
                            data: [100, 102, 104, 107, 110, 112, 115, 124, 120, null, null, null]
                        }, // Historical data
                        {
                            name: 'Forecast on Variable 1',
                            data: [null, null, null, null, null, null, null, null, null, 120, 126, 124]
                        } // Forecasted data
                    ],
                    xaxis: {
                        categories: ['01/01', '01/02', '01/03', '01/04', '01/05', '01/06', '01/07', '01/08', '01/09', '01/10',
                            '01/11', '01/12'
                        ],
                        title: {
                            text: 'Date'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Variable1',
                            style: {
                                color: '#4F46E5'
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [2, 2]
                    },
                    colors: ['#4F46E5', '#0EA5E9'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var univariateForecastingChart = new ApexCharts(document.querySelector("#univariateForecasting"),
                    univariateForecastingOptions);
                univariateForecastingChart.render();

                // Multivariate Forecasting Chart
                var multivariateForecastingOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Target Variable',
                            data: [100, 105, 110, 115, 118, 121, 125, 127, 130, null, null, null]
                        }, // Historical data
                        {
                            name: 'Forecast on Target Variable',
                            data: [null, null, null, null, null, null, null, null, null, 132, 135, 129]
                        } // Forecasted data
                    ],
                    xaxis: {
                        categories: ['01/01', '01/02', '01/03', '01/04', '01/05', '01/06', '01/07', '01/08', '01/09', '01/10',
                            '01/11', '01/12'
                        ],
                        title: {
                            text: 'Date'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Target Variable',
                            style: {
                                color: '#4F46E5'
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [3, 2]
                    },
                    colors: ['#4F46E5', '#F59E0B'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var multivariateForecastingChart = new ApexCharts(document.querySelector("#multivariateForecasting"),
                    multivariateForecastingOptions);
                multivariateForecastingChart.render();

                // Multivariate Influencing Variables Chart
                var multivariateInfluencingVariablesOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Target Variable',
                            data: [100, 105, 110, 115, 118, 121, 125, 127, 130, ]
                        }, // Target variable data
                        {
                            name: 'Variable1',
                            data: [102, 107, 111, 116, 119, 123, 126, 129, 132]
                        }, // Variable 1
                        {
                            name: 'Variable2',
                            data: [97, 104, 107, 112, 116, 118, 121, 124, 127]
                        }, // Variable 2
                        {
                            name: 'Variable3',
                            data: [105, 110, 115, 120, 123, 126, 130, 133, 136]
                        } // Variable 3
                    ],
                    xaxis: {
                        categories: ['01/01', '01/02', '01/03', '01/04', '01/05', '01/06', '01/07', '01/08', '01/09', '01/10',

                        ],
                        title: {
                            text: 'Date'
                        }
                    },
                    yaxis: [{
                            title: {
                                text: 'Target Variable',
                                style: {
                                    color: '#4F46E5'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#4F46E5'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 1',
                                style: {
                                    color: '#4F46E5'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#4F46E5'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 2',
                                style: {
                                    color: '#0EA5E9'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#0EA5E9'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Variable 3',
                                style: {
                                    color: '#EF4444'
                                }
                            },
                            opposite: false,
                            labels: {
                                style: {
                                    colors: '#EF4444',
                                }
                            }
                        }
                    ],
                    stroke: {
                        curve: 'smooth',
                        width: [3, 1, 1, 1]
                    },
                    colors: ['#4F46E5', '#0EA5E9', '#F59E0B', '#10B981'],
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        show: false
                    },
                };
                var multivariateInfluencingVariablesChart = new ApexCharts(document.querySelector(
                    "#multivariateInfluencingVariables"), multivariateInfluencingVariablesOptions);
                multivariateInfluencingVariablesChart.render();
            </script>


        </section>

    </div>
@endsection
