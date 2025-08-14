<?php
// 393 seconds
// ini_set('max_execution_time', 0);
// ini_set('memory_limit', '512M');
$start_time = microtime(true);

$file = "new.txt";
$chunkSize = 10000;
$handle = fopen($file, "r");

if (!$handle) {
    die("Cannot open file.");
}

$chunk = [];
while (($line = fgets($handle)) !== false) {
    $chunk[] = trim($line);
    if (count($chunk) === $chunkSize) {
        processChunk($chunk);
        $chunk = [];
    }
}

if (!empty($chunk)) {
    processChunk($chunk);
}

fclose($handle);

function processChunk(array $lines) {
    foreach ($lines as $line) {
        $parts = explode(";", $line);
    }

}

$end_time = microtime(true);
echo "Execution time: " . ($end_time-$start_time) . " seconds";
?>
