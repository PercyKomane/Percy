<!DOCTYPE html>
<html>
<head>
    <title>Convex Polygon Area Calculator</title>
</head>
<body>
    <h2>Convex Polygon Area Calculator</h2>
    <form method="get">
        Number of sides: <input type="number" name="num_sides" min="3" max="20" required><br>
        <button type="submit">Submit</button>
    </form>

    <?php
    function heronFormula($a, $b, $c) {
        $s = ($a + $b + $c) / 2;
        return sqrt($s * ($s - $a) * ($s - $b) * ($s - $c));
    }

    function polygonArea($sides) {
        $numSides = count($sides);
        if ($numSides < 3 || $numSides > 20) {
            return "Number of sides should be between 3 and 20.";
        }

        $totalArea = 0;

        for ($i = 0; $i < $numSides - 2; $i++) {
            $a = $sides[0];
            $b = $sides[$i + 1];
            $c = $sides[$i + 2];
            $area = heronFormula($a, $b, $c);
            $totalArea += $area;
        }

        return $totalArea;
    }

    if(isset($_GET['num_sides'])) {
        $numSides = $_GET['num_sides'];
        echo "<form method='post'>";
        for ($i = 0; $i < $numSides; $i++) {
            echo "Length of side " . ($i+1) . ": <input type='number' name='side[]' required><br>";
        }
        echo "<button type='submit'>Calculate</button></form>";
    }

    if(isset($_POST['side'])) {
        $sides = $_POST['side'];
        $area = polygonArea($sides);
        echo "Area of the polygon: " . $area;
    }
    ?>
</body>
</html>
