<?php

$rows = 6;
$tab = null;
$con = "";

for ($row = 0; $row < $rows; $row++) {
    echo "#";
    for ($spaces = 0; $spaces < $row; $spaces++) {
        echo "&nbsp&nbsp";
    }
    echo "#<br>";
}

?>
