<?php
ini_set('memory_limit', '1024M');
$start_time = microtime(true);
$filename = "measurements.txt";
$bufferSize = 1024 * 1024 * 50;
$leftover = '';
$handle = fopen($filename, "r");
if (!$handle) {
    die("Cannot open file: $filename");
}
while (!feof($handle)) {
    $chunk = fread($handle, $bufferSize);
    if ($chunk === false) break;
    $chunk = $leftover . $chunk;
    $lines = explode("\n", $chunk);
    $leftover = array_pop($lines);

    foreach ($lines as $line) {
        if ($line === '') continue;
        [$city, $temp] = explode(";", $line, 2);
    }
}

if ($leftover !== '') {
    [$city, $temp] = explode(";", $leftover, 2);
}
fclose($handle);
$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
