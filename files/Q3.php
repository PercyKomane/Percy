<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>division</title>
    <style>
        body {
            display: flex;
            justify-content: center;
        }
        table {
            border-collapse: collapse;
            background-color: MintCream;
        }
        td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            border-top: 1px solid black;
            border-right: 1px solid snow;
            padding: 8px;

        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th></th>
            <?php
                for ($i=1; $i <= 10 ; $i++) { 
                    echo "<th>$i</th>";
                }
            ?>
        </tr>

        <?php
            for ($i=1; $i <= 10 ; $i++) { 
                echo "<tr>";
                echo "<th>$i</th>";

                for ($j=1; $j <= 10 ; $j++) { 
                    echo "<td>" . round(($i / $j), 3) . "</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>