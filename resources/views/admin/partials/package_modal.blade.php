<div id="packageModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="bg-white rounded-2xl shadow-2xl p-6 relative w-full max-w-2xl z-10">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold">Tambah / Edit Paket</h3>
      <button class="text-gray-400" data-modal-close="packageModal">&times;</button>
    </div>
    <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="_method" value="POST">
      <div>
        <label class="form-label">Nama Paket</label>
        <input name="title" class="form-input-premium" required>
      </div>
      <div>
        <label class="form-label">Kategori</label>
        <input name="category" class="form-input-premium">
      </div>
      <div>
        <label class="form-label">Harga (IDR)</label>
        <input name="price" type="number" class="form-input-premium">
      </div>
      <div>
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-input-premium" rows="4"></textarea>
      </div>
      <div class="flex items-center justify-end gap-3">
        <button type="button" class="btn-secondary" data-modal-close="packageModal">Batal</button>
        <button type="submit" class="btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
