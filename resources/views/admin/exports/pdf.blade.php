<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .no-border { border: none !important; }
        .title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 20px; text-transform: uppercase; }
        .info-table { border-collapse: collapse; width: auto; margin-bottom: 10px; font-size: 12px; }
        .info-table td { border: none; padding: 2px 5px 2px 0; font-weight: normal; }
    </style>
</head>
<body>
    <div class="title">LAPORAN PENDAFTARAN KURSUS EFA</div>

    <table class="info-table">
        <tr>
            <td width="100">Tanggal</td>
            <td width="10">:</td>
            <td>{{ $tanggalText }}</td>
        </tr>
        <tr>
            <td>Paket Kursus</td>
            <td>:</td>
            <td>{{ $paketText }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $statusText }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Tanggal Daftar</th>
                <th width="12%">No. Registrasi</th>
                <th width="15%">Nama Peserta</th>
                <th width="15%">Email</th>
                <th width="10%">Telepon</th>
                <th width="10%">Asal/Domisili</th>
                <th width="15%">Paket Kursus</th>
                <th width="8%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $i => $reg)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $reg->registration_number }}</td>
                <td>{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</td>
                <td>{{ $reg->user->email }}</td>
                <td>{{ $reg->detail ? ($reg->detail->phone ?? $reg->detail->parent_phone) : $reg->user->phone }}</td>
                <td>{{ $reg->detail ? $reg->detail->domicile : '-' }}</td>
                <td>{{ $reg->coursePackage->name }}</td>
                <td>{{ $reg->coursePackage->category === 'kids' ? 'Kids' : 'Dewasa' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
