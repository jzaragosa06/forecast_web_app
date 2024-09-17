<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <title>Stock Market Data</title>
</head>

<body>
    <h1>Fetch Stock Market Data</h1>

    {{-- <form id="stock-form">
        <label for="symbol">Stock Symbol or Index:</label>
        <input type="text" id="symbol" name="symbol" required>

        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start-date" required>

        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end-date" required>

        <button type="submit">Fetch Data</button>
    </form>

    <div id="results"></div> --}}

    <script>
        // document.getElementById('stock-form').addEventListener('submit', async (event) => {
        //     event.preventDefault();

        //     const symbol = document.getElementById('symbol').value;
        //     const startDate = document.getElementById('start-date').value;
        //     const endDate = document.getElementById('end-date').value;

        //     // Replace with your RapidAPI key and endpoint
        //     const apiKey = '';
        //     const url =
        //         `https://yahoo-finance15.p.rapidapi.com/api/yahoo/finance/v8/finance/spark?symbols=${symbol}&from=${startDate}&to=${endDate}`;

        //     try {
        //         const response = await fetch(url, {
        //             method: 'GET',
        //             headers: {
        //                 'X-RapidAPI-Host': 'yahoo-finance15.p.rapidapi.com',
        //                 'X-RapidAPI-Key': apiKey
        //             }
        //         });

        //         if (!response.ok) {
        //             throw new Error('Network response was not ok');
        //         }

        //         const data = await response.json();
        //         document.getElementById('results').innerHTML = JSON.stringify(data, null, 2);
        //     } catch (error) {
        //         document.getElementById('results').innerHTML = `Error: ${error.message}`;
        //     }
        // });


        // const settings = {
        //     async: true,
        //     crossDomain: true,
        //     url: 'https://yahoo-finance15.p.rapidapi.com/api/v1/markets/options/most-active?type=STOCKS',
        //     method: 'GET',
        //     headers: {
        //         'x-rapidapi-key': '27321c3e45msh8a43df15fa75e95p179567jsn928007b60073',
        //         'x-rapidapi-host': 'yahoo-finance15.p.rapidapi.com'
        //     }
        // };

        // $.ajax(settings).done(function(response) {
        //     console.log(response);
        // });

        const settings = {
            async: true,
            crossDomain: true,
            url: 'https://yahoo-finance15.p.rapidapi.com/api/v1/markets/stock/history?symbol=AAPL&interval=5m&diffandsplits=false',
            method: 'GET',
            headers: {
                'x-rapidapi-key': '27321c3e45msh8a43df15fa75e95p179567jsn928007b60073',
                'x-rapidapi-host': 'yahoo-finance15.p.rapidapi.com'
            }
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
        });
    </script>
</body>

</html>
