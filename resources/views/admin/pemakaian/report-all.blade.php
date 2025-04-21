<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pemakaian Listrik</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <h2 style="text-align: center;">Laporan Pemakaian Listrik</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>No Kontrol</th>
        <th>Nama Pelanggan</th>
        <th>Periode</th>
        <th>Meter Awal</th>
        <th>Meter Akhir</th>
        <th>Pemakaian</th>
        <th>Total Bayar</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pemakaians as $index => $pemakaian)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $pemakaian->pelanggan->no_kontrol }}</td>
          <td>{{ $pemakaian->pelanggan->name }}</td>
          <td>{{ date('F Y', mktime(0, 0, 0, $pemakaian->bulan, 1, $pemakaian->tahun)) }}</td>
          <td>{{ number_format($pemakaian->meter_awal) }}</td>
          <td>{{ number_format($pemakaian->meter_akhir) }}</td>
          <td>{{ number_format($pemakaian->jumlah_pakai) }}</td>
          <td>Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</td>
          <td>{{ $pemakaian->is_status ? 'Lunas' : 'Belum Lunas' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
