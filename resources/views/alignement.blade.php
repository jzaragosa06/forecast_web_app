{{-- <!-- resources/views/upload.blade.php -->
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

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Align 2D Arrays</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h1>2D Array Alignment</h1>

    <table id="resultTable">
        <thead>
            <tr>
                <th>Shared Column</th>
                <th>Array 1 Col 1</th>
                <th>Array 1 Col 2</th>
                <th>Array 2 Col 1</th>
                <th>Array 2 Col 2</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        // Define the two 2D arrays
        const array1 = [
            ['A', 1, 2],
            ['B', 3, 4],
            ['C', 5, 6],
            ['E', 0, 0]
        ];

        const array2 = [
            ['B', 7, 8],
            ['C', 9, 10],
            ['D', 11, 12]
        ];

        // Convert arrays into objects for easier access by the shared column (the first element)
        const dict1 = Object.fromEntries(array1.map(row => [row[0], row.slice(1)]));
        const dict2 = Object.fromEntries(array2.map(row => [row[0], row.slice(1)]));

        // Get all unique keys (letters) from both arrays
        const allKeys = [...new Set([...array1.map(row => row[0]), ...array2.map(row => row[0])])].sort();

        // Prepare the combined array
        const combinedArray = allKeys.map(key => {
            const row1 = dict1[key] || ['', '']; // If key is not in array1, use empty values
            const row2 = dict2[key] || ['', '']; // If key is not in array2, use empty values
            return [key, ...row1, ...row2]; // Combine key with corresponding values from both arrays
        });

        // Function to render the combined array into the HTML table
        function renderTable(array) {
            const tableBody = document.getElementById('resultTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = ''; // Clear any previous rows

            array.forEach(row => {
                const tr = document.createElement('tr');
                row.forEach(cell => {
                    const td = document.createElement('td');
                    td.textContent = cell === '' ? '-' : cell; // Display '-' for empty cells
                    tr.appendChild(td);
                });
                tableBody.appendChild(tr);
            });
        }

        // Render the combined array in the table
        renderTable(combinedArray);
    </script>

</body>

</html>
