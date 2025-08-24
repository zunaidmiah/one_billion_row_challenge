<?php
$inputFile = $argv[1];
$outputFile = $argv[2];
$stats = [];
$handle = fopen($inputFile, 'r');
while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    $sepPos = strpos($line, ';');
    if ($sepPos === false) continue;
    $city = substr($line, 0, $sepPos);
    $temp = (float)substr($line, $sepPos + 1);
    if (!isset($stats[$city])) {
        $stats[$city] = [$temp, $temp, $temp, 1];
    } else {
        if ($temp < $stats[$city][0]) $stats[$city][0] = $temp;
        if ($temp > $stats[$city][1]) $stats[$city][1] = $temp;
        $stats[$city][2] += $temp;
        $stats[$city][3]++;
    }
}
fclose($handle);
$out = fopen($outputFile, 'w');
foreach ($stats as $city => $stat) {
    fwrite($out, "$city;$stat[0];$stat[1];$stat[2];$stat[3]\n");
}
fclose($out);
?>
