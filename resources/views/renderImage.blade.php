<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApexCharts Example</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        #chart {
            max-width: 650px;
            margin: 35px auto;
        }
    </style>
</head>

<body>

    <div id="chart"></div>
    <button id="download">Download Chart as Image</button>

    {{-- <script>
        // Create the chart
        const options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                name: 'Sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Download chart as an image
        document.getElementById('download').addEventListener('click', () => {
            chart.dataURI().then((uri) => {
                const link = document.createElement('a');
                link.href = uri.imgURI; // Get the image URI
                link.download = 'apexchart-image.png'; // Set the file name
                link.click(); // Trigger the download
            });
        });
    </script> --}}
    
    <script>
        // Create the chart
        const options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                name: 'Sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Download chart as an image
        document.getElementById('download').addEventListener('click', () => {
            chart.dataURI().then((uri) => {
                // Prepare the image data to send to the server
                const imageData = uri.imgURI; // Get the image URI

                // Send the image to the server
                fetch('/save-chart-image', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        body: JSON.stringify({
                            image: imageData
                        }) // Send the image data
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Image saved successfully:', data);
                        alert('Image saved successfully!');
                    })
                    .catch((error) => {
                        console.error('Error saving image:', error);
                        alert('Error saving image.');
                    });
            });
        });
    </script>

</body>

</html>
