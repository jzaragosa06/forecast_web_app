<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Time Series Data</title>
    <style>
        /* Basic styles for grid and colors */
        .grid {
            display: table;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .grid th,
        .grid td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .first-file {
            background-color: green;
            color: white;
        }

        .second-file {
            background-color: blue;
            color: white;
        }

        .subsequent-file {
            background-color: orange;
            color: white;
        }

        .affected-cell {
            background-color: gray;
        }
    </style>
</head>

<body>
    <h1>Upload Time Series Data</h1>
    <input type="file" id="fileInput" multiple accept=".csv" />
    <button id="addMore">Add More Files</button>

    <table class="grid" id="dataGrid">
        <thead>
            <tr>
                <th>Date</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content will be rendered here -->
        </tbody>
    </table>

    <script>
        const dataGrid = document.getElementById('dataGrid').querySelector('tbody');
        let firstFile = true;

        document.getElementById('fileInput').addEventListener('change', (event) => {
            const files = event.target.files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const content = e.target.result.split('\n').map(line => line.split(','));
                    renderData(content);
                };
                reader.readAsText(file);
            });
        });

        function renderData(content) {
            content.forEach((row, index) => {
                const [date, value] = row;

                if (firstFile) {
                    // For the first file
                    const tr = document.createElement('tr');
                    tr.classList.add('first-file');
                    tr.innerHTML = `<td>${date}</td><td>${value}</td>`;
                    dataGrid.appendChild(tr);
                } else {
                    // For subsequent files
                    handleSubsequentFiles(date, value);
                }
            });
            firstFile = false; // Only set to false after processing the first file
        }

        function handleSubsequentFiles(date, value) {
            const rows = Array.from(dataGrid.rows);
            let inserted = false;

            rows.forEach((row, index) => {
                const rowDate = row.cells[0].textContent;

                // Match or insertion logic
                if (rowDate === date) {
                    // If there's a match, insert values
                    row.cells[1].textContent = value;
                    row.classList.add('second-file');
                    inserted = true;
                } else if (!inserted && new Date(date) < new Date(rowDate)) {
                    // Insert between dates
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td>${date}</td><td>${value}</td>`;
                    dataGrid.insertBefore(tr, row);
                    rows[index].classList.add('affected-cell'); // Mark the affected cell
                    inserted = true;
                }
            });

            // Handle cases where date is at start or end
            if (!inserted) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${date}</td><td>${value}</td>`;
                dataGrid.appendChild(tr);
            }
        }

        // Add more files functionality
        document.getElementById('addMore').addEventListener('click', () => {
            const newFileInput = document.createElement('input');
            newFileInput.type = 'file';
            newFileInput.accept = '.csv';
            newFileInput.addEventListener('change', (event) => {
                const files = event.target.files;
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const content = e.target.result.split('\n').map(line => line.split(
                        ','));
                        renderData(content);
                    };
                    reader.readAsText(file);
                });
            });
            document.body.appendChild(newFileInput);
        });
    </script>
</body>

</html>
