<?php
$start_time = microtime(true);
$handle = fopen("measurements.txt", "r");
$stats = [];
if ($handle) {
    while ($line = fgets($handle)) {
        $pos = strpos($line, ';');
        $city = substr($line, 0, $pos);
        $temp = (float)substr($line, $pos+1, -1);
        if (!isset($stats[$city])) {
            $stats[$city] = [$temp, $temp, $temp, 1]; // min, max, sum, count
        } else {
            $stat = &$stats[$city];
            $stat[3] ++;
            $stat[2] += $temp;
            if ($temp < $stat[0]) {
                $stat[0] = $temp;
            }
            if ($temp > $stat[1]) {
                $stat[1] = $temp;
            }
        }
    }
    fclose($handle);
}

ksort($stats);

foreach ($stats as $city => $stat) {
    $stat[2] = $stat[2] / $stat[3];
}

$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
?>