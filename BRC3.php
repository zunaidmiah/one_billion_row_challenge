<?php
// 292 seconds
// 5mb = 271s
// 10mb = 276s


$start_time = microtime(true);
$handle = fopen("measurements.txt", "r");
$stats = [];
if ($handle) {
    while (!feof($handle)) {
        $line = fgets($handle);
        // if ($line === false) break;
        // $data = explode(";", trim($line));
        // if (count($data) < 2) continue;
        // $city = $data[0];
        // $temp = (float)$data[1];
        // if (!isset($stats[$city])) {
        //     $stats[$city] = [
        //         'min' => $temp,
        //         'max' => $temp,
        //         'sum' => $temp,
        //         'count' => 1
        //     ];
        // } else {
        //     if ($temp < $stats[$city]['min']) $stats[$city]['min'] = $temp;
        //     if ($temp > $stats[$city]['max']) $stats[$city]['max'] = $temp;
        //     $stats[$city]['sum'] += $temp;
        //     $stats[$city]['count']++;
        // }
    }
    fclose($handle);
}
$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
// foreach ($stats as $city => $stat) {
//     $avg = $stat['sum'] / $stat['count'];
    // echo "$city: min=$stat[min] max=$stat[max] avg=$avg\n";
// }
?>