<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Functions</title>
</head>
<body>
    <h1>PHP program that performs arithmetic</h1>
    <form action="func.php" method = "POST">
        <label>Enter num 1: </label>
        <input type="number" name="num1"><br>

        <label>Enter num 2: </label>
        <input type="number" name="num2"><br>

        <input type="submit" value="calculate"><br>
    </form>
</body>
</html>

<?php
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];

    function add($num1, $num2) {
        return $num1 + $num2;
    }

    function subtract($num1, $num2) {
        return $num1 - $num2;
    }

    function multiply($num1, $num2) {
        return $num1 * $num2;
    }

    function divide($num1, $num2) {
        if ($num2 != 0) {
            return $num1 / $num2;
        }
        else {
            return "Cannot divide by zero!";
        }
    }

    echo "<br>" . add($num1, $num2) . "<br>";
    echo divide($num1, $num2) . "<br>";
    echo multiply($num1, $num2);
?>