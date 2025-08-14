<?php
// 292 seconds
// 5mb = 271s
// 10mb = 276s

$start_time = microtime(true);
$handle = fopen("measurements.txt", "r");
$lineCount = 0;
if ($handle) {
    while (!feof($handle)) {
        $line = fgets($handle);
        $lineCount++;
    }
    fclose($handle);
}
$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
echo "Total lines read: $lineCount\n";
?>