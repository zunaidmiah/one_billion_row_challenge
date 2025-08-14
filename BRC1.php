<?php
// 405 seconds
$start_time = microtime(true);
function readFileLineByLine($file) {
    $handle = fopen($file, "r");
    while (($line = fgets($handle)) !== false) {
        yield trim($line);
    }
    fclose($handle);
}

foreach (readFileLineByLine("new.txt") as $line) {
    $parts = explode(";", $line);
    // process
}

$end_time = microtime(true);
echo "Execution time: " . ($end_time-$start_time) . " seconds";