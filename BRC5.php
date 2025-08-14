<?php

$start_time = microtime(true);

$file = new SplFileObject("new.txt");
$file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
$file->setCsvControl(";");

$stats = [];

while (!$file->eof()) {
    $row = $file->fgetcsv();
    if ($row === false || $row === [null]) continue;

    [$city, $temp] = $row;
    $temp = floatval($temp);

    if (!isset($stats[$city])) {
        $stats[$city] = [
            'min' => $temp,
            'max' => $temp,
            'sum' => $temp,
            'count' => 1
        ];
    } else {
        $stats[$city]['min'] = min($stats[$city]['min'], $temp);
        $stats[$city]['max'] = max($stats[$city]['max'], $temp);
        $stats[$city]['sum'] += $temp;
        $stats[$city]['count']++;
    }
}

foreach ($stats as $city => $data) {
    $stats[$city]['avg'] = $data['sum'] / $data['count'];
}

ksort($stats);

// foreach ($stats as $city => $data) {
//     echo $city . " -> Min: " . $data['min'] . ", Max: " . $data['max'] . ", Avg: " . $data['avg'] . "\n";
// }

$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";
