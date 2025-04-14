<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Pemakaian Listrik</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
      font-size: 12px;
    }

    th {
      background-color: #f2f2f2;
    }

    .footer {
      margin-top: 30px;
      text-align: right;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>LAPORAN DATA PEMAKAIAN Listrik</h1>
    <p>Periode: {{ date('F Y') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>No Kontrol</th>
        <th>Nama Pelanggan</th>
        <th>Meter Awal</th>
        <th>Meter Akhir</th>
        <th>Jumlah Pakai</th>
        <th>Biaya Beban</th>
        <th>Biaya Pemakaian</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pemakaians as $index => $pemakaian)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $pemakaian->no_kontrol_id }}</td>
          <td>{{ $pemakaian->pelanggan->name }}</td>
          <td>{{ $pemakaian->meter_awal }}</td>
          <td>{{ $pemakaian->meter_akhir }}</td>
          <td>{{ $pemakaian->jumlah_pakai }}</td>
          <td>Rp {{ number_format($pemakaian->biaya_beban_pemakai, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    <p>Petugas: {{ Auth::user()->name }}</p>
  </div>
</body>

</html>
