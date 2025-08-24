<?php
$start = microtime(true);

// Step 1: Split the file
echo "Splitting file...\n";
shell_exec('php split_file.php');

// Step 2: Find all chunk files
$chunks = glob('chunk_*.txt');
$workerProcesses = [];

// Step 3: Start workers in parallel
foreach ($chunks as $i => $chunk) {
    $resultFile = 'result_' . ($i + 1) . '.txt';
    // Start worker in background
    $cmd = "php worker.php $chunk $resultFile >nul 2>&1 &";
    shell_exec($cmd);
    $workerProcesses[] = $resultFile;
}

// Step 4: Wait for all workers to finish
// (Simple sleep, adjust as needed for your data size)
echo "Waiting for workers to finish...\n";
sleep(60); // Increase if needed for large files

// Step 5: Merge results
echo "Merging results...\n";
shell_exec('php merge_results.php');

$end = microtime(true);
$totalTime = $end - $start;
echo "Total execution time: $totalTime seconds\n";
?>
