<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML to PDF Example</title>
    <!-- jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- html2canvas CDN (for capturing the chart) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Chart.js CDN (for creating the graph) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h1>Time Series Analysis</h1>
    <p>This is a sample time series analysis chart. The data represents some arbitrary values over time.</p>

    <!-- Line graph container -->
    <canvas id="lineChart" width="400" height="200"></canvas>

    <!-- Button to download PDF -->
    <button onclick="downloadPDF()">Download PDF</button>

    <script>
        // Initialize the line chart with some sample data
        const ctx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sample Data',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: 'blue',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Values'
                        }
                    }
                }
            }
        });

        // Function to download the HTML content as PDF
        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            // Capture the HTML content as canvas using html2canvas
            html2canvas(document.body).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 190; // width in mm
                const pageHeight = 297; // A4 page height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let position = 10; // starting position for content

                // Add image to the PDF
                pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                pdf.save("sample.pdf");
            });
        }
    </script>
</body>

</html>
