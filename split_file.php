<?php
$linesPerChunk = 10000000; // 10 million lines per chunk
$inputFile = 'measurements.txt';
$handle = fopen($inputFile, 'r');
$chunk = 1;
$lineCount = 0;
$outHandle = fopen("chunk_$chunk.txt", 'w');
while (($line = fgets($handle)) !== false) {
    fwrite($outHandle, $line);
    $lineCount++;
    if ($lineCount >= $linesPerChunk) {
        fclose($outHandle);
        $chunk++;
        $lineCount = 0;
        $outHandle = fopen("chunk_$chunk.txt", 'w');
    }
}
fclose($outHandle);
fclose($handle);
echo "File split into $chunk chunks.\n";
?>
