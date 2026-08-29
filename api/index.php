<?php

// Paksa tampilkan semua error langsung ke response (debug sementara)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Tangkap fatal error yang biasanya "senyap" (silent crash)
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
    echo "EXCEPTION CAUGHT:\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}