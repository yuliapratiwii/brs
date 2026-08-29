<?php $__env->startSection('title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="font-serif-brs text-lg font-semibold mb-6">Pengaturan agenda penomoran</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Kode wilayah</h3>
            <form method="POST" action="<?php echo e(route('settings.kodewilayah.update')); ?>" class="flex gap-2">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="text" name="kode_wilayah" value="<?php echo e($kodeWilayah); ?>" class="border border-hairline rounded px-3 py-2 text-sm font-mono-brs">
                <button type="submit" class="bg-navy text-white text-sm px-4 py-2 rounded hover:bg-navy-deep">Simpan</button>
            </form>
            <p class="text-xs text-slate-400 mt-2">Mengubah ini akan menghitung ulang nomor BRS di semua tahun.</p>
        </div>

        
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Tahun ke-berapa (angka romawi)</h3>
            <table class="w-full text-sm mb-3">
                <thead>
                    <tr class="text-left text-xs uppercase text-slate-500">
                        <th class="py-1">Tahun takwim</th>
                        <th class="py-1">Romawi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tahunReferensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-t border-hairline">
                            <td class="py-2"><?php echo e($tr->tahun); ?></td>
                            <td class="py-2">
                                <details>
                                    <summary class="cursor-pointer text-sm font-mono-brs"><?php echo e($tr->romawi); ?>

                                        <span class="text-xs text-slate-400 no-underline">(koreksi)</span></summary>
                                    <form method="POST" action="<?php echo e(route('settings.tahun.update', $tr)); ?>" class="flex gap-2 mt-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="text" name="romawi" value="<?php echo e($tr->romawi); ?>" class="border border-hairline rounded px-2 py-1 text-sm w-20 font-mono-brs">
                                        <button type="submit" class="text-xs brass hover:underline">Simpan koreksi</button>
                                    </form>
                                </details>
                            </td>
                            <td>
                                <td class="py-2 text-right">
                                    <form method="POST" action="<?php echo e(route('settings.tahun.destroy', $tr)); ?>"
                                        onsubmit="return confirm('Hapus tahun <?php echo e($tr->tahun); ?> dari daftar referensi?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="text-xs text-red-700 hover:underline">Hapus</button>
                                    </form>
                                </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <form method="POST" action="<?php echo e(route('settings.tahun.store')); ?>" class="flex items-center gap-2">
                <?php echo csrf_field(); ?>
                <input type="number" name="tahun" value="<?php echo e($tahunBerikutnya); ?>" required class="border border-hairline rounded px-3 py-2 text-sm w-24">
                <span class="text-sm text-slate-500">akan jadi tahun ke-<span class="font-mono-brs font-medium"><?php echo e($romawiBerikutnya); ?></span></span>
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah tahun</button>
            </form>
            <p class="text-xs text-slate-400 mt-2">Angka romawi selalu otomatis melanjutkan tahun sebelumnya. Kalau perlu dibetulkan (mis. data lama), buka "koreksi" di baris tahunnya.</p>
        </div>

        
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Daftar kategori BRS</h3>
            <ul class="mb-3 space-y-1">
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center justify-between text-sm border-b border-hairline py-1.5">
                        <span><?php echo e($k->nama); ?></span>
                        <form method="POST" action="<?php echo e(route('settings.kategori.destroy', $k)); ?>"
                              onsubmit="return confirm('Hapus kategori <?php echo e($k->nama); ?> dari daftar pilihan?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-red-700 hover:underline">Hapus</button>
                        </form>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <form method="POST" action="<?php echo e(route('settings.kategori.store')); ?>" class="flex gap-2">
                <?php echo csrf_field(); ?>
                <input type="text" name="nama" placeholder="Kategori baru" required class="border border-hairline rounded px-3 py-2 text-sm flex-1">
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah</button>
            </form>
        </div>

        
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Daftar tim / penanggung jawab</h3>
            <ul class="mb-3 space-y-1">
                <?php $__currentLoopData = $tims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center justify-between text-sm border-b border-hairline py-1.5">
                        <span><?php echo e($t->nama); ?></span>
                        <form method="POST" action="<?php echo e(route('settings.tim.destroy', $t)); ?>"
                              onsubmit="return confirm('Hapus tim <?php echo e($t->nama); ?> dari daftar pilihan?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-red-700 hover:underline">Hapus</button>
                        </form>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <form method="POST" action="<?php echo e(route('settings.tim.store')); ?>" class="flex gap-2">
                <?php echo csrf_field(); ?>
                <input type="text" name="nama" placeholder="Tim baru" required class="border border-hairline rounded px-3 py-2 text-sm flex-1">
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah</button>
            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda-brs\resources\views/settings/index.blade.php ENDPATH**/ ?>