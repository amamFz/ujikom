<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Semua Pemakaian Listrik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
        }

        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            color: #4b5563;
        }

        .filter-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .filter-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }

        th {
            background-color: #f8fafc;
            font-weight: bold;
            text-align: left;
            color: #1f2937;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
        }

        .status-lunas {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-belum {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .summary {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .summary h3 {
            margin: 0 0 15px;
            color: #1f2937;
            font-size: 16px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 14px;
            color: #6b7280;
        }

        @page {
            margin: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN SEMUA PEMAKAIAN LISTRIK</h1>
        <p>Data Pemakaian Listrik Keseluruhan</p>
    </div>

    <div class="filter-info">
        <p><strong>Filter yang diterapkan:</strong></p>
        @if (isset($tahun) && $tahun)
            <p>Tahun: {{ $tahun }}</p>
        @endif
        @if (isset($bulan) && $bulan)
            <p>Bulan: {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</p>
        @endif
        @if (isset($status))
            <p>Status: {{ $status ? 'Lunas' : 'Belum Lunas' }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Kontrol</th>
                <th>Nama Pelanggan</th>
                <th>Periode</th>
                <th class="text-right">Meter Awal</th>
                <th class="text-right">Meter Akhir</th>
                <th class="text-right">Pemakaian</th>
                <th class="text-right">Total Bayar</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemakaians as $index => $pemakaian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pemakaian->no_kontrol_id }}</td>
                    <td>{{ $pemakaian->pelanggan->name }}</td>
                    <td>{{ date('F Y', mktime(0, 0, 0, $pemakaian->bulan, 1, $pemakaian->tahun)) }}</td>
                    <td class="text-right">{{ number_format($pemakaian->meter_awal) }}</td>
                    <td class="text-right">{{ number_format($pemakaian->meter_akhir) }}</td>
                    <td class="text-right">{{ number_format($pemakaian->jumlah_pakai) }}</td>
                    <td class="text-right">Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status-badge {{ $pemakaian->is_status ? 'status-lunas' : 'status-belum' }}">
                            {{ $pemakaian->is_status ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data pemakaian</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-grid">
            <div>
                <p><strong>Total Record:</strong> {{ $pemakaians->count() }}</p>
                <p><strong>Total Pemakaian:</strong> {{ number_format($pemakaians->sum('jumlah_pakai')) }} kWh</p>
                <p><strong>Total Biaya Beban:</strong> Rp
                    {{ number_format($pemakaians->sum('biaya_beban_pemakai'), 0, ',', '.') }}</p>
            </div>
            <div>
                <p><strong>Total Tagihan:</strong> Rp {{ number_format($pemakaians->sum('total_bayar'), 0, ',', '.') }}
                </p>
                <p><strong>Jumlah Lunas:</strong> {{ $pemakaians->where('is_status', 1)->count() }}</p>
                <p><strong>Jumlah Belum Lunas:</strong> {{ $pemakaians->where('is_status', 0)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Oleh: {{ Auth::user()->name }}</p>
    </div>
</body>

</html>
