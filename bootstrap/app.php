<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

/*
|--------------------------------------------------------------------------
| Redirect storage path saat jalan di Vercel
|--------------------------------------------------------------------------
| Filesystem Vercel bersifat read-only kecuali folder /tmp. Laravel butuh
| nulis ke storage/ untuk log, cache view, cache framework, dsb. Kalau
| environment Vercel terdeteksi, arahkan seluruh storage_path() ke /tmp
| supaya proses nulis (termasuk emergency logger bawaan Laravel yang
| selalu nulis ke storage/logs/laravel.log) tidak gagal karena
| "Read-only file system".
*/
if (getenv('VERCEL') || getenv('VERCEL_ENV') || isset($_ENV['VERCEL'])) {
    $storagePath = '/tmp/storage';

    foreach ([
        'app',
        'app/public',
        'framework',
        'framework/cache',
        'framework/cache/data',
        'framework/sessions',
        'framework/views',
        'framework/testing',
        'logs',
    ] as $dir) {
        $path = $storagePath.'/'.$dir;
        if (! is_dir($path)) {
            @mkdir($path, 0777, true);
        }
    }

    $app->useStoragePath($storagePath);
}

return $app;