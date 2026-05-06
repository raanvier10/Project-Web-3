@extends('layouts.owner')

@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola akun admin dan staff untuk operasional')

@section('owner-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(37,99,235,0.04)); border: 1px solid rgba(59,130,246,0.12);">
            <i class="fas fa-user-gear text-blue-500 text-xs"></i>
            <span class="text-blue-600 text-xs font-semibold">Pengguna</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Manajemen Admin & Staff</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Tambah, edit, dan hapus akun admin atau staff.</p>
    </div>
    <button onclick="openModal('addStaffModal')" class="admin-btn admin-btn-primary" id="btn-add-staff">
        <i class="fas fa-plus mr-2"></i> Tambah Pengguna
    </button>
</div>

{{-- Search --}}
<div class="admin-float-card !p-4 mb-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <form method="GET" action="{{ route('owner.staff') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-search w-full" placeholder="Cari nama, email, atau telepon..." id="search-staff">
        </div>
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
            <i class="fas fa-filter mr-1.5"></i> Cari
        </button>
        @if(request()->has('search'))
        <a href="{{ route('owner.staff') }}" class="admin-btn admin-btn-outline admin-btn-sm">
            <i class="fas fa-times mr-1.5"></i> Reset
        </a>
        @endif
    </form>
</div>

{{-- Staff Table --}}
<div class="admin-float-card !p-0 overflow-hidden" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Telepon</th>
                    <th>Peran</th>
                    <th>Tgl Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $index => $member)
                <tr style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ ($index * 0.04) + 0.15 }}s; opacity: 0;">
                    <td class="text-gray-400 font-mono text-sm">{{ $index + 1 }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                                <i class="fas fa-user text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $member->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $member->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-gray-600 text-sm">{{ $member->phone ?? '-' }}</td>
                    <td>
                        @if($member->role === 'admin')
                            <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold">Admin</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Staff</span>
                        @endif
                    </td>
                    <td class="text-gray-500 text-sm">{{ $member->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick='openEditModal({{ json_encode(["id" => $member->id, "name" => $member->name, "email" => $member->email, "phone" => $member->phone, "role" => $member->role]) }})' class="w-9 h-9 rounded-xl flex items-center justify-center text-primary-700 hover:bg-primary-50 transition-colors" title="Edit" id="btn-edit-staff-{{ $member->id }}">
                                <i class="fas fa-pen-to-square text-sm"></i>
                            </button>
                            <button onclick='openDeleteModal({{ $member->id }}, {{ json_encode($member->name) }})' class="w-9 h-9 rounded-xl flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors" title="Hapus" id="btn-delete-staff-{{ $member->id }}">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                            <i class="fas fa-user-gear text-2xl text-blue-300"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Belum ada pengguna</p>
                        <p class="text-gray-400 text-xs">Klik tombol "Tambah Pengguna" untuk memulai.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- ADD STAFF MODAL           --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="addStaffModalOverlay" onclick="closeModal('addStaffModal')"></div>
<div class="admin-modal" id="addStaffModal">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                <i class="fas fa-user-plus text-blue-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Tambah Pengguna</h3>
        </div>
        <button onclick="closeModal('addStaffModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <form method="POST" action="{{ route('owner.staff.store') }}" id="addStaffForm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="admin-form-label"><i class="fas fa-user mr-2 text-blue-400 text-xs"></i> Nama</label>
                    <input type="text" name="name" class="admin-form-input" placeholder="Nama staff" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-envelope mr-2 text-blue-400 text-xs"></i> Email</label>
                    <input type="email" name="email" class="admin-form-input" placeholder="email@contoh.com" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-user-tag mr-2 text-blue-400 text-xs"></i> Peran (Role)</label>
                        <select name="role" class="admin-form-input" required>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-phone mr-2 text-blue-400 text-xs"></i> Telepon</label>
                        <input type="text" name="phone" class="admin-form-input" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-lock mr-2 text-blue-400 text-xs"></i> Password</label>
                        <input type="password" name="password" class="admin-form-input" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-lock mr-2 text-blue-400 text-xs"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="admin-form-input" placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeModal('addStaffModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
                <button type="submit" class="admin-btn admin-btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- EDIT STAFF MODAL          --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="editStaffModalOverlay" onclick="closeModal('editStaffModal')"></div>
<div class="admin-modal" id="editStaffModal">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                <i class="fas fa-pen text-blue-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Edit Pengguna</h3>
        </div>
        <button onclick="closeModal('editStaffModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <form method="POST" id="editStaffForm">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="admin-form-label"><i class="fas fa-user mr-2 text-blue-400 text-xs"></i> Nama</label>
                    <input type="text" name="name" class="admin-form-input" id="edit-name" required>
                </div>
                <div>
                    <label class="admin-form-label"><i class="fas fa-envelope mr-2 text-blue-400 text-xs"></i> Email</label>
                    <input type="email" name="email" class="admin-form-input" id="edit-email" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-user-tag mr-2 text-blue-400 text-xs"></i> Peran (Role)</label>
                        <select name="role" class="admin-form-input" id="edit-role" required>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-phone mr-2 text-blue-400 text-xs"></i> Telepon</label>
                        <input type="text" name="phone" class="admin-form-input" id="edit-phone" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label"><i class="fas fa-lock mr-2 text-blue-400 text-xs"></i> Password</label>
                        <input type="password" name="password" class="admin-form-input" id="edit-password" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div>
                        <label class="admin-form-label"><i class="fas fa-lock mr-2 text-blue-400 text-xs"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="admin-form-input" id="edit-password-confirmation" placeholder="Ulangi password">
                    </div>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeModal('editStaffModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
                <button type="submit" class="admin-btn admin-btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- DELETE STAFF MODAL        --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="deleteStaffModalOverlay" onclick="closeModal('deleteStaffModal')"></div>
<div class="admin-modal" id="deleteStaffModal" style="max-width: 420px;">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                <i class="fas fa-trash-alt text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Hapus Pengguna</h3>
        </div>
        <button onclick="closeModal('deleteStaffModal')" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        <p class="text-gray-600 text-sm mb-2">Apakah Anda yakin ingin menghapus pengguna:</p>
        <p class="font-bold text-gray-900 text-lg mb-4" id="deleteStaffName"></p>
        <p class="text-gray-400 text-xs mb-6">Tindakan ini tidak dapat dibatalkan.</p>
        <form method="POST" id="deleteStaffForm">
            @csrf
            @method('DELETE')
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('deleteStaffModal')" class="admin-btn admin-btn-outline flex-1">Batal</button>
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
    const updateUrlTemplate = "{{ route('owner.staff.update', ['user' => '__id__']) }}";
    const deleteUrlTemplate = "{{ route('owner.staff.delete', ['user' => '__id__']) }}";

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

    function openEditModal(staff) {
        document.getElementById('edit-name').value = staff.name || '';
        document.getElementById('edit-email').value = staff.email || '';
        document.getElementById('edit-phone').value = staff.phone || '';
        document.getElementById('edit-role').value = staff.role || 'staff';
        document.getElementById('edit-password').value = '';
        document.getElementById('edit-password-confirmation').value = '';

        const form = document.getElementById('editStaffForm');
        form.action = updateUrlTemplate.replace('__id__', staff.id);

        openModal('editStaffModal');
    }

    function openDeleteModal(id, name) {
        const form = document.getElementById('deleteStaffForm');
        form.action = deleteUrlTemplate.replace('__id__', id);
        document.getElementById('deleteStaffName').textContent = name || '';

        openModal('deleteStaffModal');
    }
</script>
@endsection
