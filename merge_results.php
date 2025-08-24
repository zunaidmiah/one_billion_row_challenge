<?php
$files = glob('result_*.txt');
$finalStats = [];
foreach ($files as $file) {
    $handle = fopen($file, 'r');
    while (($line = fgets($handle)) !== false) {
        list($city, $min, $max, $sum, $count) = explode(';', trim($line));
        $min = (float)$min; $max = (float)$max; $sum = (float)$sum; $count = (int)$count;
        if (!isset($finalStats[$city])) {
            $finalStats[$city] = [$min, $max, $sum, $count];
        } else {
            if ($min < $finalStats[$city][0]) $finalStats[$city][0] = $min;
            if ($max > $finalStats[$city][1]) $finalStats[$city][1] = $max;
            $finalStats[$city][2] += $sum;
            $finalStats[$city][3] += $count;
        }
    }
    fclose($handle);
}
foreach ($finalStats as $city => $stat) {
    $avg = $stat[2] / $stat[3];
    echo "$city: min=$stat[0] max=$stat[1] avg=$avg\n";
}
?>
