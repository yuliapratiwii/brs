<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Pengajuan Nomor BRS'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@600;700&family=IBM+Plex+Mono:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F3F4F1; color: #1C2B45; }
        .font-serif-brs { font-family: 'Source Serif 4', serif; }
        .font-mono-brs { font-family: 'IBM Plex Mono', monospace; }
        .navy { color: #1C2B45; }
        .bg-navy { background-color: #1C2B45; }
        .bg-navy-deep { background-color: #111B2E; }
        .brass { color: #9C6F35; }
        .bg-brass-soft { background-color: #F3EADA; }
        .border-hairline { border-color: #DCDFE3; }
    </style>
</head>
<body class="min-h-screen">
    <header class="bg-navy text-white">
        <div class="max-w-3xl mx-auto px-6 py-5">
            <p class="text-xs tracking-widest uppercase text-slate-300">BPS Kota Lubuklinggau</p>
            <h1 class="font-serif-brs text-xl font-semibold">Pengajuan nomor berita resmi statistik</h1>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-6 py-8">
        <?php if(session('nomorBaru')): ?>
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-4 text-sm" style="border-left: 3px solid #3F7D53;">
                <p class="font-medium mb-1">BRS berhasil diajukan. Nomor BRS kamu:</p>
                <p class="font-mono-brs text-lg font-semibold brass"><?php echo e(session('nomorBaru')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #A23B3B;">
                <p class="font-medium mb-1">Ada isian yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = array_unique($errors->all()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda-brs\resources\views/layouts/publik.blade.php ENDPATH**/ ?>