<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Align 2D Arrays of Any Size</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
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

    <h1>Align Two 2D Arrays of Any Size</h1>

    <table id="resultTable">
        <thead id="tableHeader">
            <!-- The header will be dynamically generated based on the array size -->
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        // Define the two 2D arrays of any size
        // const array1 = [
        //     ['2023-09-20', 0, 0, 0],
        //     ['2023-09-21', 1, 2, 3], // 4 columns
        //     ['2023-09-22', 4, 5, 6],
        //     ['2023-09-23', 7, 8, 9]
        // ];

        // const array2 = [
        //     ['2023-09-22', 10, 11], // 3 columns
        //     ['2023-09-23', 12, 13],
        //     ['2023-09-24', 14, 15]
        // ];

        const array1 = [
            ['A', 1, 2],
            ['B', 3, 4],
            ['C', 5, 6],
            ['E', 0, 0]
        ];

        const array2 = [
            ['B', 7, 8, 0],
            ['C', 9, 10, 0],
            ['D', 11, 12, 0]
        ];

        // Convert arrays into objects for easier access by the shared column (the first element)
        const dict1 = Object.fromEntries(array1.map(row => [row[0], row.slice(1)]));
        const dict2 = Object.fromEntries(array2.map(row => [row[0], row.slice(1)]));

        // Get all unique keys (shared column values) from both arrays
        const allKeys = [...new Set([...array1.map(row => row[0]), ...array2.map(row => row[0])])].sort();

        // Determine the maximum number of columns in each array (excluding the shared column)
        const maxColumns1 = Math.max(...array1.map(row => row.length - 1)); // Exclude the first column
        const maxColumns2 = Math.max(...array2.map(row => row.length - 1)); // Exclude the first column

        // Dynamically generate the table header
        function generateTableHeader() {
            const header = document.getElementById('tableHeader');
            const headerRow = document.createElement('tr');
            const headers = ['Shared Column']; // Start with the shared column header

            // Add column headers for Array 1
            for (let i = 1; i <= maxColumns1; i++) {
                headers.push(`Array 1 Col ${i}`);
            }

            // Add column headers for Array 2
            for (let i = 1; i <= maxColumns2; i++) {
                headers.push(`Array 2 Col ${i}`);
            }

            // Populate the header row
            headers.forEach(headerText => {
                const th = document.createElement('th');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });
            header.appendChild(headerRow);
        }

        // Prepare the combined array
        const combinedArray = allKeys.map(key => {
            const row1 = dict1[key] || Array(maxColumns1).fill(''); // If key is not in array1, use empty values
            const row2 = dict2[key] || Array(maxColumns2).fill(''); // If key is not in array2, use empty values
            return [key, ...row1, ...
                row2
            ]; // Combine key (shared column) with corresponding values from both arrays
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

        // Generate the table header and render the combined array
        generateTableHeader();
        renderTable(combinedArray);
    </script>

</body>

</html>
