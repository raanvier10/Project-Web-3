<div id="registrationDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="bg-white rounded-2xl shadow-2xl p-6 relative w-full max-w-2xl z-10">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold">Detail Peserta</h3>
      <button class="text-gray-400" data-modal-close="registrationDetailModal">&times;</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <p class="text-xs text-gray-500">Nama</p>
        <p id="rd_name" class="font-semibold">-</p>

        <p class="text-xs text-gray-500 mt-3">Email</p>
        <p id="rd_email">-</p>

        <p class="text-xs text-gray-500 mt-3">Asal Instansi</p>
        <p id="rd_institution">-</p>
      </div>
      <div>
        <p class="text-xs text-gray-500">Paket Kursus</p>
        <p id="rd_package">-</p>

        <p class="text-xs text-gray-500 mt-3">Status Pembayaran</p>
        <p id="rd_payment_status" class="status-badge status-paid">-</p>
      </div>
    </div>
  </div>
</div>
