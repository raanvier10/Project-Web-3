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
            <td colspan="5" class="title">LAPORAN KEUANGAN EFA</td>
        </tr>
        <tr>
            <td colspan="5" class="no-border"></td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Periode</td>
            <td colspan="3" class="no-border">: {{ $tanggalText }}</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Paket Kursus</td>
            <td colspan="3" class="no-border">: {{ $paketText }}</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">Status Transaksi</td>
            <td colspan="3" class="no-border">: {{ $statusText }}</td>
        </tr>
        <tr>
            <td colspan="5" class="no-border"></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Peserta</th>
                <th>Paket Kursus</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $i => $payment)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $payment->registration->user->name ?? 'User dihapus' }}</td>
                <td>{{ $payment->registration->coursePackage->name ?? 'Paket dihapus' }}</td>
                <td>{{ $payment->amount }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total Pendapatan Filter Saat Ini:</td>
                <td style="font-weight: bold;">{{ $payments->sum('amount') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
