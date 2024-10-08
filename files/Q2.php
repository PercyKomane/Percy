<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Scores</title>
</head>
<body>
    <form action="Q2.php" method="POST">
        <label>Enter test score 1: </label>
        <input type="number" name="score1"><br>
        <label>Enter test score 2: </label>
        <input type="number" name="score2"><br>
        <label>Enter test score 3: </label>
        <input type="number" name="score3"><br>
        <label>Enter test score 4: </label>
        <input type="number" name="score4"><br>
        <label>Enter test score 5: </label>
        <input type="number" name="score5"><br>

        <input type="submit" value="calculate">
    </form>
</body>
</html>

<?php
    $test_scores = [
        $_POST["score1"],
        $_POST["score2"],
        $_POST["score3"],
        $_POST["score4"],
        $_POST["score5"]
    ];

    function calc_average($test_scores) {
        $sum = array_sum($test_scores);
        $avg = $sum / 5;
        return $avg;
    }

    function determine_grade($test_scores) {
        echo "<br>Score &nbsp &nbsp &nbsp &nbsp Letter Grade <br>";
        echo "____________________<br>";

        foreach ($test_scores as $test) {
            if ($test >= 90 && $test <= 100) {
                echo "$test &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  A<br>";
            } elseif ($test >= 80 && $test <= 89) {
                echo "$test &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  B<br>";
            } elseif ($test >= 70 && $test <= 79) {
                echo "$test &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  C<br>";
            } elseif ($test >= 60 && $test <= 69) {
                echo "$test &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  D<br>";
            } elseif ($test >= 0 && $test <= 59) {
                echo "$test &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  F<br>";
            } else {
                echo "Invalid input<br>";
            }
        }
    }
    determine_grade($test_scores);

    echo "<br>Average of test scores is: ", calc_average($test_scores);
?>
