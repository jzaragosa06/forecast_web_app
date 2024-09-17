{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Conversion</title>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@latest"></script>
</head>

<body>
    <script>
        function convertDate(inputDate) {
            // Parse the input date string
            const parsedDate = new Date(inputDate);
            // Format the date to MM/dd/yy
            const formattedDate = dateFns.format(parsedDate, 'MM/dd/yy');
            return formattedDate;
        }

        const userInputDate = '2023-09-16'; // Example input date
        const formattedDate = convertDate(userInputDate);
        console.log(formattedDate); // Output: 09/16/23
    </script>
</body>

</html> --}}
{{-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Conversion</title>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@latest"></script>
</head>

<body>
    <script>
        function convertDate(inputDate) {
            // Parse the input date string into a Date object
            const parsedDate = new Date(inputDate);

            // Format the date as MM/dd/yyyy (full year format)
            const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
            return formattedDate;
        }

        const userInputDate = '2024-06-04'; // Example input date in ISO format
        const formattedDate = convertDate(userInputDate);
        console.log(formattedDate); // Output: 04/06/2024
        console.log(convertDate('06-04-2024'));
    </script>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Formatting with date-fns</title>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@latest"></script>
</head>

<body>
    <script>
        // Example date string and format
        // const dateString = '16/09/2024'; // Format: DD/MM/YYYY
        const dateString = '2024/09/06'; // Format: DD/MM/YYYY

        const parseFormat = 'dd/MM/yyyy';
        const outputFormat = 'yyyy-MM-dd';
        let res;

        try {
            const parsedDate = new Date(dateString);

            const res = dateFns.parse(parsedDate, outputFormat);
            console.log('first');
            console.log(res); // Output: 2024-09-16


        } catch (error) {
            const parsedDate = dateFns.parse(dateString, parseFormat, new Date());

            // Formatting the date
            res = dateFns.format(parsedDate, outputFormat);
            console.log('sec');

            console.log(res); // Output: 2024-09-16

            console.log(res);
        }
    </script>
</body>

</html>
