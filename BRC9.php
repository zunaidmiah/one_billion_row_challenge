<?php
$start_time = microtime(true);
$file = 'measurements.txt';

$threads_cnt = 16;

function get_file_chunks(string $file, int $cpu_count): array {
    $size = filesize($file);

    if ($cpu_count == 1) {
        $chunk_size = $size;
    } else {
        $chunk_size = (int) ($size / $cpu_count);
    }

    $fp = fopen($file, 'rb');

    $chunks = [];
    $chunk_start = 0;
    while ($chunk_start < $size) {
        $chunk_end = min($size, $chunk_start + $chunk_size);

        if ($chunk_end < $size) {
            fseek($fp, $chunk_end);
            fgets($fp);
            $chunk_end = ftell($fp);
        }

        $chunks[] = [
            $chunk_start,
            $chunk_end
        ];

        $chunk_start = $chunk_end;
    }

    fclose($fp);
    return $chunks;
}

$process_chunk = function (string $file, int $chunk_start, int $chunk_end): array {
    $stations = [];
    $fp = fopen($file, 'rb');
    fseek($fp, $chunk_start);
    while ($data = fgets($fp)) {
        $chunk_start += strlen($data);
        if ($chunk_start > $chunk_end) {
            break;
        }
        $pos2 = strpos($data, ';');
        $city = substr($data, 0, $pos2);
        $temp = (float)substr($data, $pos2+1, -1);
        if (isset($stations[$city])) {
            $station = &$stations[$city];
            $station[3] ++;
            $station[2] += $temp;
            if ($temp < $station[0]) {
                $station[0] = $temp;
            } elseif ($temp > $station[1]) {
                $station[1] = $temp;
            }
        } else {
            $stations[$city] = [
                $temp,
                $temp,
                $temp,
                1
            ];
        }
    }
    return $stations;
};

$chunks = get_file_chunks($file, $threads_cnt);

$futures = [];

for ($i = 0; $i < $threads_cnt; $i++) {
    $runtime = new \parallel\Runtime();
    $futures[$i] = $runtime->run(
        $process_chunk,
        [
            $file,
            $chunks[$i][0],
            $chunks[$i][1]
        ]
    );
}

$results = [];

for ($i = 0; $i < $threads_cnt; $i++) {
    $chunk_result = $futures[$i]->value();
    foreach ($chunk_result as $city => $measurement) {
        if (isset($results[$city])) {
            $result = &$results[$city];
            $result[2] += $measurement[2];
            $result[3] += $measurement[3];
            if ($measurement[0] < $result[0]) {
                $result[0] = $measurement[0];
            }
            if ($measurement[1] < $result[1]) {
                $result[1] = $measurement[1];
            }
        } else {
            $results[$city] = $measurement;
        }
    }
}

ksort($results);

echo '{', PHP_EOL;
foreach($results as $k=>&$station) {
    echo "\t", $k, '=', $station[0], '/', ($station[2]/$station[3]), '/', $station[1], ',', PHP_EOL;
}
echo '}', PHP_EOL;

$end_time = microtime(true);
echo "Execution time: " . ($end_time - $start_time) . " seconds\n";