@extends('layouts.admin')

@section('page-title', 'Manajemen Paket Kursus')
@section('page-subtitle', 'Tambah, edit, dan kelola paket kursus')

@section('admin-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(232,105,159,0.08), rgba(199,78,131,0.04)); border: 1px solid rgba(232,105,159,0.12);">
            <i class="fas fa-box-open text-primary-600 text-xs"></i>
            <span class="text-primary-700 text-xs font-semibold">Paket Kursus</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Manajemen Paket Kursus</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Kelola semua paket kursus yang tersedia untuk peserta.</p>
    </div>
    <button onclick="openModal('addPackageModal')" class="admin-btn admin-btn-primary" id="btn-add-package">
        <i class="fas fa-plus mr-2"></i> Tambah Paket
    </button>
</div>

{{-- Packages Table --}}
<div class="admin-float-card !p-0 overflow-hidden" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <div class="overflow-x-auto">
        <table class="admin-table min-w-[900px] whitespace-nowrap">
            <thead>
                <tr>
                    <th>Paket</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah Pertemuan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $index => $package)
                <tr style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.05 }}s; opacity: 0;">
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, {{ $package->category === 'kids' ? '#F3E8FF, #E9D5FF' : '#FFE0EC, #FFC2D9' }});">
                                <i class="fas {{ $package->category === 'kids' ? 'fa-child text-purple-500' : 'fa-user-graduate text-primary-600' }} text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $package->name }}</p>
                                @if($package->descriptions)
                                <p class="text-gray-400 text-xs mt-0.5 truncate max-w-[200px]">{{ $package->descriptions }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $package->category === 'kids' ? 'text-purple-600 bg-purple-50' : 'text-primary-700 bg-primary-50' }}">
                            {{ $package->category_label }}
                        </span>
                    </td>
                    <td>
                        @if($package->has_discount)
                        <div class="text-xs text-gray-400 line-through mb-0.5">{{ $package->formatted_original_price }}</div>
                        @endif
                        <div class="font-bold text-gray-900">{{ $package->formatted_price }}</div>
                    </td>
                    <td class="text-gray-600">{{ $package->amount }} pertemuan</td>
                    <td>
                        <div class="toggle-switch {{ $package->is_active ? 'active' : 'inactive' }}" onclick="togglePackageStatus({{ $package->id }}, this)" data-id="{{ $package->id }}" id="toggle-pkg-{{ $package->id }}">
                            <div class="toggle-knob"></div>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick="openEditModal({{ json_encode($package) }})" class="w-9 h-9 rounded-xl flex items-center justify-center text-primary-700 hover:bg-primary-50 transition-colors" title="Edit" id="btn-edit-pkg-{{ $package->id }}">
                                <i class="fas fa-pen-to-square text-sm"></i>
                            </button>
                            <button onclick="openDeleteModal({{ $package->id }}, '{{ $package->name }}', {{ $package->registrations_count ?? $package->registrations()->count() }})" class="w-9 h-9 rounded-xl flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors" title="Hapus" id="btn-delete-pkg-{{ $package->id }}">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <i class="fas fa-box-open text-2xl text-primary-300"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Belum ada paket kursus</p>
                        <p class="text-gray-400 text-xs">Klik tombol "Tambah Paket" untuk memulai.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- ADD PACKAGE MODAL         --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="addPackageModalOverlay" onclick="closeModal('addPackageModal')"></div>
<div class="admin-modal" id="addPackageModal">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                <i class="fas fa-plus text-primary-700"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Tambah Paket Kursus</h3>
        </div>
        <button onclick="closeModal('addPackageModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <form method="POST" action="{{ route('admin.packages.store') }}" id="addPackageForm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="admin-form-label"><i class="fas fa-tag mr-2 text-primary-400 text-xs"></i> Nama Paket</label>
                    <input type="text" name="name" class="admin-form-input" placeholder="Contoh: Paket Reguler 3 Bulan" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-layer-group mr-2 text-primary-400 text-xs"></i> Kategori</label>
                    <select name="category" class="admin-form-select" required>
                        <option value="adult">Dewasa</option>
                        <option value="kids">Kids</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-money-bill mr-2 text-primary-400 text-xs"></i> Harga Jual / Final (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="price" id="add-price" class="admin-form-input" placeholder="500000" min="0" required>
                        <p class="text-[10px] text-gray-400 mt-1">Harga yang dibayar peserta.</p>
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-strikethrough mr-2 text-gray-400 text-xs"></i> Harga Asli Dicoret <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="number" name="original_price" id="add-original_price" class="admin-form-input" placeholder="Isi jika ada diskon" min="0">
                        <p class="text-[10px] text-gray-400 mt-1">Harus lebih besar dari harga jual.</p>
                        <p class="text-[10px] text-amber-600 mt-0.5 hidden" id="add-discount-warn"><i class="fas fa-exclamation-triangle mr-1"></i>Harga asli harus lebih besar dari harga jual.</p>
                    </div>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-calendar-alt mr-2 text-primary-400 text-xs"></i> Jumlah Pertemuan</label>
                    <input type="number" name="amount" class="admin-form-input" placeholder="24" min="0" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fab fa-whatsapp mr-2 text-green-500 text-xs"></i> Link Grup WhatsApp <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="url" name="whatsapp_link" class="admin-form-input" placeholder="https://chat.whatsapp.com/..." maxlength="255">
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-align-left mr-2 text-primary-400 text-xs"></i> Deskripsi</label>
                    <textarea name="descriptions" class="admin-form-textarea" placeholder="Tuliskan deskripsi paket kursus..."></textarea>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-list-check mr-2 text-primary-400 text-xs"></i> Fasilitas Program</label>
                    <textarea name="features" class="admin-form-textarea" placeholder="Gunakan tanda | sebagai pemisah. Contoh: Sertifikat | Modul Belajar | Grup WhatsApp"></textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Gunakan pemisah pipa ( | ) untuk membuat daftar fasilitas.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500" id="add-is-active">
                    <label for="add-is-active" class="text-sm font-semibold text-gray-700">Aktifkan paket ini</label>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeModal('addPackageModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
                <button type="submit" class="admin-btn admin-btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- EDIT PACKAGE MODAL        --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="editPackageModalOverlay" onclick="closeModal('editPackageModal')"></div>
<div class="admin-modal" id="editPackageModal">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                <i class="fas fa-pen text-blue-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Edit Paket Kursus</h3>
        </div>
        <button onclick="closeModal('editPackageModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <form method="POST" id="editPackageForm">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="admin-form-label"><i class="fas fa-tag mr-2 text-blue-400 text-xs"></i> Nama Paket</label>
                    <input type="text" name="name" class="admin-form-input" id="edit-name" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-layer-group mr-2 text-blue-400 text-xs"></i> Kategori</label>
                    <select name="category" class="admin-form-select" id="edit-category" required>
                        <option value="adult">Dewasa</option>
                        <option value="kids">Kids</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-money-bill mr-2 text-blue-400 text-xs"></i> Harga Jual / Final (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="price" class="admin-form-input" id="edit-price" min="0" required>
                        <p class="text-[10px] text-gray-400 mt-1">Harga yang dibayar peserta.</p>
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-strikethrough mr-2 text-gray-400 text-xs"></i> Harga Asli Dicoret <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="number" name="original_price" class="admin-form-input" id="edit-original_price" min="0" placeholder="Isi jika ada diskon">
                        <p class="text-[10px] text-gray-400 mt-1">Harus lebih besar dari harga jual.</p>
                        <p class="text-[10px] text-amber-600 mt-0.5 hidden" id="edit-discount-warn"><i class="fas fa-exclamation-triangle mr-1"></i>Harga asli harus lebih besar dari harga jual.</p>
                    </div>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-calendar-alt mr-2 text-blue-400 text-xs"></i> Jumlah Pertemuan</label>
                    <input type="number" name="amount" class="admin-form-input" id="edit-amount" min="0" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fab fa-whatsapp mr-2 text-green-500 text-xs"></i> Link Grup WhatsApp <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="url" name="whatsapp_link" class="admin-form-input" id="edit-whatsapp_link" placeholder="https://chat.whatsapp.com/..." maxlength="255">
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-align-left mr-2 text-blue-400 text-xs"></i> Deskripsi</label>
                    <textarea name="descriptions" class="admin-form-textarea" id="edit-descriptions"></textarea>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-list-check mr-2 text-blue-400 text-xs"></i> Fasilitas Program</label>
                    <textarea name="features" class="admin-form-textarea" id="edit-features" placeholder="Contoh: Sertifikat | Modul Belajar"></textarea>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500" id="edit-is-active">
                    <label for="edit-is-active" class="text-sm font-semibold text-gray-700">Paket aktif</label>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeModal('editPackageModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
                <button type="submit" class="admin-btn admin-btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- DELETE CONFIRMATION MODAL --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="deletePackageModalOverlay" onclick="closeModal('deletePackageModal')"></div>
<div class="admin-modal" id="deletePackageModal" style="max-width: 420px;">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                <i class="fas fa-trash-alt text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Hapus Paket</h3>
        </div>
        <button onclick="closeModal('deletePackageModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <p class="text-gray-600 text-sm mb-2">Apakah Anda yakin ingin menghapus paket:</p>
        <p class="font-bold text-gray-900 text-lg mb-4" id="deletePackageName"></p>
        {{-- Warning if has registrants --}}
        <div id="deleteWarningBanner" class="hidden mb-4 p-3.5 rounded-xl flex items-start space-x-3" style="background: linear-gradient(135deg, rgba(251,191,36,0.08), rgba(245,158,11,0.04)); border: 1px solid rgba(251,191,36,0.2);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                <i class="fas fa-exclamation-triangle text-amber-500 text-sm"></i>
            </div>
            <div>
                <p class="text-amber-700 text-sm font-bold">Perhatian!</p>
                <p class="text-amber-600 text-xs mt-0.5">Paket ini memiliki <strong id="deleteRegistrantCount">0</strong> pendaftar. Paket akan dihapus dari daftar, namun riwayat pendaftaran dan pembayaran peserta <strong>tetap tersimpan</strong> untuk keperluan laporan.</p>
            </div>
        </div>
        <p class="text-gray-400 text-xs mb-6" id="deleteNote">Tindakan ini tidak dapat dibatalkan.</p>
        <form method="POST" id="deletePackageForm">
            @csrf
            @method('DELETE')
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('deletePackageModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
                <button type="submit" class="admin-btn admin-btn-danger flex-1">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal helpers
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.getElementById(id + 'Overlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.getElementById(id + 'Overlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    // Edit modal
    function openEditModal(pkg) {
        document.getElementById('edit-name').value = pkg.name;
        document.getElementById('edit-category').value = pkg.category;
        document.getElementById('edit-original_price').value = pkg.original_price ? parseFloat(pkg.original_price) : '';
        document.getElementById('edit-price').value = parseFloat(pkg.price);
        document.getElementById('edit-amount').value = pkg.amount;
        document.getElementById('edit-whatsapp_link').value = pkg.whatsapp_link || '';
        document.getElementById('edit-descriptions').value = pkg.descriptions || '';
        document.getElementById('edit-features').value = pkg.features || '';
        document.getElementById('edit-is-active').checked = pkg.is_active == 1 || pkg.is_active === true;
        document.getElementById('editPackageForm').action = '/admin/packages/' + pkg.id;
        document.getElementById('edit-discount-warn').classList.add('hidden');
        openModal('editPackageModal');
    }

    // Discount validation
    function validateDiscount(origId, priceId, warnId) {
        const orig = parseFloat(document.getElementById(origId).value);
        const price = parseFloat(document.getElementById(priceId).value);
        const warn = document.getElementById(warnId);
        if (!isNaN(orig) && !isNaN(price) && orig > 0 && orig <= price) {
            warn.classList.remove('hidden');
            return false;
        }
        warn.classList.add('hidden');
        return true;
    }
    document.getElementById('add-original_price').addEventListener('input', () => validateDiscount('add-original_price','add-price','add-discount-warn'));
    document.getElementById('add-price').addEventListener('input', () => validateDiscount('add-original_price','add-price','add-discount-warn'));
    document.getElementById('edit-original_price').addEventListener('input', () => validateDiscount('edit-original_price','edit-price','edit-discount-warn'));
    document.getElementById('edit-price').addEventListener('input', () => validateDiscount('edit-original_price','edit-price','edit-discount-warn'));
    document.getElementById('addPackageForm').addEventListener('submit', e => {
        if (!validateDiscount('add-original_price','add-price','add-discount-warn')) e.preventDefault();
    });
    document.getElementById('editPackageForm').addEventListener('submit', e => {
        if (!validateDiscount('edit-original_price','edit-price','edit-discount-warn')) e.preventDefault();
    });

    // Delete modal
    function openDeleteModal(id, name, regCount) {
        document.getElementById('deletePackageName').textContent = name;
        document.getElementById('deletePackageForm').action = '/admin/packages/' + id;

        // Show/hide warning banner based on registrant count
        const warningBanner = document.getElementById('deleteWarningBanner');
        if (regCount > 0) {
            warningBanner.classList.remove('hidden');
            document.getElementById('deleteRegistrantCount').textContent = regCount;
        } else {
            warningBanner.classList.add('hidden');
        }

        openModal('deletePackageModal');
    }

    // Toggle package active status via AJAX
    function togglePackageStatus(id, el) {
        fetch('/admin/packages/' + id + '/toggle', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                el.classList.toggle('active', data.is_active);
                el.classList.toggle('inactive', !data.is_active);
            }
        })
        .catch(err => console.error('Toggle error:', err));
    }

    // Close modals with Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            ['addPackageModal', 'editPackageModal', 'deletePackageModal'].forEach(closeModal);
        }
    });
</script>
@endsection
