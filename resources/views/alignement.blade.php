{{-- <!-- resources/views/timeseries.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Series Data Comparison</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .matched {
            background-color: blue;
            color: white;
        }

        .not-matched {
            background-color: green;
            color: white;
        }
    </style>
</head>

<body>

    <h1>Time Series Data Comparison</h1>

    <input type="file" id="file1" accept=".csv" />
    <input type="file" id="file2" accept=".csv" />
    <button onclick="compareData()">Compare Data</button>

    <div id="result"></div>

    <script>
        async function readCSV(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const text = event.target.result;
                    const data = text.split('\n').map(row => row.split(','));
                    resolve(data);
                };
                reader.onerror = reject;
                reader.readAsText(file);
            });
        }

        async function compareData() {
            const file1 = document.getElementById('file1').files[0];
            const file2 = document.getElementById('file2').files[0];

            if (!file1 || !file2) {
                alert("Please upload both files.");
                return;
            }

            const data1 = await readCSV(file1);
            const data2 = await readCSV(file2);

            const dateIndex1 = 0; // assuming the first column is Date
            const dateIndex2 = 0; // assuming the first column is Date

            const map1 = new Map(data1.map(row => [row[dateIndex1], row.slice(1)]));
            const map2 = new Map(data2.map(row => [row[dateIndex2], row.slice(1)]));

            const allDates = new Set([...map1.keys(), ...map2.keys()]);
            const resultHtml = `
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Data from CSV 1</th>
                        <th>Data from CSV 2</th>
                    </tr>
                </thead>
                <tbody>
                    ${Array.from(allDates).map(date => {
                        const dataFromCSV1 = map1.get(date) || ['N/A'];
                        const dataFromCSV2 = map2.get(date) || ['N/A'];

                        const isMatch = dataFromCSV1.join(',') === dataFromCSV2.join(',');
                        const className = isMatch ? 'matched' : 'not-matched';

                        return `
                                        <tr class="${className}">
                                            <td>${date}</td>
                                            <td>${dataFromCSV1.join(', ')}</td>
                                            <td>${dataFromCSV2.join(', ')}</td>
                                        </tr>
                                    `;
                    }).join('')}
                </tbody>
            </table>
        `;

            document.getElementById('result').innerHTML = resultHtml;
        }
    </script>

</body>

</html> --}}
{{-- 
<!-- resources/views/timeseries.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Series Data Comparison</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .matched {
            background-color: blue;
            color: white;
        }
        .not-matched {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

<h1>Time Series Data Comparison</h1>

<input type="file" id="file1" accept=".csv" />
<input type="file" id="file2" accept=".csv" />
<button onclick="compareData()">Compare Data</button>

<div id="result"></div>

<script>
    async function readCSV(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const text = event.target.result;
                const data = text.split('\n').map(row => row.split(','));
                resolve(data);
            };
            reader.onerror = reject;
            reader.readAsText(file);
        });
    }

    async function compareData() {
        const file1 = document.getElementById('file1').files[0];
        const file2 = document.getElementById('file2').files[0];

        if (!file1 || !file2) {
            alert("Please upload both files.");
            return;
        }

        const data1 = await readCSV(file1);
        const data2 = await readCSV(file2);

        const dateIndex1 = 0; // assuming the first column is Date
        const dateIndex2 = 0; // assuming the first column is Date

        const map1 = new Map(data1.map(row => [row[dateIndex1], row.slice(1)]));
        const map2 = new Map(data2.map(row => [row[dateIndex2], row.slice(1)]));

        const allDates = new Set([...map1.keys(), ...map2.keys()]);
        const sortedDates = Array.from(allDates).sort(); // Sort dates for alignment

        const resultHtml = `
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Data from CSV 1</th>
                        <th>Data from CSV 2</th>
                    </tr>
                </thead>
                <tbody>
                    ${sortedDates.map(date => {
                        const dataFromCSV1 = map1.get(date) || ['-']; // Using '-' for gaps
                        const dataFromCSV2 = map2.get(date) || ['-']; // Using '-' for gaps

                        const isMatch = dataFromCSV1.join(',') === dataFromCSV2.join(',');
                        const className = isMatch ? 'matched' : 'not-matched';

                        return `
                            <tr class="${className}">
                                <td>${date}</td>
                                <td>${dataFromCSV1.join(', ')}</td>
                                <td>${dataFromCSV2.join(', ')}</td>
                            </tr>
                        `;
                    }).join('')}
                </tbody>
            </table>
        `;

        document.getElementById('result').innerHTML = resultHtml;
    }
</script>

</body>
</html> --}}


<!-- resources/views/timeseries.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Series Data Comparison</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .matched {
            background-color: blue;
            color: white;
        }

        .not-matched {
            background-color: green;
            color: white;
        }
    </style>
</head>

<body>

    <h1>Time Series Data Comparison</h1>

    <input type="file" id="file1" accept=".csv" />
    <input type="file" id="file2" accept=".csv" />
    <input type="file" id="file3" accept=".csv" />
    <button onclick="compareData()">Compare Data</button>

    <div id="result"></div>

    <script>
        async function readCSV(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const text = event.target.result;
                    const data = text.split('\n').map(row => row.split(','));
                    resolve(data);
                };
                reader.onerror = reject;
                reader.readAsText(file);
            });
        }

        async function compareData() {
            const file1 = document.getElementById('file1').files[0];
            const file2 = document.getElementById('file2').files[0];
            const file3 = document.getElementById('file3').files[0];

            if (!file1 || !file2 || !file3) {
                alert("Please upload all three files.");
                return;
            }

            const data1 = await readCSV(file1);
            const data2 = await readCSV(file2);
            const data3 = await readCSV(file3);

            const dateIndex1 = 0; // assuming the first column is Date
            const dateIndex2 = 0; // assuming the first column is Date
            const dateIndex3 = 0; // assuming the first column is Date

            const map1 = new Map(data1.map(row => [row[dateIndex1], row.slice(1)]));
            const map2 = new Map(data2.map(row => [row[dateIndex2], row.slice(1)]));
            const map3 = new Map(data3.map(row => [row[dateIndex3], row.slice(1)]));

            const allDates = new Set([...map1.keys(), ...map2.keys(), ...map3.keys()]);
            const sortedDates = Array.from(allDates).sort(); // Sort dates for alignment

            const resultHtml = `
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Data from CSV 1</th>
                        <th>Data from CSV 2</th>
                        <th>Data from CSV 3</th>
                    </tr>
                </thead>
                <tbody>
                    ${sortedDates.map(date => {
                        const dataFromCSV1 = map1.get(date) || ['-']; // Using '-' for gaps
                        const dataFromCSV2 = map2.get(date) || ['-']; // Using '-' for gaps
                        const dataFromCSV3 = map3.get(date) || ['-']; // Using '-' for gaps

                        const isMatch1and2 = dataFromCSV1.join(',') === dataFromCSV2.join(',');
                        const isMatch1and3 = dataFromCSV1.join(',') === dataFromCSV3.join(',');
                        const isMatch2and3 = dataFromCSV2.join(',') === dataFromCSV3.join(',');

                        const className = (isMatch1and2 && isMatch1and3 && isMatch2and3) ? 'matched' : 'not-matched';

                        return `
                                <tr class="${className}">
                                    <td>${date}</td>
                                    <td>${dataFromCSV1.join(', ')}</td>
                                    <td>${dataFromCSV2.join(', ')}</td>
                                    <td>${dataFromCSV3.join(', ')}</td>
                                </tr>
                            `;
                    }).join('')}
                </tbody>
            </table>
        `;

            document.getElementById('result').innerHTML = resultHtml;
        }
    </script>

</body>

</html>
