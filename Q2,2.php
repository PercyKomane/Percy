<!DOCTYPE html>
<html>
<head>
    <title>Day of the Week Calculator</title>
</head>
<body>
    <h2>Enter a Date</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="month">Month (1-12):</label>
        <input type="number" id="month" name="month" min="1" max="12" required>
        <br><br>
        <label for="day">Day:</label>
        <input type="number" id="day" name="day" min="1" max="31" required>
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    function getDayOfWeek($month, $day) {
        // Days of the week
        $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        
        // Months with their corresponding days in a non-leap year
        $monthDays = [
            1 => 31,
            2 => 28,
            3 => 31,
            4 => 30,
            5 => 31,
            6 => 30,
            7 => 31,
            8 => 31,
            9 => 30,
            10 => 31,
            11 => 30,
            12 => 31
        ];

        // Check if it's a leap year
        $isLeapYear = (date('L', strtotime("2024-$month-$day")) == 1);
        
        // Update February days if it's a leap year
        if ($isLeapYear) {
            $monthDays[2] = 29;
        }

        // Calculate the day of the week
        $dayOfYear = array_sum(array_slice($monthDays, 0, $month)) + $day;
        $dayOfWeekIndex = date('w', strtotime("2024-$month-$day"));
        $dayOfWeek = $days[$dayOfWeekIndex];

        return $dayOfWeek;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $month = (int)$_POST["month"];
        $day = (int)$_POST["day"];
        $dayOfWeek = getDayOfWeek($month, $day);
        echo "<p>The day of the week for $month/$day/2024 is: $dayOfWeek</p>";
    }
    ?>

</body>
</html>
