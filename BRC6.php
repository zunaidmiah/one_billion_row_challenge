<?php
$seconds = time();

//$fileHandle = fopen('./weather_stations.csv', 'r');
$fileHandle = fopen('measurements.txt', 'r');

$data = [];


$index = 0;
while (!feof($fileHandle)) {
    fgets($fileHandle);
    $index++;
}

// krsort($data);

foreach ($data as $key => $val) {
    // $dataPerCity = explode(',', $val['m1']);
    // $count = count($dataPerCity);
    // $sum = array_sum($dataPerCity);
    // $middle = floor(($count - 1) / 2);
    // $mean = $sum / $count;
    // $median = ($count % 2 == 0) ? ($dataPerCity[$middle] + $dataPerCity[$middle + 1]) / 2 : $dataPerCity[$middle];
    // $mode = array_search(max($val['m']), $val['m']);
    // echo "$key / Mean: $mean Median: $median Mode: $mode\n";
}

fclose($fileHandle);

$seconds2 = time();
$elapsedTime = $seconds2 - $seconds;
echo "Elapsed time in seconds: $elapsedTime\n";