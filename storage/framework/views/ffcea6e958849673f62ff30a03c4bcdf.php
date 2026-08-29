

<?php $__env->startSection('title', 'Pengajuan Nomor BRS'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-white rounded-lg border border-hairline p-5">
        <h3 class="text-sm font-medium mb-1 text-slate-600">Ajukan BRS baru</h3>
        <p class="text-xs text-slate-400 mb-4">Tanggal rilis hanya bisa dipilih di tahun <?php echo e($tahunSekarang); ?>.</p>

        <form method="POST" action="<?php echo e(route('pengajuan.store')); ?>" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php echo csrf_field(); ?>
            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Judul BRS</label>
                <input type="text" name="judul" required value="<?php echo e(old('judul')); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm" placeholder="Perkembangan Indeks Harga Konsumen/Inflasi ...">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tanggal rilis</label>
                <input type="date" name="tanggal_rilis" required value="<?php echo e(old('tanggal_rilis')); ?>"
                       min="<?php echo e($tahunSekarang); ?>-01-01" max="<?php echo e($tahunSekarang); ?>-12-31"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                <select name="kategori" required class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih kategori</option>
                    <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->nama); ?>" <?php echo e(old('kategori') == $k->nama ? 'selected' : ''); ?>><?php echo e($k->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Periode rilis</label>
                <select name="periode_rilis" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php echo e(old('periode_rilis') == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Penanggung jawab</label>
                <select name="penanggung_jawab" required class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih tim</option>
                    <?php $__currentLoopData = $tims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->nama); ?>" <?php echo e(old('penanggung_jawab') == $t->nama ? 'selected' : ''); ?>><?php echo e($t->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tahun pertama terbit (opsional)</label>
                <input type="number" name="tahun_pertama_terbit" value="<?php echo e(old('tahun_pertama_terbit')); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm" placeholder="2015">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Jumlah terbitan (opsional)</label>
                <input type="text" name="jumlah_terbitan" value="<?php echo e(old('jumlah_terbitan')); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="bg-navy text-white text-sm px-5 py-2 rounded hover:bg-navy-deep transition">Ajukan & dapatkan nomor</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publik', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda brs v3\agenda-brs\resources\views/pengajuan/create.blade.php ENDPATH**/ ?>