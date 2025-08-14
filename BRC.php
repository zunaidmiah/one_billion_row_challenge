<?php
// 321 seconds
$start_time = microtime(true);
$handle = fopen("measurements.txt", "r");
$processedData = [];
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $data = explode(";", trim($line));
        // if(!isset($processedData[$data[0]])){
        //     $processedData[$data[0]] = [
        //         'max'   => $data[1],
        //         'min'   => $data[1], 
        //         'avg'   => $data[1],
        //         'total' => $data[1],
        //         'count' => 1
        //     ];
        // }else{
        //     $processedData[$data[0]]['max']   = $data[1] > $processedData[$data[0]]['max'] ? $data[1] : $processedData[$data[0]]['max'];
        //     $processedData[$data[0]]['min']   = $data[1] < $processedData[$data[0]]['min'] ? $data[1]  : $processedData[$data[0]]['min'];
        //     $processedData[$data[0]]['total'] += $data[1];
        //     $processedData[$data[0]]['count']++;
        //     $processedData[$data[0]]['avg']   = $processedData[$data[0]]['total'] / $processedData[$data[0]]['count'];
        // }
    }
    fclose($handle);
    // ksort($processedData);


    


    // print_r($processedData);


    // foreach ($processedData as $key => $values) {
    //     $min = min($values);
    //     $max = max($values);
    //     $avg = array_sum($values) / count($values);
    //     echo "$key=$min/$avg/$max\n";
    // }

}


$end_time = microtime(true);
echo "Execution time: " . ($end_time-$start_time) . " seconds";
?>
