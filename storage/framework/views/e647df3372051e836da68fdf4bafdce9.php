<?php $__env->startSection('title', 'Ubah BRS'); ?>

<?php $__env->startSection('content'); ?>
    <a href="<?php echo e(route('brs.index', ['tahun' => $entry->tanggal_rilis->format('Y')])); ?>" class="text-sm text-slate-500 hover:underline mb-4 inline-block">&larr; Kembali ke daftar</a>

    <div class="bg-white rounded-lg border border-hairline p-5 max-w-3xl">
        <h3 class="font-serif-brs text-lg font-semibold mb-1">Ubah entri BRS</h3>
        <p class="font-mono-brs brass text-sm mb-4"><?php echo e($entry->nomor_brs); ?></p>

        <form method="POST" action="<?php echo e(route('brs.update', $entry)); ?>" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Judul BRS</label>
                <input type="text" name="judul" required value="<?php echo e(old('judul', $entry->judul)); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tanggal rilis</label>
                <input type="hidden" name="tanggal_rilis" value="<?php echo e($entry->tanggal_rilis->format('Y-m-d')); ?>">
                <div class="w-full border border-hairline rounded px-3 py-2 text-sm bg-[#F3F4F1] text-slate-600">
                    <?php echo e($entry->tanggal_rilis->format('d-m-Y')); ?>

                </div>
                <p class="text-xs text-slate-400 mt-1">Tanggal rilis tidak bisa diubah karena nomor BRS (<?php echo e($entry->nomor_brs); ?>) sudah diterbitkan berdasarkan tanggal ini.</p>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                <select name="kategori" id="kategori-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->nama); ?>" <?php echo e($entry->kategori == $k->nama ? 'selected' : ''); ?>><?php echo e($k->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$kategoris->pluck('nama')->contains($entry->kategori)): ?>
                        <option value="<?php echo e($entry->kategori); ?>" selected><?php echo e($entry->kategori); ?></option>
                    <?php endif; ?>
                    <option value="__baru__">+ Tambah kategori baru</option>
                </select>
                <input type="text" name="kategori_baru" id="kategori-baru" placeholder="Nama kategori baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Periode rilis</label>
                <select name="periode_rilis" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php echo e($entry->periode_rilis == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Penanggung jawab</label>
                <select name="penanggung_jawab" id="tim-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <?php $__currentLoopData = $tims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->nama); ?>" <?php echo e($entry->penanggung_jawab == $t->nama ? 'selected' : ''); ?>><?php echo e($t->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$tims->pluck('nama')->contains($entry->penanggung_jawab)): ?>
                        <option value="<?php echo e($entry->penanggung_jawab); ?>" selected><?php echo e($entry->penanggung_jawab); ?></option>
                    <?php endif; ?>
                    <option value="__baru__">+ Tambah tim baru</option>
                </select>
                <input type="text" name="penanggung_jawab_baru" id="tim-baru" placeholder="Nama tim baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tahun pertama terbit</label>
                <input type="number" name="tahun_pertama_terbit" value="<?php echo e(old('tahun_pertama_terbit', $entry->tahun_pertama_terbit)); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Jumlah terbitan</label>
                <input type="text" name="jumlah_terbitan" value="<?php echo e(old('jumlah_terbitan', $entry->jumlah_terbitan)); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2 flex gap-3 mt-2">
                <button type="submit" class="bg-navy text-white text-sm px-5 py-2 rounded hover:bg-navy-deep transition">Simpan perubahan</button>
                <a href="<?php echo e(route('brs.index', ['tahun' => $entry->tanggal_rilis->format('Y')])); ?>" class="text-sm px-5 py-2 rounded border border-hairline hover:bg-[#FAFAF8]">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function toggleBaru(selectId, inputId, fieldName) {
            const select = document.getElementById(selectId);
            const input = document.getElementById(inputId);
            select.addEventListener('change', () => {
                if (select.value === '__baru__') {
                    input.classList.remove('hidden');
                    input.focus();
                    select.removeAttribute('name');
                } else {
                    input.classList.add('hidden');
                    input.value = '';
                    select.name = fieldName;
                }
            });
        }
        toggleBaru('kategori-select', 'kategori-baru', 'kategori');
        toggleBaru('tim-select', 'tim-baru', 'penanggung_jawab');
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda-brs\resources\views/brs/edit.blade.php ENDPATH**/ ?>