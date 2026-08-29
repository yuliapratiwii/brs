<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Agenda Penomoran BRS'); ?></title>
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
        .bg-brass { background-color: #9C6F35; }
        .bg-brass-soft { background-color: #F3EADA; }
        .border-hairline { border-color: #DCDFE3; }
    </style>
</head>
<body class="min-h-screen">
    <header class="bg-navy text-white">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
            <div>
                <p class="text-xs tracking-widest uppercase text-slate-300">BPS Kota Lubuklinggau</p>
                <h1 class="font-serif-brs text-xl font-semibold">Agenda penomoran berita resmi statistik</h1>
            </div>
            <nav class="flex items-center gap-5 text-sm">
            <div class="flex items-center gap-5">
                <a href="<?php echo e(route('brs.index')); ?>" class="hover:text-brass transition <?php echo e(request()->routeIs('brs.*') ? 'text-brass' : 'text-slate-200'); ?>">Registrasi</a>
                <a href="<?php echo e(route('settings.index')); ?>" class="hover:text-brass transition <?php echo e(request()->routeIs('settings.*') ? 'text-brass' : 'text-slate-200'); ?>">Pengaturan</a>
            </div>

            <div class="h-5 w-px bg-white/15"></div>

            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('pengajuan.create')); ?>" target="_blank"
                title="Buka halaman pengajuan publik di tab baru"
                class="flex items-center gap-1.5 rounded-full border border-white/15 px-3 py-1.5 text-xs text-slate-300 hover:text-brass hover:border-brass/40 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3.5 w-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span class="hidden md:inline">Pengajuan</span>
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center gap-1.5 rounded-full border border-white/15 px-3 py-1.5 text-xs text-slate-300 hover:text-brass hover:border-brass/40 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3.5 w-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" />
                        </svg>
                        Keluar
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        <?php if(session('sukses')): ?>
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #3F7D53;">
                <?php echo e(session('sukses')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('gagal')): ?>
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #A23B3B;">
                <?php echo e(session('gagal')); ?>

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
</html>
<?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda brs v3\agenda-brs\resources\views/layouts/app.blade.php ENDPATH**/ ?>