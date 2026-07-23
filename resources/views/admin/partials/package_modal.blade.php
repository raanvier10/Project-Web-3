<div id="packageModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
  <style>
/* Fallback styles for category radio buttons */
input[type="radio"][value="adult"]:checked + div {
    background-color: #fdf2f8 !important;
    border-color: #ec4899 !important;
}
input[type="radio"][value="teens"]:checked + div {
    background-color: #eff6ff !important;
    border-color: #3b82f6 !important;
}
input[type="radio"][value="kids"]:checked + div {
    background-color: #faf5ff !important;
    border-color: #a855f7 !important;
}
input[type="radio"]:checked + div {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
}
input[type="radio"]:checked + div > div {
    transform: scale(1.1);
}
</style>
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
        <label class="form-label mb-2 block">Kategori</label>
        <div class="grid grid-cols-3 gap-3">
          <label class="relative cursor-pointer">
            <input type="radio" name="category" value="adult" class="peer sr-only" required>
            <div class="rounded-xl border border-gray-200 p-2 text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:shadow-sm hover:bg-gray-50">
              <span class="text-xs font-bold text-gray-700">Dewasa</span>
            </div>
          </label>
          <label class="relative cursor-pointer">
            <input type="radio" name="category" value="teens" class="peer sr-only" required>
            <div class="rounded-xl border border-gray-200 p-2 text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm hover:bg-gray-50">
              <span class="text-xs font-bold text-gray-700">Teens</span>
            </div>
          </label>
          <label class="relative cursor-pointer">
            <input type="radio" name="category" value="kids" class="peer sr-only" required>
            <div class="rounded-xl border border-gray-200 p-2 text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:shadow-sm hover:bg-gray-50">
              <span class="text-xs font-bold text-gray-700">Kids</span>
            </div>
          </label>
        </div>
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
