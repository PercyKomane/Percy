<?php
$file_path = 'C:\xampp\htdocs\Percy\file.txt';

if (file_exists($file_path)) {
    if (unlink($file_path)) {
        echo "File deleted successfully.";
    } else {
        echo "Unable to delete the file.";
    }
} else {
    echo "File does not exist.";
}
?>
