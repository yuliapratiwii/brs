<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — Agenda Penomoran BRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@600;700&family=IBM+Plex+Mono:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F3F4F1; color: #1C2B45; }
        .font-serif-brs { font-family: 'Source Serif 4', serif; }
        .navy { color: #1C2B45; }
        .bg-navy { background-color: #1C2B45; }
        .bg-navy-deep { background-color: #111B2E; }
        .brass { color: #9C6F35; }
        .bg-brass { background-color: #9C6F35; }
        .border-hairline { border-color: #DCDFE3; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <p class="text-xs tracking-widest uppercase text-slate-500">BPS Kota Lubuklinggau</p>
            <h1 class="font-serif-brs text-xl font-semibold navy mt-1">Masuk Admin</h1>
            <p class="text-sm text-slate-500 mt-1">Agenda penomoran berita resmi statistik</p>
        </div>

        <div class="bg-white rounded border border-hairline p-6">
            <?php if(session('sukses')): ?>
                <div class="mb-4 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #3F7D53;">
                    <?php echo e(session('sukses')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-4 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #A23B3B;">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.attempt')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full rounded border border-hairline px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#9C6F35]">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Kata sandi</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded border border-hairline px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#9C6F35]">
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember" value="1" class="rounded border-hairline">
                    Ingat saya
                </label>
                <button type="submit" class="w-full bg-navy text-white rounded py-2 text-sm font-medium hover:bg-navy-deep transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            <a href="<?php echo e(route('pengajuan.create')); ?>" class="hover:text-brass">Kembali ke halaman pengajuan publik</a>
        </p>
    </div>
</body>
</html><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda brs v3\agenda-brs\resources\views/auth/login.blade.php ENDPATH**/ ?>