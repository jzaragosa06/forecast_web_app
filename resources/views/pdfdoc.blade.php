{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generation with jsPDF</title>
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jsPDF-AutoTable plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <button onclick="generatePDF()">Download PDF</button>
    <canvas id="lineChart" width="600" height="400" style="display:none;"></canvas>

    <script>
        async function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            // Header background
            pdf.setFillColor(230, 230, 230);
            pdf.rect(0, 0, pdf.internal.pageSize.width, 30, 'F');

            // Load logo image
            const logoImage = new Image();
            logoImage.src = "{{ asset('storage/idiot-guid-imgs/logo.png') }}"; // Replace with your logo URL
            logoImage.onload = async () => {
                const logoWidth = 20;
                const logoHeight = 20;
                pdf.addImage(logoImage, 'PNG', 10, 5, logoWidth, logoHeight);

                // Title and subtitle in header
                pdf.setFontSize(22);
                pdf.setFont("helvetica", "bold");
                pdf.setTextColor(0, 0, 0);
                pdf.text("DataForesight", 40, 20);
                pdf.setFontSize(12);
                pdf.setFont("helvetica", "normal");
                pdf.text("The following describes the result of analysis.", 40, 25);

                // Data section background and text
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 35, pdf.internal.pageSize.width - 20, 20, 'F');
                pdf.setFontSize(10);
                pdf.setFont("helvetica", "normal");
                pdf.setTextColor(0, 0, 0);
                pdf.text(
                    "Background of the data used for analysis: Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
                    12, 42, {
                        maxWidth: pdf.internal.pageSize.width - 24
                    }
                );

                // Generate line chart and add to PDF
                const canvas = document.getElementById("lineChart");
                const originalWidth = canvas.width;
                const originalHeight = canvas.height;
                canvas.width = originalWidth * 2;
                canvas.height = originalHeight * 2;
                const ctx = canvas.getContext("2d");
                ctx.scale(2, 2);

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                                label: 'Sample Data 1',
                                data: [10, 20, 15, 30, 25, 35, 40],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                fill: false, // Disable area under the line
                                yAxisID: 'y-axis-1', // Link this dataset to the first y-axis
                            },
                            {
                                label: 'Sample Data 2',
                                data: [300, 250, 275, 200, 225, 150, 100],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                fill: false, // Disable area under the line
                                yAxisID: 'y-axis-2', // Link this dataset to the second y-axis
                            }
                        ]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            },
                            'y-axis-1': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Sample Data 1'
                                },
                                beginAtZero: true
                            },
                            'y-axis-2': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Sample Data 2'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                await new Promise(resolve => setTimeout(resolve, 100));
                const imageData = canvas.toDataURL("image/png");
                canvas.width = originalWidth;
                canvas.height = originalHeight;
                ctx.scale(1, 1);

                // Position chart image below data section
                pdf.addImage(imageData, 'PNG', 10, 60, 180, 80);
                //  Notes sections
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.text("Notes", 10, 150);

                // Data section background and text
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 35, pdf.internal.pageSize.width - 20, 20, 'F');
                pdf.setFontSize(10);
                pdf.setFont("helvetica", "normal");
                pdf.setTextColor(0, 0, 0);
                pdf.text(
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
                    12, 42, {
                        maxWidth: pdf.internal.pageSize.width - 24
                    }
                );

                pdf.addPage();
                // Key Details 
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.text("Key Details", 10, 150);

                // Data section background and text
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 35, pdf.internal.pageSize.width - 20, 20, 'F');
                pdf.setFontSize(10);
                pdf.setFont("helvetica", "normal");
                pdf.setTextColor(0, 0, 0);
                pdf.text(
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
                    12, 42, {
                        maxWidth: pdf.internal.pageSize.width - 24
                    }
                );




                pdf.addPage();

                // Table data
                const tableData = [
                    ["Month", "Forecast Value"],
                    ["August", "350"],
                    ["September", "360"],
                    ["October", "370"],
                    ["November", "380"],
                    ["December", "390"]
                ];

                // Set header and generate table
                pdf.setFontSize(16);
                pdf.setFont("helvetica", "bold");
                pdf.text("Forecast", 10, 20);

                // Using autoTable plugin to add table
                pdf.autoTable({
                    startY: 30,
                    head: [tableData[0]], // Header row
                    body: tableData.slice(1), // Table data
                    theme: 'grid',
                    headStyles: {
                        fillColor: [230, 230, 230]
                    },
                    styles: {
                        halign: 'center'
                    }
                });

                pdf.save("report.pdf");
            };
        }
    </script>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generation with jsPDF</title>
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jsPDF-AutoTable plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <button onclick="generatePDF()">Download PDF</button>
    <canvas id="lineChart" width="600" height="400" style="display:none;"></canvas>
    
    <script>
        async function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            // Header background
            pdf.setFillColor(230, 230, 230);
            pdf.rect(0, 0, pdf.internal.pageSize.width, 30, 'F');

            // Load logo image
            const logoImage = new Image();
            logoImage.src = "{{ asset('storage/idiot-guid-imgs/logo.png') }}"; // Replace with your logo URL
            logoImage.onload = async () => {
                const logoWidth = 20;
                const logoHeight = 20;
                pdf.addImage(logoImage, 'PNG', 10, 5, logoWidth, logoHeight);

                // Title and subtitle in header
                pdf.setFontSize(22);
                pdf.setFont("helvetica", "bold");
                pdf.setTextColor(0, 0, 0);
                pdf.text("DataForesight", 40, 20);
                pdf.setFontSize(12);
                pdf.setFont("helvetica", "normal");
                pdf.text("The following describes the result of analysis.", 40, 25);

                // Data section background and text
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 35, pdf.internal.pageSize.width - 20, 20, 'F');
                pdf.setFontSize(10);
                pdf.setFont("helvetica", "normal");
                pdf.setTextColor(0, 0, 0);
                pdf.text(
                    "Background of the data used for analysis: Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
                    12, 42, {
                        maxWidth: pdf.internal.pageSize.width - 24
                    }
                );

                // Generate line chart and add to PDF
                const canvas = document.getElementById("lineChart");
                const originalWidth = canvas.width;
                const originalHeight = canvas.height;
                canvas.width = originalWidth * 2;
                canvas.height = originalHeight * 2;
                const ctx = canvas.getContext("2d");
                ctx.scale(2, 2);

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                                label: 'Sample Data 1',
                                data: [10, 20, 15, 30, 25, 35, 40],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                fill: false,
                                yAxisID: 'y-axis-1',
                            },
                            {
                                label: 'Sample Data 2',
                                data: [300, 250, 275, 200, 225, 150, 100],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                fill: false,
                                yAxisID: 'y-axis-2',
                            }
                        ]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            },
                            'y-axis-1': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Sample Data 1'
                                },
                                beginAtZero: true
                            },
                            'y-axis-2': {
                                type: 'linear',
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Sample Data 2'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });


                await new Promise(resolve => setTimeout(resolve, 100));
                const imageData = canvas.toDataURL("image/png");
                canvas.width = originalWidth;
                canvas.height = originalHeight;
                ctx.scale(1, 1);

                // Position chart image below data section
                pdf.addImage(imageData, 'PNG', 10, 60, 180, 80);

                // Notes section with light gray background
                pdf.setFillColor(240, 240, 240); // Light gray color
                pdf.rect(10, 145, pdf.internal.pageSize.width - 20, 20,
                    'F'); // Background rectangle for the title and content

                // Title for Notes
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.setTextColor(0, 0, 0);
                pdf.text("Notes", 10, 150);

                // Notes content
                pdf.setFont("helvetica", "normal");
                pdf.setFontSize(10);
                pdf.text("Lorem ipsum dolor sit amet, consectetur adipiscing elit...", 10, 160, {
                    maxWidth: pdf.internal.pageSize.width - 20
                });


                // Add a new page for Key Details
                pdf.addPage();
                pdf.setFillColor(240, 240, 240); // Light gray color
                pdf.rect(10, 20, pdf.internal.pageSize.width - 20, 20,
                    'F'); // Background rectangle for the title and content
                // Title for Notes
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.setTextColor(0, 0, 0);
                pdf.text("Key Details", 10, 25);

                // Key details content
                pdf.setFont("helvetica", "normal");
                pdf.setFontSize(10);
                pdf.text("Lorem ipsum dolor sit amet, consectetur adipiscing elit...", 10, 35, {
                    maxWidth: pdf.internal.pageSize.width - 20
                });


                // Add a new page for the Forecast table
                pdf.addPage();
                pdf.setFontSize(16);
                pdf.setFont("helvetica", "bold");
                pdf.text("Forecast", 10, 20);

                // Using autoTable plugin to add table
                const tableData = [
                    ["Month", "Forecast Value"],
                    ["August", "350"],
                    ["September", "360"],
                    ["October", "370"],
                    ["November", "380"],
                    ["December", "390"]
                ];

                pdf.autoTable({
                    startY: 30,
                    head: [tableData[0]],
                    body: tableData.slice(1),
                    theme: 'grid',
                    headStyles: {
                        fillColor: [230, 230, 230]
                    },
                    styles: {
                        halign: 'center'
                    }
                });

                // Save the PDF
                pdf.save("report.pdf");
            };
        }
    </script>
</body>

</html>
