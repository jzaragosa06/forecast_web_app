{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowchart using Mermaid.js with Tailwind CSS</title>
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true
        });
    </script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Outermost Container -->
    <div class="container mx-auto mt-10 p-4">
        <!-- Row -->
        <div class="flex flex-wrap justify-center">
            <!-- Column -->
            <div class="w-full lg:w-8/12 bg-white shadow-md rounded-lg p-6">
                <!-- Another Row (Nested) -->
                <div class="flex justify-center">
                    <!-- Inner Column -->
                    <div class="w-full">
                        <h2 class="text-2xl font-bold text-center mb-4">Flowchart using Mermaid.js</h2>
                        <!-- Mermaid Flowchart Container -->
                        <div class="mermaid border-2 border-gray-300 rounded-lg p-6">
                            graph TD;
                            Dataset --> |Train| Training_Dataset;
                            Dataset --> |Test| Test_Dataset;
                            Training_Dataset --> Model;
                            Test_Dataset --> Evaluate;
                            Model --> Evaluate;
                            Evaluate --> |Error Acceptable?| Decision;
                            Decision --> |Yes| Forecast;
                            Decision --> |No| Retrain_Model;
                            Retrain_Model --> Model;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html> --}}



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowchart using Mermaid.js with Tailwind CSS</title>
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true,
            theme: "default", // You can change the theme
            themeVariables: {
                primaryColor: '#ffcc00',
                edgeLabelBackground: '#ffffff'
            },
            flowchart: {
                useMaxWidth: false, // Allow scaling
            },
        });
    </script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .mermaid {
            transform: scale(0.8);
            /* Adjust scale here */
            transform-origin: top left;
            /* Make scaling behave properly */
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-wrap mt-4">
        <div class="w-2/3 p-4">
            <div class="bg-white shadow-md rounded-lg p-5">
                <table id="forecastTable" class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Date</th>
                            <th class="border px-4 py-2">Forecasted Value</th>
                            <th class="border px-4 py-2">True Value</th>
                            <th class="border px-4 py-2">Error</th>
                        </tr>
                    </thead>
                    <tbody id="forecastTableBody-test">
                        <tr>
                            <td class="border px-4 py-2">2024-01-01</td>
                            <td class="border px-4 py-2">100</td>
                            <td class="border px-4 py-2">90</td>
                            <td class="border px-4 py-2">10</td>
                        </tr>
                        <!-- More dynamically rendered rows can be added here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mermaid Flowchart Container -->
        <div class="w-1/3 p-4">
            <div class="mermaid">
                graph TD;
                Dataset --> |Train| Training_Dataset;
                Dataset --> |Test| Test_Dataset;
                Training_Dataset --> Model;
                Test_Dataset --> Evaluate;
                Model --> Evaluate;
                Evaluate --> |Error Acceptable?| Decision;
                Decision --> |Yes| Forecast;
                Decision --> |No| Retrain_Model;
                Retrain_Model --> Model;
            </div>
        </div>
    </div>
</body>

</html>
