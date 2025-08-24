<?php
$start_time = microtime(true);
$handle = fopen("measurements.txt", "r");
$stats = [];
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        $sepPos = strpos($line, ';');
        if ($sepPos === false) continue;
        $city = substr($line, 0, $sepPos);
        $temp = (float)substr($line, $sepPos + 1);
        if (!isset($stats[$city])) {
            $stats[$city] = [$temp, $temp, $temp, 1]; // min, max, sum, count
        } else {
            if ($temp < $stats[$city][0]) $stats[$city][0] = $temp;
            if ($temp > $stats[$city][1]) $stats[$city][1] = $temp;
            $stats[$city][2] += $temp;
            $stats[$city][3]++;
        }
    }
    fclose($handle);
}
$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
foreach ($stats as $city => $stat) {
    $avg = $stat[2] / $stat[3];
    // echo "$city: min=$stat[0] max=$stat[1] avg=$avg\n";
}
?>
