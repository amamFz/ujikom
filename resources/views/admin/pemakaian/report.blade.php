<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pemakaian Listrik</title>
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
        }

        .customer-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .customer-info h2 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #1f2937;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            font-size: 14px;
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

        .status {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-unpaid {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .calculation {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .calculation h3 {
            margin: 0 0 15px;
            font-size: 16px;
            color: #1f2937;
        }

        .calc-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 8px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .calc-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #e5e7eb;
            padding-top: 12px;
            margin-top: 12px;
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
        <h1>LAPORAN PEMAKAIAN LISTRIK</h1>
        <p>{{ $single ? 'Detail Pemakaian' : 'Periode: ' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</p>
    </div>

    @if ($single)
        <div class="customer-info">
            <h2>Informasi Pelanggan</h2>
            <div class="info-grid">
                <div>
                    <div class="info-item">
                        <span class="info-label">No Kontrol:</span>
                        <span>{{ $pemakaians->first()->no_kontrol_id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nama:</span>
                        <span>{{ $pemakaians->first()->pelanggan->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Alamat:</span>
                        <span>{{ $pemakaians->first()->pelanggan->alamat }}</span>
                    </div>
                </div>
                <div>
                    <div class="info-item">
                        <span class="info-label">Jenis Pelanggan:</span>
                        <span>{{ $pemakaians->first()->pelanggan->jenis_pelanggan->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tarif per kWh:</span>
                        <span>Rp
                            {{ number_format($pemakaians->first()->pelanggan->tarif->tarif_kwh, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Periode:</span>
                        <span>{{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if (!$single)
                    <th>No Kontrol</th>
                @endif
                @if (!$single)
                    <th>Nama Pelanggan</th>
                @endif
                <th class="text-right">Meter Awal</th>
                <th class="text-right">Meter Akhir</th>
                <th class="text-right">Pemakaian</th>
                <th class="text-right">Biaya Beban</th>
                <th class="text-right">Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemakaians as $index => $pemakaian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if (!$single)
                        <td>{{ $pemakaian->no_kontrol_id }}</td>
                    @endif
                    @if (!$single)
                        <td>{{ $pemakaian->pelanggan->name }}</td>
                    @endif
                    <td class="text-right">{{ number_format($pemakaian->meter_awal) }}</td>
                    <td class="text-right">{{ number_format($pemakaian->meter_akhir) }}</td>
                    <td class="text-right">{{ number_format($pemakaian->jumlah_pakai) }}</td>
                    <td class="text-right">Rp {{ number_format($pemakaian->biaya_beban_pemakai, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status {{ $pemakaian->is_status ? 'status-paid' : 'status-unpaid' }}">
                            {{ $pemakaian->is_status ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($single)
        <div class="calculation">
            <h3>Rincian Perhitungan</h3>
            <div class="calc-item">
                <span>Pemakaian</span>
                <span>{{ number_format($pemakaians->first()->jumlah_pakai) }} kWh</span>
            </div>
            <div class="calc-item">
                <span>Biaya per kWh</span>
                <span>Rp {{ number_format($pemakaians->first()->pelanggan->tarif->tarif_kwh, 0, ',', '.') }}</span>
            </div>
            <div class="calc-item">
                <span>Biaya Pemakaian</span>
                <span>Rp {{ number_format($pemakaians->first()->biaya_pemakaian, 0, ',', '.') }}</span>
            </div>
            <div class="calc-item">
                <span>Biaya Beban</span>
                <span>Rp {{ number_format($pemakaians->first()->biaya_beban_pemakai, 0, ',', '.') }}</span>
            </div>
            <div class="calc-item calc-total">
                <span>Total Tagihan</span>
                <span>Rp {{ number_format($pemakaians->first()->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>
    @else
        <div class="summary">
            <h3>Ringkasan</h3>
            <div class="summary-grid">
                <div>
                    <p>Total Pemakaian: {{ number_format($pemakaians->sum('jumlah_pakai')) }} kWh</p>
                    <p>Total Biaya Beban: Rp {{ number_format($pemakaians->sum('biaya_beban_pemakai'), 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p>Total Tagihan: Rp {{ number_format($pemakaians->sum('total_bayar'), 0, ',', '.') }}</p>
                    <p>Jumlah Pelanggan: {{ $pemakaians->count() }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Petugas: {{ Auth::user()->name }}</p>
    </div>
</body>

</html>
