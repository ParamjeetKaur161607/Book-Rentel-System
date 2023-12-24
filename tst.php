<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Picker Button</title>
</head>
<body>

<form method="post" action="process.php">
    <!-- Text input for date -->
    <input type="date" id="dateInput" name="dateInput" style="display: none;">
    
    <!-- Button to trigger the date picker -->
    <button type="button" onclick="openDatePicker()">Pick a Date</button>

    <!-- Submit button to submit the form -->
    <input type="submit" value="Submit">
</form>

<script>
    function openDatePicker() {
        // Access the date input element
        var dateInput = document.getElementById("dateInput");

        // Display the date input
        dateInput.style.display = "inline";
    }
</script>

</body>
</html>