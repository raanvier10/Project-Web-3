<div id="paymentDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="bg-white rounded-2xl shadow-2xl p-6 relative w-full max-w-3xl z-10">
    <div class="flex items-start justify-between mb-4">
      <div>
        <h3 class="text-lg font-bold" id="pd_invoice">Detail Invoice</h3>
        <p class="text-sm text-gray-500" id="pd_meta">—</p>
      </div>
      <button class="text-gray-400" data-modal-close="paymentDetailModal">&times;</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <div class="mb-3">
          <p class="text-xs text-gray-500 mb-1">Invoice</p>
          <p class="font-semibold" id="pd_invoice_no">-</p>
        </div>
        <div class="mb-3">
          <p class="text-xs text-gray-500 mb-1">Nama</p>
          <p id="pd_name">-</p>
        </div>
        <div class="mb-3">
          <p class="text-xs text-gray-500 mb-1">Paket</p>
          <p id="pd_package">-</p>
        </div>
        <div class="mb-3">
          <p class="text-xs text-gray-500 mb-1">Jumlah</p>
          <p id="pd_amount">-</p>
        </div>
      </div>
      <div>
        <p class="text-xs text-gray-500 mb-2">Bukti Pembayaran</p>
        <div class="border rounded-lg p-2">
          <img id="pd_proof_image" src="" alt="Bukti Pembayaran" class="w-full h-56 object-contain bg-gray-100 rounded-lg" />
        </div>
        <div class="mt-3 flex items-center gap-3">
          <button class="btn-primary" id="pd_accept_btn">Accept</button>
          <button class="btn-secondary" id="pd_reject_btn">Reject</button>
        </div>
      </div>
    </div>

    <!-- Reject reason -->
    <div id="pd_reject_area" class="mt-4 hidden">
      <form id="pd_reject_form" data-ajax="true">
        @csrf
        <div>
          <label class="form-label">Alasan Penolakan</label>
          <textarea name="reason" class="form-input-premium" rows="3" placeholder="Contoh: Bukti buram"></textarea>
        </div>
        <div class="flex items-center justify-end gap-3 mt-3">
          <button type="button" class="btn-secondary" data-modal-close="paymentDetailModal">Batal</button>
          <button type="submit" class="btn-primary">Kirim Penolakan</button>
        </div>
      </form>
    </div>
  </div>
</div>
