<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Excel</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: sans-serif; font-size: 12px; }
        th, td { border: 1px solid #000000; padding: 5px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .no-border { border: none; }
        .title { font-size: 14px; font-weight: bold; text-align: center; border: none; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="10" class="title">LAPORAN PENDAFTARAN KURSUS EFA</td>
        </tr>
        <tr>
            <td colspan="10" class="no-border"></td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Tanggal</td>
            <td colspan="7" class="no-border">: {{ $tanggalText }}</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Paket Kursus</td>
            <td colspan="7" class="no-border">: {{ $paketText }}</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Status</td>
            <td colspan="7" class="no-border">: {{ $statusText }}</td>
        </tr>
        <tr>
            <td colspan="10" class="no-border"></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Daftar</th>
                <th>No. Registrasi</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Asal/Domisili</th>
                <th>Paket Kursus</th>
                <th>Kategori</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $i => $reg)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $reg->registration_number }}</td>
                <td>{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</td>
                <td>{{ $reg->user->email }}</td>
                <td>{{ $reg->detail ? ($reg->detail->phone ?? $reg->detail->parent_phone) : $reg->user->phone }}</td>
                <td>{{ $reg->detail ? $reg->detail->domicile : '-' }}</td>
                <td>{{ $reg->coursePackage->name }}</td>
                <td>{{ $reg->coursePackage->category === 'kids' ? 'Kids' : 'Dewasa' }}</td>
                <td>{{ $reg->payment ? $reg->payment->amount : 0 }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="9" style="text-align: right; font-weight: bold;">Total Pendapatan Filter Saat Ini:</td>
                <td style="font-weight: bold;">{{ $registrations->filter(fn($reg) => $reg->payment && $reg->payment->payment_status === 'valid')->sum(fn($reg) => $reg->payment->amount) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
