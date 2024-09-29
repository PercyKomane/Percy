<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action = "testfile.php" method = "POST">
        <label>Quantity: </label><br>
        <input type="number" name="quantity"><br>
        <input type="submit" value="total"><br>
    </form>
</body>
</html>

<?php
    $name = "pizza";
    $price = 4.99;
    $quantity = $_POST["quantity"];
    $total = null;

    $total = $price * $quantity;

    echo "You have ordered {$quantity} x {$name}/s <br>";
    echo "Your total is: \${$total}";

?>