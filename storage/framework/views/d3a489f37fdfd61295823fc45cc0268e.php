<?php $__env->startSection('title', 'Registrasi BRS ' . $tahun); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="flex items-center gap-3 mb-6">
        <label for="tahun-select" class="text-sm text-slate-500">Tahun</label>
        <select id="tahun-select" class="border border-hairline rounded px-3 py-2 text-sm font-medium"
                onchange="window.location.href = this.value">
            <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e(route('brs.index', ['tahun' => $y])); ?>" <?php echo e($y == $tahun ? 'selected' : ''); ?>>
                    <?php echo e($y); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <a href="<?php echo e(route('brs.index', ['tahun' => max($availableYears) + 1])); ?>"
           class="text-sm text-slate-400 hover:text-brass" title="Buka tahun berikutnya">+ tahun baru</a>
    </div>

    <div class="flex items-baseline justify-between mb-4">
        <h2 class="font-serif-brs text-lg font-semibold">Tahun <?php echo e($tahun); ?> &middot; tahun ke-<?php echo e($tahunRomawi ?? '?'); ?> rilis BRS</h2>
        <a href="<?php echo e(route('brs.export', $tahun)); ?>" class="text-sm brass hover:underline">Ekspor Excel</a>
    </div>

    <?php if(!$tahunRomawi): ?>
        <div class="mb-6 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #9C6F35;">
            Tahun <?php echo e($tahun); ?> belum punya referensi angka romawi. Tambahkan dulu di
            <a href="<?php echo e(route('settings.index')); ?>" class="underline brass">halaman Pengaturan</a> supaya nomor bisa dihitung.
        </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-lg border border-hairline p-5 mb-8">
        <h3 class="text-sm font-medium mb-4 text-slate-600">Terbitkan BRS baru</h3>
        <form method="POST" action="<?php echo e(route('brs.store')); ?>" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="brs-form">
            <?php echo csrf_field(); ?>
            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Judul BRS</label>
                <input type="text" name="judul" required value="<?php echo e(old('judul')); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm" placeholder="Perkembangan Indeks Harga Konsumen/Inflasi ...">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tanggal rilis</label>
                <input type="date" name="tanggal_rilis" id="tanggal_rilis" required value="<?php echo e(old('tanggal_rilis')); ?>"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                <select name="kategori" id="kategori-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih kategori</option>
                    <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->nama); ?>"><?php echo e($k->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <option value="__baru__">+ Tambah kategori baru</option>
                </select>
                <input type="text" name="kategori_baru" id="kategori-baru" placeholder="Nama kategori baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Periode rilis</label>
                <select name="periode_rilis" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>"><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Penanggung jawab</label>
                <select name="penanggung_jawab" id="tim-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih tim</option>
                    <?php $__currentLoopData = $tims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->nama); ?>"><?php echo e($t->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <option value="__baru__">+ Tambah tim baru</option>
                </select>
                <input type="text" name="penanggung_jawab_baru" id="tim-baru" placeholder="Nama tim baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
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

            <div class="md:col-span-3 flex items-center justify-between rounded bg-brass-soft px-4 py-3 mt-2">
                <div class="text-sm text-slate-600">Perkiraan nomor BRS <span class="text-xs">(final saat disimpan)</span></div>
                <div class="font-mono-brs text-lg font-semibold brass" id="preview-nomor">--/--/<?php echo e(\App\Models\Setting::get('kode_wilayah', '1674')); ?>/Th.<?php echo e($tahunRomawi ?? '?'); ?></div>
            </div>

            <div class="md:col-span-3">
                <button type="submit" class="bg-navy text-white text-sm px-5 py-2 rounded hover:bg-navy-deep transition">Simpan & terbitkan nomor</button>
            </div>
        </form>
    </div>

    
    <form method="GET" action="<?php echo e(route('brs.index')); ?>" class="flex flex-wrap gap-3 mb-4 items-end">
        <input type="hidden" name="tahun" value="<?php echo e($tahun); ?>">
        <div>
            <label class="block text-xs text-slate-500 mb-1">Cari judul</label>
            <input type="text" name="cari" value="<?php echo e($filterCari); ?>" class="border border-hairline rounded px-3 py-2 text-sm" placeholder="Kata kunci judul">
        </div>
        <div>
            <label class="block text-xs text-slate-500 mb-1">Kategori</label>
            <select name="kategori" class="border border-hairline rounded px-3 py-2 text-sm">
                <option value="">Semua kategori</option>
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->nama); ?>" <?php echo e($filterKategori == $k->nama ? 'selected' : ''); ?>><?php echo e($k->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block text-xs text-slate-500 mb-1">Tim</label>
            <select name="tim" class="border border-hairline rounded px-3 py-2 text-sm">
                <option value="">Semua tim</option>
                <?php $__currentLoopData = $tims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->nama); ?>" <?php echo e($filterTim == $t->nama ? 'selected' : ''); ?>><?php echo e($t->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="border border-hairline rounded px-4 py-2 text-sm hover:bg-white">Terapkan filter</button>
        <?php if($filterCari || $filterKategori || $filterTim): ?>
            <a href="<?php echo e(route('brs.index', ['tahun' => $tahun])); ?>" class="border border-hairline rounded px-4 py-2 text-sm text-slate-500 hover:bg-white">Reset</a>
        <?php endif; ?>
    </form>

    
    <div class="bg-white rounded-lg border border-hairline overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-hairline text-left text-xs uppercase text-slate-500">
                    <th class="px-4 py-3 w-12">No</th>
                    <th class="px-4 py-3">Nomor BRS</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Tim</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-hairline last:border-0 hover:bg-[#FAFAF8]">
                        <td class="px-4 py-3 text-slate-500"><?php echo e($entry->no_urut); ?></td>
                        <td class="px-4 py-3 font-mono-brs brass font-medium whitespace-nowrap"><?php echo e($entry->nomor_brs); ?></td>
                        <td class="px-4 py-3 max-w-md"><?php echo e($entry->judul); ?></td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded bg-brass-soft brass"><?php echo e($entry->kategori); ?></span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap"><?php echo e($entry->tanggal_rilis->format('d-m-Y')); ?></td>
                        <td class="px-4 py-3"><?php echo e($entry->penanggung_jawab); ?></td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="<?php echo e(route('brs.edit', $entry)); ?>" class="text-slate-500 hover:text-navy mr-3">Ubah</a>
                            <form action="<?php echo e(route('brs.destroy', $entry)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus entri ini? Nomor BRS lain di tahun <?php echo e($tahun); ?> akan dihitung ulang.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-700 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-400">Belum ada BRS terdaftar untuk tahun <?php echo e($tahun); ?>.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        const kodeWilayah = <?php echo json_encode(\App\Models\Setting::get('kode_wilayah', '1674'), 512) ?>;
        const tahunRomawi = <?php echo json_encode($tahunRomawi ?? '?', 15, 512) ?>;
        const nextUrut = <?php echo e($entries->count() + 1); ?>;

        function toggleBaru(selectId, inputId) {
            const select = document.getElementById(selectId);
            const input = document.getElementById(inputId);
            select.addEventListener('change', () => {
                if (select.value === '__baru__') {
                    input.classList.remove('hidden');
                    input.focus();
                    select.name = select.name === 'kategori' ? '_kategori_disabled' : '_tim_disabled';
                } else {
                    input.classList.add('hidden');
                    input.value = '';
                    select.name = selectId === 'kategori-select' ? 'kategori' : 'penanggung_jawab';
                }
            });
        }
        toggleBaru('kategori-select', 'kategori-baru');
        toggleBaru('tim-select', 'tim-baru');

        function updatePreview() {
            const tgl = document.getElementById('tanggal_rilis').value;
            const bulan = tgl ? tgl.split('-')[1] : '--';
            const urut = String(nextUrut).padStart(2, '0');
            document.getElementById('preview-nomor').textContent = `${urut}/${bulan}/${kodeWilayah}/Th.${tahunRomawi}`;
        }
        document.getElementById('tanggal_rilis').addEventListener('input', updatePreview);
        updatePreview();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\raven\Downloads\laravel-brs-agenda-penomoran\agenda-brs\resources\views/brs/index.blade.php ENDPATH**/ ?>