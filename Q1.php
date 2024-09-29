<!DOCTYPE html>
<html>
<head>
    <title>Seconds Converter</title>
</head>
<body>
    <h2>Enter the number of seconds:</h2>
    <form method="post">
        <input type="text" name="seconds" placeholder="Enter seconds">
        <input type="submit" name="submit" value="Convert">
    </form>

    <?php
    function convertSeconds($seconds) {
        $days = floor($seconds / 86400);
        $seconds -= $days * 86400;
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        
        return array($days, $hours, $minutes, $seconds);
    }

    function displayTime($time) {
        list($days, $hours, $minutes, $seconds) = $time;
        $output = "";
        if ($days > 0) {
            $output .= "$days day(s), ";
        }
        if ($hours > 0) {
            $output .= "$hours hour(s), ";
        }
        if ($minutes > 0) {
            $output .= "$minutes minute(s), ";
        }
        $output .= "$seconds second(s)";
        return rtrim($output, ', ');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $seconds = $_POST["seconds"];
        if ($seconds >= 86400) {
            $time = convertSeconds($seconds);
            echo "<h2>Converted time:</h2>";
            echo displayTime($time);
        } elseif ($seconds >= 3600) {
            $time = convertSeconds($seconds);
            echo "<h2>Converted time:</h2>";
            echo displayTime($time);
        } elseif ($seconds >= 60) {
            $time = convertSeconds($seconds);
            echo "<h2>Converted time:</h2>";
            echo displayTime($time);
        } else {
            echo "<h2>No conversion needed. Entered seconds: $seconds</h2>";
        }
    }
    ?>
</body>
</html>
