@extends('admin.layout')

@section('admin-content')

<div class="section-container">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Manajemen Paket Kursus</h2>
    <div class="flex items-center gap-3">
      <button class="btn-primary" data-modal-open="packageModal">Tambah Paket</button>
    </div>
  </div>

  <div class="dashboard-card overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500">
          <th class="py-3 pr-4">#</th>
          <th class="py-3 pr-4">Nama Paket</th>
          <th class="py-3 pr-4">Kategori</th>
          <th class="py-3 pr-4">Harga</th>
          <th class="py-3 pr-4">Status</th>
          <th class="py-3 pr-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($packages as $pkg)
        <tr class="border-t">
          <td class="py-3 pr-4">{{ $loop->iteration }}</td>
          <td class="py-3 pr-4">{{ $pkg->title }}</td>
          <td class="py-3 pr-4">{{ $pkg->category ?? '-' }}</td>
          <td class="py-3 pr-4">Rp {{ number_format($pkg->price ?? 0,0,',','.') }}</td>
          <td class="py-3 pr-4">
            <span class="status-badge {{ $pkg->is_active ? 'status-paid' : 'status-rejected' }}">{{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}</span>
          </td>
          <td class="py-3 pr-4">
            <div class="flex items-center gap-2">
              <button class="btn-secondary text-xs" data-modal-open="packageModal" data-package='@json($pkg)'>Edit</button>
              <button class="btn-secondary text-xs" data-action="toggle-active" data-id="{{ $pkg->id }}" data-url="{{ route('admin.packages.toggle', $pkg->id) }}">{{ $pkg->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
              <button class="text-red-600 text-xs" data-action="delete" data-url="{{ route('admin.packages.destroy', $pkg->id) }}">Hapus</button>
            </div>
          </td>
        </tr>
        @endforeach
        @if(count($packages)===0)
        <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada paket.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

@include('admin.partials.package_modal')

@endsection

@section('admin-scripts')
<script>
  // Placeholder: ensure modals can receive package JSON
  document.querySelectorAll('[data-modal-open="packageModal"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const modal = document.getElementById('packageModal');
      const pkgData = btn.getAttribute('data-package');
      if (pkgData) {
        const pkg = JSON.parse(pkgData);
        modal.querySelector('form').action = '/admin/course-packages/' + pkg.id;
        modal.querySelector('[name="_method"]').value = 'PUT';
        modal.querySelector('[name="title"]').value = pkg.title || '';
        modal.querySelector('[name="price"]').value = pkg.price || '';
        modal.querySelector('[name="category"]').value = pkg.category || '';
        modal.querySelector('[name="description"]').value = pkg.description || '';
      } else {
        const form = modal.querySelector('form');
        form.action = '{{ route('admin.packages.store') }}';
        modal.querySelector('[name="_method"]').value = 'POST';
        modal.querySelector('form').reset();
      }
      modal.classList.remove('hidden');
    });
  });
</script>
@endsection
