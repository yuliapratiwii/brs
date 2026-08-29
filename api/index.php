<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/plain');
        echo "FATAL ERROR CAUGHT:\n";
        echo "Message: " . $error['message'] . "\n";
        echo "File: " . $error['file'] . "\n";
        echo "Line: " . $error['line'] . "\n";
    }
});

try {
    require __DIR__ . "/../public/index.php";
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');

    // Tampilkan SELURUH chain exception, dari yang paling awal (root cause)
    $current = $e;
    $depth = 0;
    while ($current !== null) {
        echo "=== EXCEPTION LEVEL {$depth} ===\n";
        echo "Class: " . get_class($current) . "\n";
        echo "Message: " . $current->getMessage() . "\n";
        echo "File: " . $current->getFile() . "\n";
        echo "Line: " . $current->getLine() . "\n";
        echo "Trace:\n" . $current->getTraceAsString() . "\n\n";
        $current = $current->getPrevious();
        $depth++;
    }
}